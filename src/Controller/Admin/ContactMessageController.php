<?php

namespace App\Controller\Admin;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactMessageController extends AbstractController
{
    #[Route('/admin/contact/message', name: 'app_admin_contact_message_index', methods: ['GET'])]
    public function index(ContactMessageRepository $contactMessageRepository): Response
    {
        return $this->render('admin/contact_message/index.html.twig', [
            'contact_messages' => $contactMessageRepository->findAll(),
        ]);
    }

    #[Route('/admin/contact/message/new', name: 'app_admin_contact_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_contact_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/contact_message/new.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form,
        ]);
    }

    #[Route('/admin/contact/message/{id}/edit', name: 'app_admin_contact_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_contact_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/contact_message/edit.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form,
        ]);
    }

    #[Route('/admin/contact/message/{id}', name: 'app_admin_contact_message_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] ContactMessage $contactMessage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactMessage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contactMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_contact_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
