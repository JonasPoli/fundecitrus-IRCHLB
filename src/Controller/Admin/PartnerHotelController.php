<?php

namespace App\Controller\Admin;

use App\Entity\PartnerHotel;
use App\Form\PartnerHotelType;
use App\Repository\PartnerHotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PartnerHotelController extends AbstractController
{
    #[Route('/admin/partner/hotel', name: 'app_admin_partner_hotel_index', methods: ['GET'])]
    public function index(PartnerHotelRepository $partnerHotelRepository): Response
    {
        return $this->render('admin/partner_hotel/index.html.twig', [
            'partner_hotels' => $partnerHotelRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/partner/hotel/new', name: 'app_admin_partner_hotel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partnerHotel = new PartnerHotel();
        $form = $this->createForm(PartnerHotelType::class, $partnerHotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partnerHotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/partner_hotel/new.html.twig', [
            'partner_hotel' => $partnerHotel,
            'form' => $form,
        ]);
    }

    #[Route('/admin/partner/hotel/{id}/edit', name: 'app_admin_partner_hotel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] PartnerHotel $partnerHotel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PartnerHotelType::class, $partnerHotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/partner_hotel/edit.html.twig', [
            'partner_hotel' => $partnerHotel,
            'form' => $form,
        ]);
    }

    #[Route('/admin/partner/hotel/{id}', name: 'app_admin_partner_hotel_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] PartnerHotel $partnerHotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partnerHotel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($partnerHotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_partner_hotel_index', [], Response::HTTP_SEE_OTHER);
    }
}
