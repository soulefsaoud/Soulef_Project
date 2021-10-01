<?php

namespace App\Controller;

use App\Entity\Fitness;
use App\Form\FitnessType;
use App\Search\SearchProduit;
use App\Form\SearchProduitType;
use App\Repository\FitnessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/fitness')]
class FitnessController extends AbstractController
{
    #[Route('/', name: 'fitness_index', methods: ['GET'])]
    public function index(FitnessRepository $fitnessRepository,PaginatorInterface $paginator,Request $request): Response
    {
        
        $search = new SearchProduit();

        
        $form = $this->createForm(SearchProduitType::class, $search);

        $form->handleRequest($request);

        $fitnesses = $paginator->paginate(
            $fitnessRepository->findAllProduitByFilter($search),
            $request->query->getInt('page',1),
            3
        );


        return $this->render('fitness/index.html.twig', [
            'fitnesses' => $fitnesses, 
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'fitness_new', methods: ['GET', 'POST'])]
    #ParamConverter("id", class="Fitness", options={"id": "id"})
    public function new(Request $request): Response
    {
        $fitness = new Fitness();
        $form = $this->createForm(FitnessType::class, $fitness);
        $form->handleRequest($request);

        $user = $this->getUser();
            
        $fitness->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fitness);
            $entityManager->flush();

            $this->addFlash('success', 'Votre vidéo a bien été créé.');

            return $this->redirectToRoute('fitness_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fitness/new.html.twig', [
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
    #ParamConverter("id", class="Fitness", options={"id": "id"})
    public function edit(Request $request, Fitness $fitness): Response
    {
        $form = $this->createForm(FitnessType::class, $fitness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fitness_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fitness/edit.html.twig', [
            'fitness' => $fitness,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'fitness_delete', methods: ['POST'])]
    #ParamConverter("id", class="Fitness", options={"id": "id"})
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



