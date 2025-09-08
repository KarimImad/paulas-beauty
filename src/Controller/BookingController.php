<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ServiceRepository;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    public function __construct(private readonly ServiceRepository $serviceRepository)
    {
    }

    /**
     * Page principale : liste tous les services
     */
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        $services = $this->serviceRepository->findAll();

        return $this->render('booking/index.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * Sélection d’un service
     */
    #[Route('/booking/select/{id}', name: 'app_select_booking', methods:['GET'])]
    public function selectBooking(int $id, SessionInterface $session): Response
    {
        $session->set('selected_service', $id);

        return $this->redirectToRoute('app_choose_booking');
    }

    /**
     * Choix du créneau pour un service
     */
    #[Route('/booking/choose', name: 'app_choose_booking', methods:['GET'])]
    public function chooseBooking(SessionInterface $session, ServiceRepository $serviceRepo): Response
    {
        $serviceId = $session->get('selected_service');

        if (!$serviceId) {
            return $this->redirectToRoute('app_booking');
        }

        $service = $serviceRepo->find($serviceId);

        $schedules = $service->getSchedules()->filter(fn($s) => !$s->getIsBooked());

        return $this->render('booking/choose.html.twig', [
            'service' => $service,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Confirmation de réservation
     */
    #[Route('/booking/confirmation/{scheduleId}', name: 'app_confirmation', methods:['GET','POST'])]
    public function confirmation(
        int $scheduleId,
        SessionInterface $session,
        ServiceRepository $serviceRepo,
        ScheduleRepository $scheduleRepo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $serviceId = $session->get('selected_service');

        if (!$serviceId) {
            return $this->redirectToRoute('app_booking');
        }

        $service = $serviceRepo->find($serviceId);
        $schedule = $scheduleRepo->find($scheduleId);

        if (!$schedule || $schedule->getIsBooked()) {
            $this->addFlash('error', 'Ce créneau n’est plus disponible.');
            return $this->redirectToRoute('app_choose_booking');
        }

        if ($request->isMethod('POST')) {
            $order = new Order();
            $order->setService($service);
            $order->setSchedule($schedule);
            $order->setCreatedAt(new \DateTimeImmutable());

            $startHour = $schedule->getStartHour();
            if ($startHour instanceof \DateTime) {
                $startHour = \DateTimeImmutable::createFromMutable($startHour);
            }
            $order->setScheduleAt($startHour);

            $order->setIsCompleted(true);
            $order->setFirstName($request->request->get('first_name'));
            $order->setLastName($request->request->get('last_name'));
            $order->setEmail($request->request->get('email'));
            $order->setPhone($request->request->get('phone'));

            $em->persist($order);
            $schedule->setIsBooked(true);
            $em->flush();

            $session->remove('selected_service');

            // ✅ On redirige avec le scheduleId
            return $this->redirectToRoute('app_confirmation_success', [
                'scheduleId' => $schedule->getId(),
            ]);
        }

        return $this->render('booking/confirmation.html.twig', [
            'service' => $service,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Page de succès après réservation
     */
    #[Route('/booking/confirmation/{scheduleId}/success', name: 'app_confirmation_success', methods:['GET'])]
    public function confirmationSuccess(int $scheduleId, ScheduleRepository $scheduleRepo): Response
    {
        $schedule = $scheduleRepo->find($scheduleId);

        if (!$schedule) {
            throw $this->createNotFoundException('Créneau introuvable.');
        }

        // Récupérer la dernière commande liée à ce créneau
        $orders = $schedule->getOrders();
        $order = $orders->last() ?: null;

        return $this->render('booking/confirmation_success.html.twig', [
            'order' => $order,
            'service' => $schedule->getService(),
            'schedule' => $schedule,
        ]);
    }
}
