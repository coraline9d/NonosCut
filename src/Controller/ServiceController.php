<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/service', name: 'app_service')]
    public function service(): Response
    {
        $services = $this->entityManager
            ->getRepository(Service::class)
            ->findAll();

        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }

    // #[Route('/service', name: 'app_service')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {

    //     //search agency
    //     $agencyRepository = $entityManager->getRepository(Agency::class);
    //     $agency = $agencyRepository->findOneBy(['name' => 'Nonos Cut']);

    //     $service = new Service();

    //     $service
    //         ->setName('Chien de -5kg')
    //         ->setDescription('Pour vos toutous de -5kg, Nonos Cut vous propose : un démellage des poils de votre chien selon sa race, avant de passer au bac à shampoing pour lui donner un petit bain, enfin un séchage en douceur lui sera donné, suivi de l\'égalisation de ses poils ainsi que la coupe de ses ongles pour sublimer le tout. Et voilà, votre chien sera prêt à affronter la prochaine flaque d\'eau ;) ')
    //         ->setDuration(3)
    //         ->setPrice(60)
    //         ->setImage('https://www.cjoint.com/doc/23_07/MGbnMHLmAcU_bichon.jpg');

    //     $entityManager->persist($service);
    //     $entityManager->flush();
    //     return $this->render('service/index.html.twig', [
    //         'controller_name' => 'ServiceController',
    //     ]);
    // }
}
