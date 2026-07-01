<?php

namespace App\Controller\Admin;

use App\Entity\EventDay;
use App\Form\EventDayType;
use App\Repository\EventDayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventDayController extends AbstractController
{
    #[Route('/admin/event/day', name: 'app_admin_event_day_index', methods: ['GET'])]
    public function index(EventDayRepository $eventDayRepository): Response
    {
        return $this->render('admin/event_day/index.html.twig', [
            'event_days' => $eventDayRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/event/day/new', name: 'app_admin_event_day_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventDay = new EventDay();
        $form = $this->createForm(EventDayType::class, $eventDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventDay);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_event_day_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/event_day/new.html.twig', [
            'event_day' => $eventDay,
            'form' => $form,
        ]);
    }

    #[Route('/admin/event/day/{id}/edit', name: 'app_admin_event_day_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] EventDay $eventDay, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventDayType::class, $eventDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_event_day_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/event_day/edit.html.twig', [
            'event_day' => $eventDay,
            'form' => $form,
        ]);
    }

    #[Route('/admin/event/day/{id}', name: 'app_admin_event_day_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] EventDay $eventDay, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventDay->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eventDay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_event_day_index', [], Response::HTTP_SEE_OTHER);
    }
}
