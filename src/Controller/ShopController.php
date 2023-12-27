<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll(); // Vous pouvez ajuster cette requête selon vos besoins
        return $this->render('shop/index.html.twig', [
            'produits' => $produits,
        ]);
    }


}