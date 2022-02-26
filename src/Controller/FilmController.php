<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\FilmType;
use App\Repository\FilmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\Constraint\IsEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/film")
 */
class FilmController extends AbstractController
{
    /**
     * @Route("/", name="film_index", methods={"GET"})
     */
    public function index(FilmsRepository $seanceRepository): Response
    {
        return $this->render('film/index.html.twig', ['films' => $seanceRepository->findAll(),]);
    }


    /**
     * @Route("/new", name="film_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $films = new Films();
        $form = $this->createForm(FilmType::class, $films);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $films->setCreatedAt(new \DateTimeImmutable("now"));
            $films->setUpdatedAt(new \DateTime("now"));
            $entityManager->persist($films);
            $entityManager->flush();
            return $this->redirectToRoute('film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('film/new.html.twig', ['films' => $films, 'form' => $form,]);
    }

    /**
     * @Route("/{id}", name="film_show", methods={"GET"})
     */
    public function show(Films $films): Response
    {
        return $this->render('film/show.html.twig', ['films' => $films,]);
    }


    /**
     * @Route("/{id}/edit", name="film_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Films $films, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmType::class, $films);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $films->setUpdatedAt(new \DateTime("now"));
            $entityManager->flush();
            return $this->redirectToRoute('film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('film/edit.html.twig', ['films' => $films, 'form' => $form,]);
    }

    /**
     * @Route("/{id}", name="film_delete", methods={"POST"})
     */
    public function delete(Request $request, Films $films, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $films->getId(), $request->request->get('_token'))) {
            $entityManager->remove($films);
            $entityManager->flush();
        }

        return $this->redirectToRoute('film_index', [], Response::HTTP_SEE_OTHER);
    }
}
