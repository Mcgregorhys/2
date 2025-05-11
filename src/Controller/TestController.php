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
         $result = null;
        
        if ($request->isMethod('POST')) {
            $number = $request->request->get('number');
            $result = (new \App\Twig\Components\Test())->checkNumber($number);
        }
    
    return $this->render('test/index.html.twig', [
            'result' => $result
        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        //     'result' => $result
        ]);
    }
    
}