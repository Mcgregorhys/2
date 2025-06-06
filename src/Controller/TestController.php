<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Twig\Components\Test;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
   public function index(Request $request): Response
    {
          return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
        }
    
   
    }
    
