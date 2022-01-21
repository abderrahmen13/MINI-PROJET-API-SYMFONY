<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\View;
use App\Repository\UserRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/admin", name="api_admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producteurs", methods={"GET","HEAD"})
     */
    public function producteurs(UserRepository $repo): Response
    {
        $producteurs = $repo->findByRole('ROLE_PRODUCTEUR');
        // transformer les objets en tableau  
        $formatted = [];
        foreach ($producteurs as $producteur) {
            $formatted[] = [
                'id' => $producteur->getId(),
                'firstName' => $producteur->getFirstName(),
                'lastName' => $producteur->getLastName(),
                'email' => $producteur->getEmail(),
                'ville' => $producteur->getVille(),
                'adresse' => $producteur->getAdresse(),
                'telephone' => $producteur->getTelephone(),
                'valide' => $producteur->getValide(),
                'produits' => $producteur->getProduits(),
            ];
        }
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/consommateurs", name="consommateur", methods={"GET","HEAD"})
     */
    public function consommateurs(UserRepository $repo): Response
    {
        $consommateurs = $repo->findByRole('ROLE_USER');
        // transformer les objets en tableau  
        $formatted = [];
        foreach ($consommateurs as $consommateur) {
            $formatted[] = [
                'id' => $consommateur->getId(),
                'firstName' => $consommateur->getFirstName(),
                'lastName' => $consommateur->getLastName(),
                'email' => $consommateur->getEmail(),
                'reservations' => $consommateur->getReservations(),
            ];
        }
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/valide_producteur/{id}", name="valide_producteur", methods={"PUT"}, requirements = {"id"="\d+"})
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function valide_producteur($id, UserRepository $repo, SerializerInterface $serializer)
    {
        $producteur = $repo->find($id);
        $producteur->setValide(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($producteur);
        $em->flush();
        return $serializer->serialize($producteur->getValide(), 'json', ['groups' => ['guser']]);
    }

    /**
     * @Route("/categories", name="category", methods={"GET","HEAD"})
     */
    public function categories(CategorieRepository $repo): Response
    {
        $categories = $repo->findAll();
        // transformer les objets en tableau  
        $formatted = [];
        foreach ($categories as $category) {
            $formatted[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'produits' => $category->getProduits(),
            ];
        }
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/categorie", name="add_categorie", methods={"POST"})
     * @ParamConverter("categorie", converter="fos_rest.request_body")
     */
    public function add_categorie(Categorie $categorie, ValidatorInterface $validator): Response
    {
        $errors = $validator->validate($categorie);

        if (count($errors)) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();

        return $this->json($categorie, 200);
    }
}
