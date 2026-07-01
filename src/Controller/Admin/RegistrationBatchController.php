<?php

namespace App\Controller\Admin;

use App\Entity\RegistrationBatch;
use App\Form\RegistrationBatchType;
use App\Repository\RegistrationBatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationBatchController extends AbstractController
{
    #[Route('/admin/registration/batch', name: 'app_admin_registration_batch_index', methods: ['GET'])]
    public function index(RegistrationBatchRepository $registrationBatchRepository): Response
    {
        return $this->render('admin/registration_batch/index.html.twig', [
            'registration_batches' => $registrationBatchRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/registration/batch/new', name: 'app_admin_registration_batch_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $registrationBatch = new RegistrationBatch();
        $form = $this->createForm(RegistrationBatchType::class, $registrationBatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registrationBatch);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_registration_batch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/registration_batch/new.html.twig', [
            'registration_batch' => $registrationBatch,
            'form' => $form,
        ]);
    }

    #[Route('/admin/registration/batch/{id}/edit', name: 'app_admin_registration_batch_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] RegistrationBatch $registrationBatch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationBatchType::class, $registrationBatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_registration_batch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/registration_batch/edit.html.twig', [
            'registration_batch' => $registrationBatch,
            'form' => $form,
        ]);
    }

    #[Route('/admin/registration/batch/{id}', name: 'app_admin_registration_batch_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] RegistrationBatch $registrationBatch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$registrationBatch->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($registrationBatch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_registration_batch_index', [], Response::HTTP_SEE_OTHER);
    }
}
