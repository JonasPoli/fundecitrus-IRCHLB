<?php

namespace App\Controller\Admin;

use App\Entity\Organizer;
use App\Form\OrganizerType;
use App\Repository\OrganizerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrganizerController extends AbstractController
{
    #[Route('/admin/organizer', name: 'admin_organizer_index', methods: ['GET'])]
    public function index(OrganizerRepository $organizerRepository): Response
    {
        return $this->render('admin/organizer/index.html.twig', [
            'organizers' => $organizerRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/organizer/new', name: 'admin_organizer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $organizer = new Organizer();
        $form = $this->createForm(OrganizerType::class, $organizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($organizer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_organizer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/organizer/new.html.twig', [
            'organizer' => $organizer,
            'form' => $form,
        ]);
    }

    #[Route('/admin/organizer/{id}/edit', name: 'admin_organizer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] Organizer $organizer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrganizerType::class, $organizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_organizer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/organizer/edit.html.twig', [
            'organizer' => $organizer,
            'form' => $form,
        ]);
    }

    #[Route('/admin/organizer/{id}', name: 'admin_organizer_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] Organizer $organizer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organizer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($organizer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_organizer_index', [], Response::HTTP_SEE_OTHER);
    }
}
