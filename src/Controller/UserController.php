<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Produit;
use App\Entity\Reservation;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/consommateur", name="api_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producteurs", methods={"POST"})
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function producteurs(Request $request, UserRepository $repo): Response
    {
        $producteurs = $repo->findBy(['ville' => $request->request->get('ville')]);
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
     * @Route("/reserver", name="reserver", methods={"POST"})
     * @ParamConverter("produit", converter="fos_rest.request_body")
     * @ParamConverter("reservation", converter="fos_rest.request_body")
     */
    public function reserver(Produit $produit, Reservation $reservation, ReservationRepository $repo, ProduitRepository $repoProduit, ValidatorInterface $validator): Response
    {
        $errors = $validator->validate($reservation);

        // if (count($errors)) {
        //     return $this->json($errors, Response::HTTP_BAD_REQUEST);
        // }
            
        $reservation->setUser($this->getUser());
        dd($reservation->getProduit());

        $produits = $repoProduit->find($reservation->getProduit());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        return $this->json($reservation, 200);
    }
}
