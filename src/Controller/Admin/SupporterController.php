<?php

namespace App\Controller\Admin;

use App\Entity\Supporter;
use App\Form\SupporterType;
use App\Repository\SupporterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SupporterController extends AbstractController
{
    #[Route('/admin/supporter', name: 'admin_supporter_index', methods: ['GET'])]
    public function index(SupporterRepository $supporterRepository): Response
    {
        return $this->render('admin/supporter/index.html.twig', [
            'supporters' => $supporterRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/supporter/new', name: 'admin_supporter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supporter = new Supporter();
        $form = $this->createForm(SupporterType::class, $supporter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supporter);
            $entityManager->flush();

            return $this->redirectToRoute('admin_supporter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/supporter/new.html.twig', [
            'supporter' => $supporter,
            'form' => $form,
        ]);
    }

    #[Route('/admin/supporter/{id}/edit', name: 'admin_supporter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] Supporter $supporter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupporterType::class, $supporter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_supporter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/supporter/edit.html.twig', [
            'supporter' => $supporter,
            'form' => $form,
        ]);
    }

    #[Route('/admin/supporter/{id}', name: 'admin_supporter_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] Supporter $supporter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supporter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($supporter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_supporter_index', [], Response::HTTP_SEE_OTHER);
    }
}
