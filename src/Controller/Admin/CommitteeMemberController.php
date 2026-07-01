<?php

namespace App\Controller\Admin;

use App\Entity\CommitteeMember;
use App\Form\CommitteeMemberType;
use App\Repository\CommitteeMemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommitteeMemberController extends AbstractController
{
    #[Route('/admin/committee/member', name: 'app_admin_committee_member_index', methods: ['GET'])]
    public function index(CommitteeMemberRepository $committeeMemberRepository): Response
    {
        return $this->render('admin/committee_member/index.html.twig', [
            'committee_members' => $committeeMemberRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/committee/member/new', name: 'app_admin_committee_member_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $committeeMember = new CommitteeMember();
        $form = $this->createForm(CommitteeMemberType::class, $committeeMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($committeeMember);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_committee_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/committee_member/new.html.twig', [
            'committee_member' => $committeeMember,
            'form' => $form,
        ]);
    }

    #[Route('/admin/committee/member/{id}/edit', name: 'app_admin_committee_member_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] CommitteeMember $committeeMember, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommitteeMemberType::class, $committeeMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_committee_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/committee_member/edit.html.twig', [
            'committee_member' => $committeeMember,
            'form' => $form,
        ]);
    }

    #[Route('/admin/committee/member/{id}', name: 'app_admin_committee_member_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] CommitteeMember $committeeMember, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$committeeMember->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($committeeMember);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_committee_member_index', [], Response::HTTP_SEE_OTHER);
    }
}
