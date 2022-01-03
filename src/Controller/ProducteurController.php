<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produit;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/api/producteur", name="api_producteur_")
 */
class ProducteurController extends AbstractController
{
    /**
     * @Route("/produit", name="produit", methods={"POST"})
     * @ParamConverter("produit", converter="fos_rest.request_body")
     */
    public function produit(Produit $produit): Response
    {
        $errors = $this->get('validator')->validate($produit);

        if (count($errors)) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();

        return $produit;
    }
}
