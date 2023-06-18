<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DogController extends AbstractController
{
    // #[Route('/chien', name: 'app_dog')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $clientRepository = $entityManager->getRepository(Client::class);
    //     $client = $clientRepository->findOneBy(['email' => 'day.coraline@live.fr']);

    //     $dog = new Dog();

    //     $dog
    //         ->setNickName('Happy')
    //         ->setAge(11)
    //         ->setBreed('Bichon Maltais')
    //         ->setSexe(['femelle'])
    //         ->setWeight(4.6)
    //         ->setClient($client);

    //     $entityManager->persist($dog);
    //     $entityManager->flush();
    //     return $this->render('dog/index.html.twig', [
    //         'controller_name' => 'DogController',
    //     ]);
    // }
}
