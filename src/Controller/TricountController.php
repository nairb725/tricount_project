<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Entity\Tricount;
use App\Form\TricountType;
use App\Repository\TricountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;


/**
 * @Route("/tricount")
 */
class TricountController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="tricount_index", methods={"GET"})
     */
    public function index(TricountRepository $tricountRepository): Response
    {
        return $this->render('tricount/index.html.twig', [
            'tricounts' => $tricountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tricount_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tricount = new Tricount();
        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tricount);
            $entityManager->flush();

            return $this->redirectToRoute('tricount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tricount/new.html.twig', [
            'tricount' => $tricount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="tricount_show", methods={"GET"})
     */
    public function show(Tricount $tricount): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $expenses = $manager->getRepository(Expense::class)->findByTricount($tricount);
        $names = [];
        $i = 0;
        foreach($expenses as $expense) {
            $j = 0;
            $names[$i]['price'] = $expense->getPrice();
            $names[$i]['name'] = $expense->getName();
            $names[$i]['date'] = $expense->getDate();
            $creators = $expense->getCreator();
            $names[$i]['creator'] = $creators->getName();
            $users = $expense->getUsers();
                foreach ($users as $user) {
                    $names[$i]['user'][$j] = $user->getName();
                    $j++;
                }


            $i++;
        }

        return $this->render('tricount/show.html.twig', [
            'tricount' => $tricount,
            'expenses' => $expenses,
            'names' => $names
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tricount_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tricount $tricount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tricount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tricount/edit.html.twig', [
            'tricount' => $tricount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="tricount_delete", methods={"POST"})
     */
    public function delete(Request $request, Tricount $tricount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tricount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tricount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tricount_index', [], Response::HTTP_SEE_OTHER);
    }
}
