<?php

namespace App\Controller\Admin;

use App\Entity\FaqItem;
use App\Form\FaqItemType;
use App\Repository\FaqItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FaqItemController extends AbstractController
{
    #[Route('/admin/faq/item', name: 'app_admin_faq_item_index', methods: ['GET'])]
    public function index(FaqItemRepository $faqItemRepository): Response
    {
        return $this->render('admin/faq_item/index.html.twig', [
            'faq_items' => $faqItemRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/faq/item/new', name: 'app_admin_faq_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $faqItem = new FaqItem();
        $form = $this->createForm(FaqItemType::class, $faqItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($faqItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/faq_item/new.html.twig', [
            'faq_item' => $faqItem,
            'form' => $form,
        ]);
    }

    #[Route('/admin/faq/item/{id}/edit', name: 'app_admin_faq_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] FaqItem $faqItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FaqItemType::class, $faqItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/faq_item/edit.html.twig', [
            'faq_item' => $faqItem,
            'form' => $form,
        ]);
    }

    #[Route('/admin/faq/item/{id}', name: 'app_admin_faq_item_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] FaqItem $faqItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faqItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($faqItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_faq_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
