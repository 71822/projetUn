<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\Constraint\IsEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/updateFilm/{id}", name="updateFilm")
     */
    public function index(Request $request, ManagerRegistry $doctrine, $id = null): Response
    {
        $entityManager = $doctrine->getManager();
        $isEditor = false;



        if (isset($id)) {
            $films = $entityManager->getRepository(Films::class)->find($id);
            if (!isset($films)) {
                return $this->redirectToRoute('listingFilm');
            }
            $isEditor = true;
        } else {
            $films = new Films;
        }




        $form = $this->createFormBuilder($films)
            ->add("title", TextType::class, [
                'required' => true,
            ])

            ->add("realisateur", TextType::class)
            ->add("genre", TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Film'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $films = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($films);
            $entityManager->flush();


            return $this->redirectToRoute('listingFilm');
        }

        return $this->render('film/createFilm.html.twig', [
            'form' => $form->createView(),
            'isEditor' => $isEditor

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
