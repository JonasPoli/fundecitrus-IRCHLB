<?php

namespace App\Controller\Admin;

use App\Entity\FaqCategory;
use App\Form\FaqCategoryType;
use App\Repository\FaqCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FaqCategoryController extends AbstractController
{
    #[Route('/admin/faq/category', name: 'app_admin_faq_category_index', methods: ['GET'])]
    public function index(FaqCategoryRepository $faqCategoryRepository): Response
    {
        return $this->render('admin/faq_category/index.html.twig', [
            'faq_categories' => $faqCategoryRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/faq/category/new', name: 'app_admin_faq_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $faqCategory = new FaqCategory();
        $form = $this->createForm(FaqCategoryType::class, $faqCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($faqCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/faq_category/new.html.twig', [
            'faq_category' => $faqCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/faq/category/{id}/edit', name: 'app_admin_faq_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] FaqCategory $faqCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FaqCategoryType::class, $faqCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/faq_category/edit.html.twig', [
            'faq_category' => $faqCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/faq/category/{id}', name: 'app_admin_faq_category_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] FaqCategory $faqCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faqCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($faqCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_faq_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
