<?php

namespace App\Controller\Admin;

use App\Entity\RestaurantRecommendation;
use App\Form\RestaurantRecommendationType;
use App\Repository\RestaurantRecommendationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RestaurantRecommendationController extends AbstractController
{
    #[Route('/admin/restaurant/recommendation', name: 'app_admin_restaurant_recommendation_index', methods: ['GET'])]
    public function index(RestaurantRecommendationRepository $restaurantRecommendationRepository): Response
    {
        return $this->render('admin/restaurant_recommendation/index.html.twig', [
            'restaurant_recommendations' => $restaurantRecommendationRepository->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/admin/restaurant/recommendation/new', name: 'app_admin_restaurant_recommendation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restaurantRecommendation = new RestaurantRecommendation();
        $form = $this->createForm(RestaurantRecommendationType::class, $restaurantRecommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restaurantRecommendation);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_restaurant_recommendation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/restaurant_recommendation/new.html.twig', [
            'restaurant_recommendation' => $restaurantRecommendation,
            'form' => $form,
        ]);
    }

    #[Route('/admin/restaurant/recommendation/{id}/edit', name: 'app_admin_restaurant_recommendation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] RestaurantRecommendation $restaurantRecommendation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestaurantRecommendationType::class, $restaurantRecommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_restaurant_recommendation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/restaurant_recommendation/edit.html.twig', [
            'restaurant_recommendation' => $restaurantRecommendation,
            'form' => $form,
        ]);
    }

    #[Route('/admin/restaurant/recommendation/{id}', name: 'app_admin_restaurant_recommendation_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] RestaurantRecommendation $restaurantRecommendation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurantRecommendation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($restaurantRecommendation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_restaurant_recommendation_index', [], Response::HTTP_SEE_OTHER);
    }
}
