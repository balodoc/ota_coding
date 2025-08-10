<?php

namespace App\Controller;

use App\Entity\JobPost;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModeratorController extends AbstractController
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/moderator/queue', name: 'moderator_queue', methods: ['GET'])]
    public function queue(): Response
    {
        return $this->render('moderator_queue.html.twig', [
            'notifications' => $this->notificationRepository->findAllOrderedByCreatedAtDesc(),
        ]);
    }

    #[Route('/moderator/job/{id}', name: 'moderator_job_show', methods: ['GET'])]
    public function show(JobPost $job): Response
    {
        $this->notificationRepository->markUnreadByJobIdAsRead($job->getId());

        return $this->render('moderator_job_show.html.twig', [
            'job' => $job,
        ]);
    }

    #[Route('/moderator/job/{id}/approve', name: 'moderator_job_approve', methods: ['POST'])]
    public function approve(JobPost $job): Response
    {
        $this->approveAndUpdate($job);
        $this->addFlash('success', 'Job approved.');

        return $this->redirectToRoute('jobs_index');
    }

    #[Route('/moderator/job/{id}/reject', name: 'moderator_job_reject', methods: ['POST'])]
    public function reject(JobPost $job): Response
    {
        $this->rejectAndUpdate($job);
        $this->addFlash('success', 'Job rejected.');

        return $this->redirectToRoute('jobs_index');
    }

    private function rejectAndUpdate(JobPost $job): void
    {
        $job->setStatus(JobPost::STATUS_SPAM);
        $job->touch();
        $this->entityManager->flush();
    }

    private function approveAndUpdate(JobPost $job): void
    {
        $job->setStatus(JobPost::STATUS_PUBLISHED);
        $job->touch();
        $this->entityManager->flush();
    }
}
