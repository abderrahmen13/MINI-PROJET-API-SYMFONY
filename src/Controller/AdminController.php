<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/api/admin", name="api_admin")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to Admin controller!',
        ]);
    }
}
