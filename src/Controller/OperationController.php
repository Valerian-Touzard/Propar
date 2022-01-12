<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

use function PHPSTORM_META\type;

/**
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/", name="operation_index", methods={"GET"})
     */
    public function index(OperationRepository $operationRepository): Response
    {
        $tmp = $operationRepository->findAll();
        $revenue = 0;
        foreach ($tmp as $operation) {
            if ($operation->getStatus() != "cancelled") {
                switch ($operation->getType()) {
                    case ("big"):
                        $revenue += 10000;
                        break;
                    case ("medium"):
                        $revenue += 2500;
                        break;
                    case ("small"):
                        $revenue += 1000;
                        break;
                    default:
                        break;
                }
            }
        }
        return $this->render('operation/index.html.twig', [
            'operations' => $operationRepository->findAll(),
            'revenue' => $revenue,
        ]);
    }

    /**
     * @Route("/new", name="operation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estReussi = false;
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Création d'une instance QueryBuilder
            $qb = $entityManager->createQueryBuilder();

            //Permet de récuperer les info de la classe en cour et son "image" dans la BDD
            $entityManager = $qb->getEntityManager();

            //On compte le nombre d'opération affecter a l'employé utilisé
            $nbOperation = $qb->select('operation')
                ->from('App\Entity\Operation', 'operation')
                ->where('operation.userId = ?1')
                ->setParameter(1, $operation->getUserId()->getId());

            $nbOperation = $qb->getQuery()->getResult();

            // dd(count($nbOperation));
            // dd($operation->getUserId()->getRoles()[0]);
            switch ($operation->getUserId()->getRoles()[0]) {
                case 'ROLE_EXPERT':
                    if (count($nbOperation) < 5) {
                        $estReussi = true;
                    }
                    break;
                case 'ROLE_SENIOR':
                    if (count($nbOperation) < 3) {
                        $estReussi = true;
                    }
                    break;
                case 'ROLE_APPRENTICE':
                    if (count($nbOperation) < 1) {
                        $estReussi = true;
                    }
                    break;
            }

            if ($estReussi) {
                $entityManager->persist($operation);
                $entityManager->flush();
                return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->renderForm('operation/new.html.twig', [
                    'operation' => $operation,
                    'form' => $form,
                    'error' => "Cet Employé a déjà son nombre maximal d'opération (" . count($nbOperation) . ")",
                ]);
            }
        }

        return $this->renderForm('operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form,
            'error' => "",
        ]);
    }

    /**
     * @Route("/{id}", name="operation_show", methods={"GET"})
     */
    public function show(Operation $operation): Response
    {
        return $this->render('operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $estReussi = false;

            $qb = $entityManager->createQueryBuilder();

            //Permet de récuperer les info de la classe en cour et son "image" dans la BDD
            $entityManager = $qb->getEntityManager();

            //On compte le nombre d'opération affecter a l'employé utilisé
            $nbOperation = $qb->select('operation')
                ->from('App\Entity\Operation', 'operation')
                ->where('operation.userId = ?1')
                ->setParameter(1, $operation->getUserId()->getId());

            $nbOperation = $qb->getQuery()->getResult();

            // dd(count($nbOperation));
            // dd($operation->getUserId()->getRoles()[0]);
            switch ($operation->getUserId()->getRoles()[0]) {
                case 'ROLE_EXPERT':
                    if (count($nbOperation) < 5) {
                        $estReussi = true;
                    }
                    break;
                case 'ROLE_SENIOR':
                    if (count($nbOperation) < 3) {
                        $estReussi = true;
                    }
                    break;
                case 'ROLE_APPRENTICE':
                    if (count($nbOperation) < 1) {
                        $estReussi = true;
                    }
                    break;
            }

            if ($estReussi) {
                $entityManager->flush();
                return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->renderForm('operation/edit.html.twig', [
                    'operation' => $operation,
                    'form' => $form,
                    'error' => "Cet Employé a déjà son nombre maximal d'opération (" . count($nbOperation) . ")",
                ]);
            }
        }

        return $this->renderForm('operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form,
            'error' => '',
        ]);
    }

    /**
     * @Route("/{id}", name="operation_delete", methods={"POST"})
     */
    public function delete(Request $request, Operation $operation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $operation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
    }
}
