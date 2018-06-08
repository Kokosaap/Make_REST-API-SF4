<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiViewController extends Controller
{
    /**
     * @Route("/", name="api_viewhp")
     */
    public function index()
    {
        return $this->render('api_view/index.html.twig', [
            'controller_name' => 'ApiViewController',
        ]);
    }
}
