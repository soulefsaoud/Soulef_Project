<?php

namespace App\Controller;

use App\Entity\DailyMenu;
use App\Form\DailyMenuType;
use App\Repository\DailyMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/daily/menu')]
class DailyMenuController extends AbstractController
{
    #[Route('/', name: 'daily_menu_index', methods: ['GET'])]
    public function index(DailyMenuRepository $dailyMenuRepository): Response
    {
        return $this->render('daily_menu/index.html.twig', [
            'daily_menus' => $dailyMenuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'daily_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $dailyMenu = new DailyMenu();
        $form = $this->createForm(DailyMenuType::class, $dailyMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dailyMenu);
            $entityManager->flush();

            return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('daily_menu/new.html.twig', [
            'daily_menu' => $dailyMenu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'daily_menu_show', methods: ['GET'])]
    public function show(DailyMenu $dailyMenu): Response
    {
        return $this->render('daily_menu/show.html.twig', [
            'daily_menu' => $dailyMenu,
        ]);
    }

    #[Route('/{id}/edit', name: 'daily_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DailyMenu $dailyMenu): Response
    {
        $form = $this->createForm(DailyMenuType::class, $dailyMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('daily_menu/edit.html.twig', [
            'daily_menu' => $dailyMenu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'daily_menu_delete', methods: ['POST'])]
    public function delete(Request $request, DailyMenu $dailyMenu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dailyMenu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dailyMenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
