<?php

namespace App\Service;

use App\Entity\JobPost;
use App\Repository\JobPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ExternalJobsFetcher
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
        private JobPostRepository $jobPostRepository,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchAndUpsert(string $feedUrl): int
    {
        $response = $this->httpClient->request('GET', $feedUrl, [
            'timeout' => 15,
        ]);

        $content = $response->getContent();

        $xml = new \SimpleXMLElement($content);
        $items = $xml->xpath('//position') ?: [];
        $upserted = 0;

        foreach ($items as $position) {
            $id = (string) ($position->id ?? '');
            $title = trim((string) ($position->name ?? ''));
            $description = $this->mergeJobDescriptions($position->jobDescriptions ?? null);
            $url = trim((string) ($position->links->link[0]['href'] ?? ''));

            if ('' === $id && '' === $url) {
                continue;
            }

            $externalId = '' !== $id ? $id : sha1($url.'|'.$title);
            $existing = $this->jobPostRepository->findOneByExternalId($externalId);

            if (!$existing) {
                $external = new JobPost(
                    'external@system.com',
                    $title,
                    $description,
                    JobPost::TYPE_EXTERNAL
                );

                // Set external job specific fields
                $external->setExternalId($externalId);
                $external->setUrl($url);
                $external->setRawXml($content);
                $external->setFetchedAt(new \DateTimeImmutable());
                $external->setSubcompany((string) ($position->subcompany ?? ''));
                $external->setOffice((string) ($position->office ?? ''));
                $external->setDepartment((string) ($position->department ?? ''));
                $external->setRecruitingCategory((string) ($position->recruitingCategory ?? ''));
                $external->setEmploymentType((string) ($position->employmentType ?? ''));
                $external->setSeniority((string) ($position->seniority ?? ''));
                $external->setSchedule((string) ($position->schedule ?? ''));
                $external->setYearsOfExperience((string) ($position->yearsOfExperience ?? ''));
                $external->setKeywords((string) ($position->keywords ?? ''));
                $external->setOccupation((string) ($position->occupation ?? ''));
                $external->setOccupationCategory((string) ($position->occupationCategory ?? ''));
                $external->setCreatedAt($this->parseCreatedAt((string) ($position->createdAt ?? '')));
                $external->setStatus(JobPost::STATUS_PUBLISHED); // External jobs are always published

                $this->entityManager->persist($external);
                ++$upserted;
            } else {
                // Update existing external job
                $existing->setTitle($title);
                $existing->setDescription($description);
                $existing->setUrl($url);
                $existing->setRawXml($content);
                $existing->setSubcompany((string) ($position->subcompany ?? ''));
                $existing->setOffice((string) ($position->office ?? ''));
                $existing->setDepartment((string) ($position->department ?? ''));
                $existing->setRecruitingCategory((string) ($position->recruitingCategory ?? ''));
                $existing->setEmploymentType((string) ($position->employmentType ?? ''));
                $existing->setSeniority((string) ($position->seniority ?? ''));
                $existing->setSchedule((string) ($position->schedule ?? ''));
                $existing->setYearsOfExperience((string) ($position->yearsOfExperience ?? ''));
                $existing->setKeywords((string) ($position->keywords ?? ''));
                $existing->setOccupation((string) ($position->occupation ?? ''));
                $existing->setOccupationCategory((string) ($position->occupationCategory ?? ''));
                $existing->setCreatedAt($this->parseCreatedAt((string) ($position->createdAt ?? '')));
                $existing->setFetchedAt(new \DateTimeImmutable());
                $existing->touch(); // Update the updatedAt timestamp
            }
        }

        $this->entityManager->flush();

        return $upserted;
    }

    private function mergeJobDescriptions(?\SimpleXMLElement $jobDescriptions): string
    {
        if (!$jobDescriptions) {
            return '';
        }

        $descriptions = [];
        foreach ($jobDescriptions->jobDescription as $jobDesc) {
            $name = trim((string) ($jobDesc->name ?? ''));
            $value = trim((string) ($jobDesc->value ?? ''));

            if ($name && $value) {
                $descriptions[] = "<h3>{$name}</h3>\n{$value}";
            } elseif ($value) {
                $descriptions[] = $value;
            }
        }

        return implode("\n\n", $descriptions);
    }

    /**
     * Parse the createdAt date string into a DateTimeImmutable object.
     */
    private function parseCreatedAt(string $createdAtString): ?\DateTimeImmutable
    {
        if (empty($createdAtString)) {
            return null;
        }

        try {
            return new \DateTimeImmutable($createdAtString);
        } catch (\Exception $e) {
            return null;
        }
    }
}
