<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\Constraint\IsEmpty;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FilmController extends AbstractController
{
    // /**
    //  * @Route("/film_accueil", name="film_accueil")
    //  */
    // public function accueil()
    // {
    //     return $this->render("film/index.html.twig");
    // }
    /**
     * @Route("/createFilm", name="createFilm")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();

        $film = new Films;
        $film->setTitle('Spiderman');
        $film->setRealisateur('Spider');
        $film->setGenre('Action');

        $entityManager->persist($film);
        $entityManager->flush();

        return new Response('Saved new film with title : ' . $film->getTitle());
    }

    /**
     * @Route("/listingFilm", name="listingFilm")
     */
    public function listing(ManagerRegistry $doctrine)
    {
        $films = $doctrine->getManager()->getRepository(Films::class)->findAll();

        return $this->render("navigation/listingFilm.html.twig", ["films" => $films]);
    }
}
