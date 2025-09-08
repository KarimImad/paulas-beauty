<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Service;
use App\Repository\CategoryRepository;
use App\Repository\ReviewRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, ReviewRepository $reviewRepository ): Response
    {
        $services = $serviceRepository->findAll();
        $reviews = $reviewRepository->findAll();

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'reviews' => $reviews,
        ]);
    }
}
