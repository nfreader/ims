<?php

namespace App\Controller;

use App\Form\NewIncidentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IncidentRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'guest')]
    public function index(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/guest.html.twig');
    }

    #[Route('/home', name: 'app_home')]
    public function home(IncidentRepository $incidentRepository): Response
    {
        $form = $this->createForm(NewIncidentFormType::class, null, [
            'action' => $this->generateUrl('new_incident')
        ]);

        return $this->render('home/index.html.twig', [
            'incidents' => $incidentRepository->findAll(),
            'incidentForm' => $form->createView()
        ]);
    }
}
