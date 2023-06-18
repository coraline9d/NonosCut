<?php

namespace App\Controller;

use App\Entity\Agency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgencyController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_agency')]
    public function agency(): Response
    {
        $agency = $this->entityManager
            ->getRepository(Agency::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'agency' => $agency,
        ]);
    }

    // #[Route('/agence', name: 'app_agency')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     //find the image
    //     $image = file_get_contents('/Users/coralineday/Desktop/logo-site.png');

    //     $agency = new Agency();

    //     $agency
    //         ->setName('Nonos Cut')
    //         ->setAddress('11 rue de l\'os')
    //         ->setLogo($image)
    //         ->setMobile('+33123456789');

    //     $entityManager->persist($agency);
    //     $entityManager->flush();
    //     return $this->render('home/index.html.twig', [    
    //     'controller_name' => 'AgencyController',
    //     ]);
    // }
}
