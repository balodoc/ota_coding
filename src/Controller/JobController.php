<?php

namespace App\Controller;

use App\Entity\JobPost;
use App\Entity\Notification;
use App\Entity\User;
use App\Repository\JobPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class JobController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/post-job', name: 'post_job_form', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function postJobForm(): Response
    {
        return $this->render('post_job.html.twig');
    }

    #[Route('/post-job', name: 'post_job_submit', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function postJobSubmit(
        Request $request,
        EntityManagerInterface $em,
        JobPostRepository $jobRepo,
        MailerInterface $mailer,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $title = trim((string) $request->request->get('title'));
        $description = trim((string) $request->request->get('description'));

        if ('' === $title || '' === $description) {
            $this->addFlash('error', 'Title and description are required.');

            return $this->redirectToRoute('post_job_form');
        }

        $job = new JobPost($user->getEmail(), $title, $description);
        $job->setUser($user);

        $subcompany = trim((string) $request->request->get('subcompany'));
        if ('' !== $subcompany) {
            $job->setSubcompany($subcompany);
        }

        $office = trim((string) $request->request->get('office'));
        if ('' !== $office) {
            $job->setOffice($office);
        }

        $department = trim((string) $request->request->get('department'));
        if ('' !== $department) {
            $job->setDepartment($department);
        }

        $recruitingCategory = trim((string) $request->request->get('recruitingCategory'));
        if ('' !== $recruitingCategory) {
            $job->setRecruitingCategory($recruitingCategory);
        }

        $employmentType = trim((string) $request->request->get('employmentType'));
        if ('' !== $employmentType) {
            $job->setEmploymentType($employmentType);
        }

        $schedule = trim((string) $request->request->get('schedule'));
        if ('' !== $schedule) {
            $job->setSchedule($schedule);
        }

        $seniority = trim((string) $request->request->get('seniority'));
        if ('' !== $seniority) {
            $job->setSeniority($seniority);
        }

        $yearsOfExperience = trim((string) $request->request->get('yearsOfExperience'));
        if ('' !== $yearsOfExperience) {
            $job->setYearsOfExperience($yearsOfExperience);
        }

        $keywords = trim((string) $request->request->get('keywords'));
        if ('' !== $keywords) {
            $job->setKeywords($keywords);
        }

        $occupation = trim((string) $request->request->get('occupation'));
        if ('' !== $occupation) {
            $job->setOccupation($occupation);
        }

        $occupationCategory = trim((string) $request->request->get('occupationCategory'));
        if ('' !== $occupationCategory) {
            $job->setOccupationCategory($occupationCategory);
        }

        $em->persist($job);
        $em->flush();

        $countPrior = $jobRepo->countPriorPostsByEmailExcludingId($user->getEmail(), $job->getId());
        $isFirstTime = 0 === $countPrior;

        if ($isFirstTime) {
            // First-time poster - job stays pending for moderator review
            $viewLink = $this->generateUrl(
                'moderator_job_show',
                ['id' => $job->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $notification = new Notification(Notification::TYPE_FIRST_POST, [
                'job_id' => $job->getId(),
                'title' => $title,
                'description' => mb_substr(strip_tags($description), 0, 300),
                'view_link' => $viewLink,
            ]);

            $notification->setJobId($job->getId());
            $em->persist($notification);
            $em->flush();
            $this->addFlash('success', 'Job submitted. A moderator will review it.');
        } else {
            $job->setStatus('published');
            $em->flush();
            $this->addFlash('success', 'Job published successfully!');
        }

        return $this->redirectToRoute('home');
    }
}
