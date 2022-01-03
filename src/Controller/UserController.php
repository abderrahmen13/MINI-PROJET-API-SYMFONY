<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api", name="api_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/api/places/{id}",name="places_detail", requirements = {"id"="\d+"})
     * @View()
     */
    public function getPlace($id,PlaceRepository $repo)
    {
        $place = $repo->find($id);
        // transformer les objets en tableau  
       
        return $place;
    }

    /**
     * @Route("/api/users",name="users_list")
     * @View(statusCode=200,serializerGroups={"guser"})
     */
    public function getUsers(UserRepository $repo)
    {
        $users = $repo->findAll();
        // transformer les objets en tableau  
        $formatted = [];
        foreach ($users as $user) {
            $formatted[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
            ];
        }
        return new JsonResponse($formatted);
    }
    

    public function getuser1(userRepository $repo, $id)
    {
        $user = $repo->find($id);
       // dd($p);
        return $this->json($user, 200);
    }
}
