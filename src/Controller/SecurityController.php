<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/", name="redirect_login")
     *
     */
    public function redirect_login()
    {
        return $this->redirectToRoute('operation_index');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder();

        //Permet de récuperer les info de la classe en cour et son "image" dans la BDD
        $entityManager = $qb->getEntityManager();

        //On compte le nombre d'opération affecter a l'employé utilisé
        $nbEmployee = $qb->select('employee')
            ->from('App\Entity\Employee', 'employee');

        $nbEmployee = $qb->getQuery()->getResult();

        if (count($nbEmployee) == 0) {
            return $this->redirectToRoute('app_register');
        }

        if ($this->getUser()) {
            return $this->redirectToRoute('operation_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
