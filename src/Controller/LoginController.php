<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function index(): Response
    {
        $user = $this->getUser() ?? null;
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = "";
        return $this->json([
            'message' => 'You are logged in successfully',
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
