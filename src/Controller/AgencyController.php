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

    public function agency(): Response
    {
        $agency = $this->entityManager
            ->getRepository(Agency::class)
            ->findOneBy(['name' => 'Nonos Cut']);

        return $this->render('include/_navbar.html.twig', [
            'agency' => $agency
        ]);
    }

    // #[Route('/agence', name: 'app_agency')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $agency = new Agency();

    //     $agency
    //         ->setName('Nonos Cut')
    //         ->setAddress('11 rue de l\'os')
    //         ->setLogo('https://www.cjoint.com/doc/23_06/MFEoVqePzqU_logo-site.png')
    //         ->setMobile('+33123456789');

    //     $entityManager->persist($agency);
    //     $entityManager->flush();
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'AgencyController',
    //     ]);
    // }
}
