<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salle")
 */
class SalleController extends AbstractController
{
    /**
     * @Route("/", name="salle_index", methods={"GET"})
     */
    public function index(SalleRepository $salleRepository): Response
    {
        return $this->render('salle/index.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="salle_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$salle->getId()) {
                $salle->setCreatedAt(new \DateTimeImmutable("now"));
            }
            $salle->setUpdatedAt(new \DateTime("now"));

            $entityManager->persist($salle);
            $entityManager->flush();

            return $this->redirectToRoute('salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salle/new.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="salle_show", methods={"GET"})
     */
    public function show(Salle $salle): Response
    {
        return $this->render('salle/show.html.twig', [
            'salle' => $salle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="salle_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $salle->setUpdatedAt(new \DateTime("now"));
            $entityManager->flush();

            return $this->redirectToRoute('salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('salle/edit.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="salle_delete", methods={"POST"})
     */
    public function delete(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $salle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($salle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('salle_index', [], Response::HTTP_SEE_OTHER);
    }
}
