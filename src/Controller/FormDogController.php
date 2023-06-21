<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use App\Repository\DogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/réservation')]
class FormDogController extends AbstractController
{
    #[Route('/liste', name: 'app_form_dog_index', methods: ['GET'])]
    public function index(DogRepository $dogRepository): Response
    {
        return $this->render('form_dog/index.html.twig', [
            'dogs' => $dogRepository->findAll(),
        ]);
    }

    #[Route(name: 'app_form_dog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DogRepository $dogRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $client = $this->getUser();

        // Récupérer le chien pour lequel l'utilisateur a déjà pris un rendez-vous
        $dog = $dogRepository->findOneBy(['client' => $client]);

        // Si aucun chien n'a été trouvé, créer une nouvelle instance de Dog
        if (!$dog) {
            $dog = new Dog();
        }

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer le chien au client connecté
            $dog->setClient($client);

            $dogRepository->save($dog, true);

            return $this->redirectToRoute('app_form_dog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('form_dog/new.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_form_dog_show', methods: ['GET'])]
    public function show(Dog $dog): Response
    {
        return $this->render('form_dog/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/{id}/édition', name: 'app_form_dog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dog $dog, DogRepository $dogRepository): Response
    {
        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dogRepository->save($dog, true);

            return $this->redirectToRoute('app_form_dog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('form_dog/edit.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_form_dog_delete', methods: ['POST'])]
    public function delete(Request $request, Dog $dog, DogRepository $dogRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dog->getId(), $request->request->get('_token'))) {
            $dogRepository->remove($dog, true);
        }

        return $this->redirectToRoute('app_form_dog_index', [], Response::HTTP_SEE_OTHER);
    }
}
