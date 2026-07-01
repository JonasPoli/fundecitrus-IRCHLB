<?php

namespace App\Controller\Admin;

use App\Entity\AgendaActivity;
use App\Form\AgendaActivityType;
use App\Repository\AgendaActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AgendaActivityController extends AbstractController
{
    #[Route('/admin/agenda/activity', name: 'app_admin_agenda_activity_index', methods: ['GET'])]
    public function index(AgendaActivityRepository $agendaActivityRepository): Response
    {
        return $this->render('admin/agenda_activity/index.html.twig', [
            'agenda_activities' => $agendaActivityRepository->findAll(),
        ]);
    }

    #[Route('/admin/agenda/activity/new', name: 'app_admin_agenda_activity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agendaActivity = new AgendaActivity();
        $form = $this->createForm(AgendaActivityType::class, $agendaActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agendaActivity);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_agenda_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/agenda_activity/new.html.twig', [
            'agenda_activity' => $agendaActivity,
            'form' => $form,
        ]);
    }

    #[Route('/admin/agenda/activity/{id}/edit', name: 'app_admin_agenda_activity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] AgendaActivity $agendaActivity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AgendaActivityType::class, $agendaActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_agenda_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/agenda_activity/edit.html.twig', [
            'agenda_activity' => $agendaActivity,
            'form' => $form,
        ]);
    }

    #[Route('/admin/agenda/activity/{id}', name: 'app_admin_agenda_activity_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] AgendaActivity $agendaActivity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agendaActivity->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($agendaActivity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_agenda_activity_index', [], Response::HTTP_SEE_OTHER);
    }
}
