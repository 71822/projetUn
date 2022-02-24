<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\FilmType;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\Constraint\IsEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FilmController extends AbstractController
{
    /**
     * @Route("/createFilm", name="createFilm")
     * @Route("/updateFilm/{id}", name="updateFilm")
     */
    public function index(Films $film = null, Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $entityManager = $doctrine->getManager();


        if (!$film) {
            $film = new Films;
        }


        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $film = $form->getData();
            $entityManager->persist($film);
            $entityManager->flush();


            return $this->redirectToRoute('listingFilm');
        }

        $errors = $validator->validate($film);
        return $this->render('film/createFilm.html.twig', [
            'form' => $form->createView(),
            'isEditor' => $film->getId(),
            'errors' => $errors

        ]);
    }




    /**
     * @Route("/listingFilm", name="listingFilm")
     */
    public function listing(ManagerRegistry $doctrine)
    {
        $films = $doctrine->getManager()->getRepository(Films::class)->findAll();

        return $this->render("navigation/listingFilm.html.twig", ["films" => $films]);
    }



    /**
     * @Route("/showFilm/{id}", name="showFilm")
     */
    public function show(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $film = $entityManager->getRepository(Films::class)->find($id);


        return $this->render("film/showFilm.html.twig", ["film" => $film]);
    }




    /**
     * @Route("/deleFilm/{id}", name="deleteFilm")
     */
    public function delete(ManagerRegistry $doctrine, $id)
    {
        $entityManager = $doctrine->getManager();
        $film = $entityManager->getRepository(Films::class)->find($id);


        if (isset($film)) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listingFilm');
    }
}
