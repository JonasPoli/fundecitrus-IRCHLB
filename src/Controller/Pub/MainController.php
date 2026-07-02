<?php

namespace App\Controller\Pub;

use App\Entity\ContactMessage;
use App\Entity\NewsletterRequest;
use App\Entity\SponsorshipInquiry;
use App\Repository\AirportGuideRepository;
use App\Repository\AgendaActivityRepository;
use App\Repository\CommitteeMemberRepository;
use App\Repository\EventDayRepository;
use App\Repository\FaqItemRepository;
use App\Repository\PartnerHotelRepository;
use App\Repository\RegistrationBatchRepository;
use App\Repository\RestaurantRecommendationRepository;
use App\Repository\SpeakerRepository;
use App\Repository\SponsorshipTierRepository;
use App\Repository\StatisticItemRepository;
use App\Repository\ThematicGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(StatisticItemRepository $statRepo, \App\Repository\HomeBannerRepository $bannerRepo): Response
    {
        return $this->render('pub/main/home.html.twig', [
            'statistic_items' => $statRepo->findBy(['isActive' => true], ['position' => 'ASC']),
            'banners' => $bannerRepo->findBy(['isActive' => true], ['position' => 'ASC']),
        ]);
    }

    #[Route('/sobre', name: 'app_sobre')]
    public function sobre(CommitteeMemberRepository $memberRepo): Response
    {
        return $this->render('pub/main/sobre.html.twig', [
            'committee_members' => $memberRepo->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/programa', name: 'app_programa')]
    public function programa(Request $request, EventDayRepository $dayRepo, AgendaActivityRepository $activityRepo): Response
    {
        $days = $dayRepo->findBy([], ['position' => 'ASC']);
        
        $activeDayId = $request->query->get('day');
        $activeDay = null;
        
        if ($activeDayId) {
            $activeDay = $dayRepo->find($activeDayId);
        }
        
        if (!$activeDay && !empty($days)) {
            $activeDay = $days[0];
        }
        
        $activities = [];
        if ($activeDay) {
            $activities = $activityRepo->findBy(['eventDay' => $activeDay], ['startTime' => 'ASC']);
        }
        
        return $this->render('pub/main/programa.html.twig', [
            'days' => $days,
            'active_day' => $activeDay,
            'activities' => $activities,
        ]);
    }

    #[Route('/palestrantes', name: 'app_palestrantes')]
    public function palestrantes(SpeakerRepository $speakerRepo): Response
    {
        return $this->render('pub/main/palestrantes.html.twig', [
            'speakers' => $speakerRepo->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/palestrantes/{id}', name: 'app_palestrante_detalhe')]
    public function palestranteDetalhe(int $id, SpeakerRepository $speakerRepo): Response
    {
        $speaker = $speakerRepo->find($id);
        if (!$speaker) {
            throw $this->createNotFoundException('Speaker not found.');
        }
        
        return $this->render('pub/main/palestrante_detalhe.html.twig', [
            'speaker' => $speaker,
        ]);
    }

    #[Route('/patrocinadores', name: 'app_patrocinadores')]
    public function patrocinadores(SponsorshipTierRepository $tierRepo): Response
    {
        return $this->render('pub/main/patrocinadores.html.twig', [
            'tiers' => $tierRepo->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/sponsors/inquiry', name: 'app_sponsorship_inquiry', methods: ['POST'])]
    public function sponsorshipInquiry(Request $request, EntityManagerInterface $em): Response
    {
        $companyName = $request->request->get('companyName');
        $contactPerson = $request->request->get('contactPerson');
        $corporateEmail = $request->request->get('corporateEmail');
        $interestArea = $request->request->get('interestArea');

        if ($companyName && $contactPerson && $corporateEmail && $interestArea) {
            $inquiry = new SponsorshipInquiry();
            $inquiry->setCompanyName($companyName);
            $inquiry->setContactPerson($contactPerson);
            $inquiry->setCorporateEmail($corporateEmail);
            $inquiry->setInterestArea($interestArea);
            $inquiry->setStatus('New');

            $em->persist($inquiry);
            $em->flush();

            $this->addFlash('success', 'Thank you for your interest! Our team will contact you shortly.');
        } else {
            $this->addFlash('error', 'Please fill in all fields correctly.');
        }

        return $this->redirectToRoute('app_patrocinadores');
    }

    #[Route('/newsletter/subscribe', name: 'app_newsletter_subscribe', methods: ['POST'])]
    public function newsletterSubscribe(Request $request, EntityManagerInterface $entityManager): Response
    {
        $email = $request->request->get('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $newsletterRequest = new NewsletterRequest();
            $newsletterRequest->setEmail($email);

            $entityManager->persist($newsletterRequest);
            $entityManager->flush();

            $this->addFlash('success', 'Thank you for subscribing to our newsletter!');
        } else {
            $this->addFlash('error', 'Please fill in a valid email address.');
        }

        $referer = $request->headers->get('referer');
        return $referer ? $this->redirect($referer) : $this->redirectToRoute('app_home');
    }

    #[Route('/inscricoes', name: 'app_inscricoes')]
    public function inscricoes(RegistrationBatchRepository $batchRepo, FaqItemRepository $faqRepo): Response
    {
        return $this->render('pub/main/inscricoes.html.twig', [
            'batches' => $batchRepo->findBy([], ['position' => 'ASC']),
            'faq_items' => $faqRepo->findBy(['isActive' => true], ['position' => 'ASC']),
        ]);
    }

    #[Route('/submissao', name: 'app_submissao')]
    public function submissao(ThematicGroupRepository $timelineRepo): Response
    {
        return $this->render('pub/main/submissao.html.twig', [
            'timeline_items' => $timelineRepo->findBy([], ['eventDate' => 'ASC']),
        ]);
    }

    #[Route('/local', name: 'app_local')]
    public function local(
        AirportGuideRepository $airportRepo,
        PartnerHotelRepository $hotelRepo,
        RestaurantRecommendationRepository $restaurantRepo
    ): Response {
        return $this->render('pub/main/local.html.twig', [
            'airports' => $airportRepo->findBy([], ['position' => 'ASC']),
            'hotels' => $hotelRepo->findBy([], ['position' => 'ASC']),
            'restaurants' => $restaurantRepo->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/contato', name: 'app_contato')]
    public function contato(FaqItemRepository $faqRepo): Response
    {
        return $this->render('pub/main/contato.html.twig', [
            'faq_items' => $faqRepo->findBy(['isActive' => true], ['position' => 'ASC']),
        ]);
    }

    #[Route('/contact/message', name: 'app_contact_message', methods: ['POST'])]
    public function contactMessage(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $emailAddress = $request->request->get('email');
        $subject = $request->request->get('subject');
        $messageText = $request->request->get('message');
        $consent = $request->request->get('consent') === 'on';

        if ($firstName && $lastName && $emailAddress && $subject && $messageText) {
            $msg = new ContactMessage();
            $msg->setFirstName($firstName);
            $msg->setLastName($lastName);
            $msg->setEmail($emailAddress);
            $msg->setSubject($subject);
            $msg->setMessage($messageText);
            $msg->setConsent($consent);
            $msg->setStatus('New');

            $em->persist($msg);
            $em->flush();

            // Envia e-mail de notificação se possível
            try {
                $email = (new Email())
                    ->from('no-reply@fundecitrus.com.br')
                    ->to($emailAddress)
                    ->subject('IRCHLB 2027 - Contact Request received: ' . $subject)
                    ->text("Hello {$firstName} {$lastName},\n\nWe have successfully received your message:\n\n\"{$messageText}\"\n\nOur organizing committee will respond as soon as possible.\n\nBest Regards,\nIRCHLB 2027 Organizing Committee");
                $mailer->send($email);
            } catch (\Exception $e) {
                // Silenciosamente ignora falha de e-mail local
            }

            $this->addFlash('success', 'Your message has been sent successfully!');
        } else {
            $this->addFlash('error', 'Please fill in all fields correctly.');
        }

        return $this->redirectToRoute('app_contato');
    }

    #[Route('/p/{slug}', name: 'app_page_content')]
    public function pageContent(string $slug, \App\Repository\PageContentRepository $pageRepo): Response
    {
        $page = $pageRepo->findOneBy(['slug' => $slug]);
        if (!$page) {
            throw $this->createNotFoundException('Page not found.');
        }

        return $this->render('pub/main/page_content.html.twig', [
            'page' => $page,
        ]);
    }
}
