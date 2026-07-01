<?php

namespace App\Controller\Admin;

use App\Entity\EventConfig;
use App\Form\EventConfigType;
use App\Repository\EventConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventConfigController extends AbstractController
{
    #[Route('/admin/event/config', name: 'app_admin_event_config_index', methods: ['GET'])]
    public function index(EventConfigRepository $eventConfigRepository): Response
    {
        return $this->render('admin/event_config/index.html.twig', [
            'event_configs' => $eventConfigRepository->findAll(),
        ]);
    }

    #[Route('/admin/event/config/new', name: 'app_admin_event_config_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventConfig = new EventConfig();
        $form = $this->createForm(EventConfigType::class, $eventConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventConfig);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_event_config_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/event_config/new.html.twig', [
            'event_config' => $eventConfig,
            'form' => $form,
        ]);
    }

    #[Route('/admin/event/config/{id}/edit', name: 'app_admin_event_config_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] EventConfig $eventConfig, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventConfigType::class, $eventConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_event_config_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/event_config/edit.html.twig', [
            'event_config' => $eventConfig,
            'form' => $form,
        ]);
    }

    #[Route('/admin/event/config/{id}', name: 'app_admin_event_config_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] EventConfig $eventConfig, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventConfig->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eventConfig);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_event_config_index', [], Response::HTTP_SEE_OTHER);
    }
}
