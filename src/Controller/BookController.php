<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\EventSubscriber\DateSubscriber;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
    public function __construct(private Security $security)
    {
        $this->security = $security;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/rendez-vous', name: 'app_book_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        $user = $this->getUser();
        return $this->render('book/index.html.twig', [
            'appointments' => $appointmentRepository->findBy(['client' => $user]),
        ]);
    }


    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppointmentRepository $appointmentRepository, MailerInterface $mailer): Response
    {
        $appointment = new Appointment();
        $user = $this->security->getUser();
        $appointment->setClient($user);

        // Récupérer le dernier rendez-vous de l'utilisateur
        $lastAppointment = $appointmentRepository->findOneBy(['client' => $user], ['date' => 'DESC']);

        // Pré-remplir les informations du formulaire avec les informations du dernier rendez-vous
        if ($lastAppointment) {
            $appointment->setSurname($lastAppointment->getSurname());
            $appointment->setAge($lastAppointment->getAge());
            $appointment->setBreed($lastAppointment->getBreed());
            $appointment->setSexe($lastAppointment->getSexe());
            $appointment->setService($lastAppointment->getService());
        }
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentRepository->save($appointment, true);

            // // Envoyer un e-mail à l'utilisateur avec un lien pour modifier la réservation
            // $email = (new Email())
            //     ->from('no-reply-confirmation@nononscut.fr')
            //     ->to($appointment->getClient()->getEmail())
            //     ->subject('Confirmation de votre réservation')
            //     ->html($this->renderView('home/index.html.twig', [
            //         'appointment' => $appointment,
            //         'edit_url' => $this->generateUrl('app_book_edit', ['id' => $appointment->getId()])
            //     ]));

            // $mailer->send($email);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('book/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentRepository->save($appointment, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->request->get('_token'))) {
            $appointmentRepository->remove($appointment, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
