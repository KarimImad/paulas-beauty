<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
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
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/add/{id}/', name: 'app_booking_new', methods:['GET'])]
    //Définit une route pour ajouter un produit au panier
    public function addServiceToBooking(int $id, SessionInterface $session, Request $request, Service $service): Response //int veut dire qu'on attend obligatoirement que l'id soit un entier
    //Méthode pour ajouter un produit au panier, prend l'ID du produit et la session en paramètres
    {
        $booking= $session->get('service',[]);

        // Récupère le panier actuel de la session, ou un tableau vide si il n'existe pas
         


      
        $session->set('booking',$booking);
        //Met à jour le panier dans la session 
        return $this->redirectToRoute('app_booking');
        // Redirige vers la page du panier
    }
}
