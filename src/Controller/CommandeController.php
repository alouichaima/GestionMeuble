<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ListeCommande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{

    #[Route('/commande/index', name: 'commande_index')]
    public function index(): Response
    {
        // Your logic for displaying the index template
        return $this->render('commande/index.html.twig');
    }

    #[Route('/add', name:'add')]
    public function add(SessionInterface $session , ProduitRepository $produitRepository,
    EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $panier=$session->get('panier',[]);

//        if($panier===[]){
//            $this->addFlash('Message', 'your basket is empty');
//           return $this->redirectToRoute('app_home_page');
//        }

        //si le panier n'est pas vide , creation cmd
        $commande=new Commande();

        //remplit la cmd
        $commande->setUser($this->getUser());

        //parcours  le panier pour créer les details de commande
        foreach ($panier as $item =>$quantite){
            $liste_cmd = new ListeCommande();

            //chercher produits
            $product=$produitRepository->find($item);
            $prix=$product->getPrix();

            //creation details de commande
            $liste_cmd->setProduit($product);
            $liste_cmd->setPrix($prix);
            $liste_cmd->setQuantite($quantite);

            $commande->addListeCommande($liste_cmd);


        }

        //on persiste et on flush(exect reqt)
        $commande->setDate(new \DateTimeImmutable());
        $em->persist($commande);
        $em->flush();

        $session->remove('panier');


        $this->addFlash('message','Order created successfully');
        return $this->redirectToRoute('commande_index');


//        return $this->render('commande/index.html.twig', [
//            'controller_name' => 'CommandeController',
//        ]);
    }
}
