<?php

namespace App\Controller\Admin;

use App\Entity\VenueRoom;
use App\Form\VenueRoomType;
use App\Repository\VenueRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VenueRoomController extends AbstractController
{
    #[Route('/admin/venue/room', name: 'app_admin_venue_room_index', methods: ['GET'])]
    public function index(VenueRoomRepository $venueRoomRepository): Response
    {
        return $this->render('admin/venue_room/index.html.twig', [
            'venue_rooms' => $venueRoomRepository->findAll(),
        ]);
    }

    #[Route('/admin/venue/room/new', name: 'app_admin_venue_room_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $venueRoom = new VenueRoom();
        $form = $this->createForm(VenueRoomType::class, $venueRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($venueRoom);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_venue_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/venue_room/new.html.twig', [
            'venue_room' => $venueRoom,
            'form' => $form,
        ]);
    }

    #[Route('/admin/venue/room/{id}/edit', name: 'app_admin_venue_room_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] VenueRoom $venueRoom, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenueRoomType::class, $venueRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_venue_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/venue_room/edit.html.twig', [
            'venue_room' => $venueRoom,
            'form' => $form,
        ]);
    }

    #[Route('/admin/venue/room/{id}', name: 'app_admin_venue_room_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] VenueRoom $venueRoom, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venueRoom->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($venueRoom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_venue_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
