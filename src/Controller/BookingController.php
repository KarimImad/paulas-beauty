<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ServiceRepository;
use App\Repository\ScheduleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BookingController extends AbstractController
{
    public function __construct(private readonly ServiceRepository $serviceRepository) //private=accessible que depuis l'interieur de la classe, readonly=propriete assignée une seule fois dans le constructeur
    {
        
    }

    #[Route('/booking', name: 'app_booking')]
    public function index(SessionInterface $session, Service $service): Response
    {


        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/select/{id}', name: 'app_select_booking', methods:['GET'])]
    public function selectBooking(Service $service, SessionInterface $session): Response
    {
        // On stocke l'id du service choisi dans la session
        // Exemple : si l'utilisateur clique sur "Pose gel" avec l'id = 3,
        // on va enregistrer dans la session : selected_service = 3
        $session->set('selected_service', $service->getId());

        // Ensuite, on redirige vers la route "app_choose_booking"
        // => ça va afficher la page pour choisir une date/heure
        return $this->redirectToRoute('app_chosen_booking');
    }


   #[Route('/booking/chosen', name: 'app_chosen_booking', methods:['GET'])]
    public function chooseBooking(SessionInterface $session, ServiceRepository $serviceRepo): Response
    {
        $serviceId = $session->get('selected_service');

        if (!$serviceId) {
            throw $this->createNotFoundException('Aucun service sélectionné');
        }

        $service = $serviceRepo->find($serviceId);

        // ⚡ Récupérer les créneaux de ce service
        $schedules = $service->getSchedules();

        return $this->render('booking/index.html.twig', [
            'service' => $service,
            'schedules' => $schedules,
        ]);
    }



}
