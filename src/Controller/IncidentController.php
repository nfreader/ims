<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\NewEventFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentController extends AbstractController
{
    #[Route('/incident/new', name: 'new_incident')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $incident = new Incident();
        $form = $this->createForm(NewIncidentFormType::class, $incident);
        $form->handleRequest($request);
        $incident->setCreator($this->getUser());
        $incident->setCreatedAt(new DateTime());
        $incident->setUpdatedAt(new DateTime());
        $entityManager->persist($incident);
        $entityManager->flush();
        $this->addFlash('success', 'Your incident has been created');

        return $this->redirectToRoute('view_incident', ['id' => $incident->getId()]);
    }
    #[Route('/incident/{id}', name: 'view_incident')]
    public function view(Incident $incident): Response
    {
        $form = $this->createForm(NewEventFormType::class, null, [
            'action' => $this->generateUrl('new_event', ['id'=>$incident->getId()])
        ]);
        return $this->render('incident/index.html.twig', [
            'incident' => $incident,
            'eventForm' => $form->createView()
        ]);
    }
}
