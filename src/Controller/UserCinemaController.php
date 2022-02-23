<?php

namespace App\Controller;

use App\Entity\UserCinema;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCinemaController extends AbstractController
{
    // /**
    //  * @Route("/userCinema", name="userCinema")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('user_cinema/index.html.twig', [
    //         'controller_name' => 'UserCinemaController',
    //     ]);
    // }
    /**
     * @Route("/createUser", name="createUser")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();

        $user = new UserCinema;
        $user->setNameUser('Spider');
        $user->setUserSurname('Man');
        $user->setMailUser('mail');

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Saved new user with name : ' . $user->getNameUser());
    }

    /**
     * @Route("/user", name="user")
     */
    public function userCinema(ManagerRegistry $doctrine)
    {
        $users = $doctrine->getManager()->getRepository(UserCinema::class)->findAll();

        return $this->render("user_cinema/index.html.twig", ["users" => $users]);
    }
}
