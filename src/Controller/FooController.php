<?php

namespace App\Controller;

use App\Form\ImportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ImportType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd('ass');
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
