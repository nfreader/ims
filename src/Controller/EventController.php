<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\NewEventFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\IncidentRepository;

class EventController extends AbstractController
{
    #[Route('/incident/{id}/event/new', name: 'new_event')]
    public function index(Request $request, EntityManager $entityManager, IncidentRepository $incidentRepository, int $id): Response
    {
        $incident = $incidentRepository->find($id);
        $event = new Event();
        $form = $this->createForm(NewEventFormType::class, $event);
        $form->handleRequest($request);
        $event->setIncident($incident);
        // $event->setCreatedAt(new DateTime());
        // $event->setUpdatedAt(new DateTime());
        $entityManager->persist($event);
        $entityManager->flush();
        $this->addFlash('success', 'Your event has been created');

        return $this->redirectToRoute('view_incident', ['id' => $incident->getId()]);
    }
}
