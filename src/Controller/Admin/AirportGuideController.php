<?php

namespace App\Controller\Admin;

use App\Entity\AirportGuide;
use App\Form\AirportGuideType;
use App\Repository\AirportGuideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AirportGuideController extends AbstractController
{
    #[Route('/admin/airport/guide', name: 'app_admin_airport_guide_index', methods: ['GET'])]
    public function index(AirportGuideRepository $airportGuideRepository): Response
    {
        return $this->render('admin/airport_guide/index.html.twig', [
            'airport_guides' => $airportGuideRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/airport/guide/new', name: 'app_admin_airport_guide_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airportGuide = new AirportGuide();
        $form = $this->createForm(AirportGuideType::class, $airportGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airportGuide);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_airport_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/airport_guide/new.html.twig', [
            'airport_guide' => $airportGuide,
            'form' => $form,
        ]);
    }

    #[Route('/admin/airport/guide/{id}/edit', name: 'app_admin_airport_guide_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] AirportGuide $airportGuide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirportGuideType::class, $airportGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_airport_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/airport_guide/edit.html.twig', [
            'airport_guide' => $airportGuide,
            'form' => $form,
        ]);
    }

    #[Route('/admin/airport/guide/{id}', name: 'app_admin_airport_guide_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] AirportGuide $airportGuide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airportGuide->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($airportGuide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_airport_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
