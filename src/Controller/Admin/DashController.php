<?php

namespace App\Controller\Admin;

use App\Repository\AgendaActivityRepository;
use App\Repository\ContactMessageRepository;
use App\Repository\SpeakerRepository;
use App\Repository\SponsorRepository;
use App\Repository\SponsorshipInquiryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class DashController extends AbstractController
{
    #[Route('/', name: 'admin_dash')]
    public function dashboard(
        UserRepository $userRepository,
        SpeakerRepository $speakerRepository,
        AgendaActivityRepository $activityRepository,
        SponsorRepository $sponsorRepository,
        ContactMessageRepository $contactRepository,
        SponsorshipInquiryRepository $inquiryRepository
    ): Response {
        return $this->render('admin/dash/dashboard.html.twig', [
            'stats' => [
                'users_total' => $userRepository->count([]),
                'speakers_total' => $speakerRepository->count([]),
                'activities_total' => $activityRepository->count([]),
                'sponsors_total' => $sponsorRepository->count([]),
                'contacts_total' => $contactRepository->count([]),
                'contacts_pending' => $contactRepository->count(['status' => 'New']),
                'inquiries_total' => $inquiryRepository->count([]),
                'inquiries_pending' => $inquiryRepository->count(['status' => 'New']),
            ],
            'recent_contacts' => $contactRepository->findBy([], ['createdAt' => 'DESC'], 5),
            'recent_inquiries' => $inquiryRepository->findBy([], ['createdAt' => 'DESC'], 5),
        ]);
    }
}
