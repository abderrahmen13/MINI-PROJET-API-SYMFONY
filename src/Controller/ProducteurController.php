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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/producteur", name="api_producteur_")
 */
class ProducteurController extends AbstractController
{
    /**
     * @Route("/produits", name="produits", methods={"GET","HEAD"})
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function produits(ProduitRepository $repo, SerializerInterface $serializer): Array
    {
        $produits = $repo->findBy(['user' => $this->getUser()]);
        return $produits;
    }

    /**
     * @Route("/produit", name="add_produit", methods={"POST"})
     * @ParamConverter("produit", converter="fos_rest.request_body")
     */
    public function add_produit(Produit $produit, ValidatorInterface $validator): Response
    {
        $errors = $validator->validate($produit);

        // if (count($errors)) {
        //     return $this->json($errors, Response::HTTP_BAD_REQUEST);
        // }
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();

        return $produit;
    }

    /**
     * @Route("/produit/{id}", name="update_produit", methods={"PUT"}, requirements = {"id"="\d+"})
     * @ParamConverter("produit", converter="fos_rest.request_body")
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function update_produit($id, Produit $produit, ProduitRepository $repo, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $errors = $validator->validate($produit);

        // if (count($errors)) {
        //     return $this->json($errors, Response::HTTP_BAD_REQUEST);
        // }

        $newproduit = $repo->find($id);
        $newproduit->setName($produit->getName());
        $newproduit->setImage($produit->getImage());
        $newproduit->setDateRecolte($produit->getDateRecolte());
        $newproduit->setQuantite($produit->getQuantite());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newproduit);
        $em->flush();

        return $newproduit;
    }

    /**
     * @Route("/produit/{id}", name="delete_produit", methods={"DELETE"}, requirements = {"id"="\d+"})
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function delete_produit($id, ProduitRepository $repo, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $produit = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();

        return $id;
    }
}
