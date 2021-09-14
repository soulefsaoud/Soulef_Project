<?php

namespace App\Controller;

use App\Entity\Fitness;
use App\Form\FitnessType;
use App\Repository\FitnessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/fitness')]
class FitnessController extends AbstractController
{
    #[Route('/', name: 'fitness_index', methods: ['GET'])]
    public function index(FitnessRepository $fitnessRepository): Response
    {
        return $this->render('fitness/index.html.twig', [
            'fitnesses' => $fitnessRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'fitness_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $fitness = new Fitness();
        $form = $this->createForm(FitnessType::class, $fitness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fitness);
            $entityManager->flush();

            return $this->redirectToRoute('fitness_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitness/new.html.twig', [
            'fitness' => $fitness,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'fitness_show', methods: ['GET'])]
    public function show(Fitness $fitness): Response
    {
        return $this->render('fitness/show.html.twig', [
            'fitness' => $fitness,
        ]);
    }

    #[Route('/{id}/edit', name: 'fitness_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fitness $fitness): Response
    {
        $form = $this->createForm(FitnessType::class, $fitness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fitness_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fitness/edit.html.twig', [
            'fitness' => $fitness,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'fitness_delete', methods: ['POST'])]
    public function delete(Request $request, Fitness $fitness): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fitness->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fitness);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fitness_index', [], Response::HTTP_SEE_OTHER);
    }
}
