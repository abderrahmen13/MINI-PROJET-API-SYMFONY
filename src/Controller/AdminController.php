<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\View;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

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
}
