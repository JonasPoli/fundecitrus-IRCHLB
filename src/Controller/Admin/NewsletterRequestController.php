<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterRequest;
use App\Form\NewsletterRequestType;
use App\Repository\NewsletterRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

final class NewsletterRequestController extends AbstractController
{
    #[Route('/admin/newsletter/request', name: 'admin_newsletter_request_index', methods: ['GET'])]
    public function index(NewsletterRequestRepository $newsletterRequestRepository): Response
    {
        return $this->render('admin/newsletter_request/index.html.twig', [
            'newsletter_requests' => $newsletterRequestRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/admin/newsletter/request/export', name: 'admin_newsletter_request_export', methods: ['GET'])]
    public function export(NewsletterRequestRepository $newsletterRequestRepository): Response
    {
        $requests = $newsletterRequestRepository->findBy([], ['createdAt' => 'DESC']);

        $response = new StreamedResponse(function () use ($requests) {
            $handle = fopen('php://output', 'w+');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
            
            fputcsv($handle, ['ID', 'Email', 'Data de Solicitação']);

            foreach ($requests as $request) {
                fputcsv($handle, [
                    $request->getId(),
                    $request->getEmail(),
                    $request->getCreatedAt()?->format('d/m/Y H:i:s') ?? '',
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="newsletter_subscriptions_' . date('Y-m-d_H-i-s') . '.csv"');

        return $response;
    }

    #[Route('/admin/newsletter/request/new', name: 'admin_newsletter_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newsletterRequest = new NewsletterRequest();
        $form = $this->createForm(NewsletterRequestType::class, $newsletterRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newsletterRequest);
            $entityManager->flush();

            return $this->redirectToRoute('admin_newsletter_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/newsletter_request/new.html.twig', [
            'newsletter_request' => $newsletterRequest,
            'form' => $form,
        ]);
    }

    #[Route('/admin/newsletter/request/{id}/edit', name: 'admin_newsletter_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'id')] NewsletterRequest $newsletterRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NewsletterRequestType::class, $newsletterRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_newsletter_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/newsletter_request/edit.html.twig', [
            'newsletter_request' => $newsletterRequest,
            'form' => $form,
        ]);
    }

    #[Route('/admin/newsletter/request/{id}', name: 'admin_newsletter_request_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'id')] NewsletterRequest $newsletterRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletterRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($newsletterRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_newsletter_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
