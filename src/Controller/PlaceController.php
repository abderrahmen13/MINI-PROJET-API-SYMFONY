<?php

namespace App\Controller;

use App\Entity\Place;
use App\Repository\UserRepository;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Serializer\JMSSerializerAdapter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\Get; // N'oublons pas d'inclure Get



class PlaceController extends AbstractFOSRestController//AbstractController
{
    
    
    /**
     * @Route("/places",name="places",methods={"GET"})
     */
    public function getPlaces1(PlaceRepository $repo)

    {

        $places = $repo->findAll();
        // transformer les objets en tableau  
        $formatted = [];
        foreach ($places as $place) {
            $formatted[] = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'address' => $place->getAdresse(),
            ];
        }

        return new JsonResponse($formatted);
    }

    
  
    
    /**
     * @Get("/api/places/{id}",name="places_detail", requirements = {"id"="\d+"})
     * @View()
     */
    public function getPlace($id,PlaceRepository $repo)

    {

        $place = $repo->find($id);
        // transformer les objets en tableau  
       
        return $place;
    }
     /**
     * @Get("/api/places",name="places_list")
     * @View(statusCode=200, serializerGroups={"gplace1"})
     */
    public function getPlaces(PlaceRepository $repo)

    {
        $places = $repo->findAll();
        // transformer les objets en tableau  
       
        return $places;
    }

    /**
     * @Get("/api/users",name="users_list")
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function getUsers(UserRepository $repo)

    {
        $users = $repo->findAll();
        // transformer les objets en tableau  
       
        return $users;
    }

}
