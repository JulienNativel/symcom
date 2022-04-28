<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        // étape 1 : est ce que le produit existe en bdd
        // étape 2 : pouvoir récupérer le panier sous forme de tableau dans la session
        // étape 3 : voir si le produit via son ($id) existe réellement dans le panier
        // étape 4 : si c'est le cas, on l'incrémente ($product++)
        // étape 5 : sinon on l'ajoute au panier
        // étape 6 : enregistrer le panier et le mettre à jour

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
