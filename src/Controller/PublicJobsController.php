<?php

namespace App\Controller;

use App\Entity\JobPost;
use App\Repository\JobPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicJobsController extends AbstractController
{
    public function __construct(
        private readonly JobPostRepository $jobPostRepository,
    ) {
    }

    #[Route('/jobs', name: 'jobs_index', methods: ['GET'])]
    public function index(): Response
    {
        $internal = $this->jobPostRepository->findInternalJobsOrderedByCreatedAtDesc();
        $external = $this->jobPostRepository->findExternalJobsOrderedByFetchedAtDesc();

        return $this->render('jobs.html.twig', [
            'internal' => $internal,
            'external' => $external,
        ]);
    }

    #[Route('/job/{id}', name: 'job_show', methods: ['GET'])]
    public function show(JobPost $job): Response
    {
        if (JobPost::STATUS_PUBLISHED !== $job->getStatus()) {
            throw $this->createNotFoundException();
        }

        return $this->render('job_show.html.twig', [
            'job' => $job,
        ]);
    }

    #[Route('/external/{externalId}', name: 'external_redirect', methods: ['GET'])]
    public function external(string $externalId): Response
    {
        $external = $this->jobPostRepository->findOneByExternalId($externalId);

        if (!$external) {
            throw $this->createNotFoundException('External job not found');
        }

        return $this->render('job_show.html.twig', [
            'job' => $external,
        ]);
    }
}
