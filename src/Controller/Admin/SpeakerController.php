<?php

namespace App\Controller\Admin;

use App\Entity\Speaker;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SpeakerController extends AbstractController
{
    #[Route('/admin/speaker', name: 'app_admin_speaker_index', methods: ['GET'])]
    public function index(SpeakerRepository $speakerRepository): Response
    {
        return $this->render('admin/speaker/index.html.twig', [
            'speakers' => $speakerRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/speaker/new', name: 'app_admin_speaker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $speaker = new Speaker();
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($speaker);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_speaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/speaker/new.html.twig', [
            'speaker' => $speaker,
            'form' => $form,
        ]);
    }

    #[Route('/admin/speaker/{id}/edit', name: 'app_admin_speaker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] Speaker $speaker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_speaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form,
        ]);
    }

    #[Route('/admin/speaker/{id}', name: 'app_admin_speaker_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] Speaker $speaker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$speaker->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($speaker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_speaker_index', [], Response::HTTP_SEE_OTHER);
    }
}
