<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/homePage', name: 'app_home_page')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll(); // Vous pouvez ajuster cette requête selon vos besoins

        return $this->render('home_page/index.html.twig', [
            'produits' => $produits,  // Ajoutez cette ligne pour passer les produits à votre vue

            'controller_name' => 'HomePageController',
        ]);
    }
}
