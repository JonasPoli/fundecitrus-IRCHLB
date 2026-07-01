<?php

namespace App\Controller\Admin;

use App\Entity\SponsorshipTier;
use App\Form\SponsorshipTierType;
use App\Repository\SponsorshipTierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SponsorshipTierController extends AbstractController
{
    #[Route('/admin/sponsorship/tier', name: 'app_admin_sponsorship_tier_index', methods: ['GET'])]
    public function index(SponsorshipTierRepository $sponsorshipTierRepository): Response
    {
        return $this->render('admin/sponsorship_tier/index.html.twig', [
            'sponsorship_tiers' => $sponsorshipTierRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/sponsorship/tier/new', name: 'app_admin_sponsorship_tier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sponsorshipTier = new SponsorshipTier();
        $form = $this->createForm(SponsorshipTierType::class, $sponsorshipTier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sponsorshipTier);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsorship_tier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sponsorship_tier/new.html.twig', [
            'sponsorship_tier' => $sponsorshipTier,
            'form' => $form,
        ]);
    }

    #[Route('/admin/sponsorship/tier/{id}/edit', name: 'app_admin_sponsorship_tier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] SponsorshipTier $sponsorshipTier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SponsorshipTierType::class, $sponsorshipTier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sponsorship_tier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sponsorship_tier/edit.html.twig', [
            'sponsorship_tier' => $sponsorshipTier,
            'form' => $form,
        ]);
    }

    #[Route('/admin/sponsorship/tier/{id}', name: 'app_admin_sponsorship_tier_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] SponsorshipTier $sponsorshipTier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsorshipTier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sponsorshipTier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_sponsorship_tier_index', [], Response::HTTP_SEE_OTHER);
    }
}
