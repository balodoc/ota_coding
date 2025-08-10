<?php

namespace App\Entity;

use App\Repository\ExternalJobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExternalJobRepository::class)]
#[ORM\Table(name: 'external_jobs_cache')]
class ExternalJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $externalId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 2048)]
    private string $url;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $rawXml = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $fetchedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subcompany = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $office = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $recruitingCategory = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $employmentType = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $seniority = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $schedule = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $yearsOfExperience = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $keywords = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $occupation = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $occupationCategory = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(
        string $externalId,
        string $title,
        string $description,
        string $url,
        ?string $rawXml = null,
        ?string $subcompany = null,
        ?string $office = null,
        ?string $department = null,
        ?string $recruitingCategory = null,
        ?string $employmentType = null,
        ?string $seniority = null,
        ?string $schedule = null,
        ?string $yearsOfExperience = null,
        ?string $keywords = null,
        ?string $occupation = null,
        ?string $occupationCategory = null,
        ?\DateTimeImmutable $createdAt = null,
    ) {
        $this->externalId = $externalId;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->rawXml = $rawXml;
        $this->fetchedAt = new \DateTimeImmutable();
        $this->subcompany = $subcompany;
        $this->office = $office;
        $this->department = $department;
        $this->recruitingCategory = $recruitingCategory;
        $this->employmentType = $employmentType;
        $this->seniority = $seniority;
        $this->schedule = $schedule;
        $this->yearsOfExperience = $yearsOfExperience;
        $this->keywords = $keywords;
        $this->occupation = $occupation;
        $this->occupationCategory = $occupationCategory;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getRawXml(): ?string
    {
        return $this->rawXml;
    }

    public function setRawXml(?string $rawXml): void
    {
        $this->rawXml = $rawXml;
    }

    public function getFetchedAt(): \DateTimeImmutable
    {
        return $this->fetchedAt;
    }

    public function setFetchedAt(\DateTimeImmutable $fetchedAt): void
    {
        $this->fetchedAt = $fetchedAt;
    }

    public function getSubcompany(): ?string
    {
        return $this->subcompany;
    }

    public function setSubcompany(?string $subcompany): void
    {
        $this->subcompany = $subcompany;
    }

    public function getOffice(): ?string
    {
        return $this->office;
    }

    public function setOffice(?string $office): void
    {
        $this->office = $office;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): void
    {
        $this->department = $department;
    }

    public function getRecruitingCategory(): ?string
    {
        return $this->recruitingCategory;
    }

    public function setRecruitingCategory(?string $recruitingCategory): void
    {
        $this->recruitingCategory = $recruitingCategory;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(?string $employmentType): void
    {
        $this->employmentType = $employmentType;
    }

    public function getSeniority(): ?string
    {
        return $this->seniority;
    }

    public function setSeniority(?string $seniority): void
    {
        $this->seniority = $seniority;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getYearsOfExperience(): ?string
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(?string $yearsOfExperience): void
    {
        $this->yearsOfExperience = $yearsOfExperience;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void
    {
        $this->occupation = $occupation;
    }

    public function getOccupationCategory(): ?string
    {
        return $this->occupationCategory;
    }

    public function setOccupationCategory(?string $occupationCategory): void
    {
        $this->occupationCategory = $occupationCategory;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
