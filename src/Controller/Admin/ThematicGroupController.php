<?php

namespace App\Controller\Admin;

use App\Entity\ThematicGroup;
use App\Form\ThematicGroupType;
use App\Repository\ThematicGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ThematicGroupController extends AbstractController
{
    #[Route('/admin/thematic/group', name: 'app_admin_thematic_group_index', methods: ['GET'])]
    public function index(ThematicGroupRepository $thematicGroupRepository): Response
    {
        return $this->render('admin/thematic_group/index.html.twig', [
            'thematic_groups' => $thematicGroupRepository->findAll(),
        ]);
    }

    #[Route('/admin/thematic/group/new', name: 'app_admin_thematic_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thematicGroup = new ThematicGroup();
        $form = $this->createForm(ThematicGroupType::class, $thematicGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thematicGroup);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_thematic_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/thematic_group/new.html.twig', [
            'thematic_group' => $thematicGroup,
            'form' => $form,
        ]);
    }

    #[Route('/admin/thematic/group/{id}/edit', name: 'app_admin_thematic_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] ThematicGroup $thematicGroup, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThematicGroupType::class, $thematicGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_thematic_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/thematic_group/edit.html.twig', [
            'thematic_group' => $thematicGroup,
            'form' => $form,
        ]);
    }

    #[Route('/admin/thematic/group/{id}', name: 'app_admin_thematic_group_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] ThematicGroup $thematicGroup, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thematicGroup->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($thematicGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_thematic_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
