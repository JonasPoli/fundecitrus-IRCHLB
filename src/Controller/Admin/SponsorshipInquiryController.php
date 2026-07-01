<?php

namespace App\Controller\Admin;

use App\Entity\SponsorshipInquiry;
use App\Form\SponsorshipInquiryType;
use App\Repository\SponsorshipInquiryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SponsorshipInquiryController extends AbstractController
{
    #[Route('/admin/sponsorship/inquiry', name: 'app_admin_sponsorship_inquiry_index', methods: ['GET'])]
    public function index(SponsorshipInquiryRepository $sponsorshipInquiryRepository): Response
    {
        return $this->render('admin/sponsorship_inquiry/index.html.twig', [
            'sponsorship_inquiries' => $sponsorshipInquiryRepository->findAll(),
        ]);
    }

    #[Route('/admin/sponsorship/inquiry/new', name: 'app_admin_sponsorship_inquiry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sponsorshipInquiry = new SponsorshipInquiry();
        $form = $this->createForm(SponsorshipInquiryType::class, $sponsorshipInquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sponsorshipInquiry);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsorship_inquiry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sponsorship_inquiry/new.html.twig', [
            'sponsorship_inquiry' => $sponsorshipInquiry,
            'form' => $form,
        ]);
    }

    #[Route('/admin/sponsorship/inquiry/{id}/edit', name: 'app_admin_sponsorship_inquiry_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] SponsorshipInquiry $sponsorshipInquiry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SponsorshipInquiryType::class, $sponsorshipInquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsorship_inquiry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sponsorship_inquiry/edit.html.twig', [
            'sponsorship_inquiry' => $sponsorshipInquiry,
            'form' => $form,
        ]);
    }

    #[Route('/admin/sponsorship/inquiry/{id}', name: 'app_admin_sponsorship_inquiry_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] SponsorshipInquiry $sponsorshipInquiry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsorshipInquiry->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sponsorshipInquiry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_sponsorship_inquiry_index', [], Response::HTTP_SEE_OTHER);
    }
}
