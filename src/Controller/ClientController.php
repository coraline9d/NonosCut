<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    // #[Route('/client', name: 'app_client')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $client = new Client();

    //     $plainPassword = '';
    //     $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

    //     $client
    //         ->setEmail('')
    //         ->setPassword($hashedPassword)
    //         ->setRoles(["ROLE_ADMIN"])
    //         ->setNickName('')
    //         ->setLastName('')
    //         ->setMobile('');


    //     $entityManager->persist($client);
    //     $entityManager->flush();
    //     return $this->render('client/index.html.twig', [
    //         'controller_name' => 'ClientController',
    //     ]);
    // }
}
