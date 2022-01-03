<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\View;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    /**
     * @Route("/api/produits", name="produits_list")
     * @View(statusCode=200, serializerGroups={"gplace1"})
     */
    public function getProduits(ProduitsRepository $repo)
    {
        $produits = $repo->findAll();
        // transformer les objets en tableau  
       
        return $produits;
    }

}
