<?php

namespace App\Controller\Admin;

use App\Entity\StatisticItem;
use App\Form\StatisticItemType;
use App\Repository\StatisticItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatisticItemController extends AbstractController
{
    #[Route('/admin/statistic/item', name: 'app_admin_statistic_item_index', methods: ['GET'])]
    public function index(StatisticItemRepository $statisticItemRepository): Response
    {
        return $this->render('admin/statistic_item/index.html.twig', [
            'statistic_items' => $statisticItemRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/statistic/item/new', name: 'app_admin_statistic_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statisticItem = new StatisticItem();
        $form = $this->createForm(StatisticItemType::class, $statisticItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statisticItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_statistic_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statistic_item/new.html.twig', [
            'statistic_item' => $statisticItem,
            'form' => $form,
        ]);
    }

    #[Route('/admin/statistic/item/{id}/edit', name: 'app_admin_statistic_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] StatisticItem $statisticItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatisticItemType::class, $statisticItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_statistic_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statistic_item/edit.html.twig', [
            'statistic_item' => $statisticItem,
            'form' => $form,
        ]);
    }

    #[Route('/admin/statistic/item/{id}', name: 'app_admin_statistic_item_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] StatisticItem $statisticItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statisticItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($statisticItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_statistic_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
