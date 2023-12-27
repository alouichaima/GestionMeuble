<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index( SessionInterface $session)
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);

    }

    #[Route('/cart1', name: 'cart1')]
    public function index1( SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier=$session->get('panier',[]);

        //on initilise des variable
        $data=[];
        $total=0;

        foreach ($panier as $id =>$quantite){
            $produit=$produitRepository->find($id);
            $data[]=[
                'produit'=>$produit,
                'quantite'=>$quantite
            ];
            $total+=$produit->getPrix()*$quantite;
        }
        return $this->render('cart/index.html.twig',  [
            'data' => $data,
            'total' => $total,
        ]);


    }
        #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Produit $produit, SessionInterface $session)
    {
        //recup id du produit
        $id=$produit->getId();

        //recup le panier existant
        $panier=$session->get('panier',[]);

        //ajout produit dans session dans le panier
        if(empty($panier[$id])){
            $panier[$id]=1;
        }else{
            $panier[$id]++;
        }


        $session->set('panier',$panier);

        //redirection vers page panier
        return $this->redirectToRoute('cart1');
    }
    #[Route('cart/remove/{id}', name: 'remove')]
    public function remove(Produit $produit, SessionInterface $session)
    {
        //recup id du produit
        $id=$produit->getId();

        //recup le panier existant
        $panier=$session->get('panier',[]);

        //supprm produit dans session dans le panier
        if(!empty($panier[$id])){
            if($panier[$id]>1){
                $panier[$id]--;
        }else{
            //pour détruire une variable
           unset($panier[$id]) ;
        }}
        $session->set('panier',$panier);

        //redirection vers page panier
        return $this->redirectToRoute('cart1');
    }

    #[Route('cart/delete/{id}', name: 'delete')]
    public function delete(Produit $produit, SessionInterface $session)
    {
        //recup id du produit
        $id=$produit->getId();

        //recup le panier existant
        $panier=$session->get('panier',[]);

        if(!empty($panier[$id])){
                unset($panier[$id]) ;
            }
        $session->set('panier',$panier);

        //redirection vers page panier
        return $this->redirectToRoute('cart1');
    }

    #[Route('cart/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');
        return $this->redirectToRoute('cart1');
    }
    }
