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
    //     //find the image
    //     $image = file_get_contents('/Users/coralineday/Desktop/retriever.jpg');

    //     //search agency
    //     $agencyRepository = $entityManager->getRepository(Agency::class);
    //     $agency = $agencyRepository->findOneBy(['name' => 'Nonos Cut']);

    //     $service = new Service();

    //     $service
    //         ->setName('Chien de +10kg')
    //         ->setDescription('Pour vos toutous de +10kg, Nonos Cut vous propose : un démellage des poils de votre chien selon sa race, avant de passer au bac à shampoing pour lui donner un petit bain, enfin un séchage en douceur lui sera donné. Et voilà, votre chien sera prêt à affronter la prochaine flaque d\'eau ;) ')
    //         ->setDuration(1)
    //         ->setPrice(40)
    //         ->setImage($image)
    //         ->setAgency($agency);

    //     $entityManager->persist($service);
    //     $entityManager->flush();
    //     return $this->render('service/index.html.twig', [
    //     'controller_name' => 'ServiceController',
    //     ]);
    // }
}
