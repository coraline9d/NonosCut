<?php

namespace App\Controller;

use App\Entity\Galery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GaleryController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
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
    //     $galery = new Galery();

    //     $galery
    //         ->setName('Bain avant Toilettage')
    //         ->setImage('https://www.cjoint.com/doc/23_07/MGbnOvi0uqU_douche.jpg');

    //     $entityManager->persist($galery);
    //     $entityManager->flush();
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'GaleryController',
    //     ]);
    // }
}
