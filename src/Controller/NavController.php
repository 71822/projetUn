<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render("navigation/accueil.html.twig");
    }



    /**
     * @Route("/propos", name="propos")
     */
    public function propos()
    {
        // if (!isEmpty($films)) {
        //     return $this->redirectToRoute('accueil');
        // }
        return $this->render("navigation/propos.html.twig");
    }



    /**
     * @Route("/redirect", name="redirect")
     */
    public function homeRedirect()
    {

        return $this->redirectToRoute('accueil');
    }
}
