<?php

namespace App\Controller;

use App\Entity\Galery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GaleryController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function galery(): Response
    {
        $galeries = $this->entityManager
            ->getRepository(Galery::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'galeries' => $galeries,
        ]);
    }

    // #[Route('/galerie', name: 'app_galery')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     //find the image
    //     $image = file_get_contents('/Users/coralineday/Desktop/coupe.jpg');

    //     $galery = new Galery();

    //     $galery
    //         ->setName('Manucure pour Toutou')
    //         ->setImage($image);

    //     $entityManager->persist($galery);
    //     $entityManager->flush();
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'GaleryController',
    //     ]);
    // }
}
