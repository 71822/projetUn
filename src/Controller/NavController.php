<?php

namespace App\Controller;

use App\Entity\Films;
use App\Entity\Seance;
use App\Repository\FilmsRepository;
use App\Repository\SeanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods={"GET"})
     */
    public function listingFilm(FilmsRepository $filmRepository, SeanceRepository $seanceRepository, ManagerRegistry $doctrine): Response
    {


        return $this->render('film/listingFilm.html.twig', [
            'films' => $filmRepository->findAll(),
            'seance' => $seanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/showFilm/{id}", name="showFilm")
     */
    public function show(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $film = $entityManager->getRepository(Films::class)->find($id);
        $seance = $entityManager->getRepository(Seance::class)->findBy(array("films" => $id));


        return $this->render("navigation/showFilm.html.twig", ["film" => $film, "seance" => $seance,]);
    }


    //     // if (!isEmpty($films)) {
    //     //     return $this->redirectToRoute('accueil');
    //     // }
    //     return $this->render("navigation/propos.html.twig");
    // }



    /**
     * @Route("/redirect", name="redirect")
     */
    public function homeRedirect()
    {

        return $this->redirectToRoute('accueil');
    }
}
