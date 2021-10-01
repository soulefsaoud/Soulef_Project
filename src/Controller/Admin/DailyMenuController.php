<?php

namespace App\Controller\Admin;

use App\Entity\DailyMenu;
use App\Form\DailyMenuType;
use App\Search\SearchProduit;
use App\MesServices\HandleImage;
use App\Repository\DailyMenuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/daily/menu')]
class DailyMenuController extends AbstractController
{
    #[Route('/', name: 'daily_menu_index', methods: ['GET'])]
    public function index(DailyMenuRepository $dailyMenuRepository,PaginatorInterface $paginator,Request $request): Response
    {

        $search = new SearchProduit();

        
        $form = $this->createForm(SearchProduitType::class, $search);

        $form->handleRequest($request);

        $daily_menus = $paginator->paginate(
            $dailyMenuRepository->findAllProduitByFilter($search),
            $request->query->getInt('page',1),
            3
        );


        return $this->render('daily_menu/index.html.twig', [
            'daily_menus' => $daily_menus, 
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'daily_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HandleImage $handleImage): Response
    {
        $dailyMenu = new DailyMenu();

        $form = $this->createForm(DailyMenuType::class,$dailyMenu);

        $form->handleRequest($request);

       
            $user = $this->getUser();
            
            $dailyMenu->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image_upload')->getData(); 

            if($imageFile)
            {
                $handleImage->saveImage($imageFile, $dailyMenu);

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dailyMenu);

           

            $entityManager->flush();
            
            $this->addFlash('success', 'Votre menu a bien été créee.');    
     
            return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/daily_menu/new.html.twig', [
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
    #ParamConverter("id", class="DailyMenu", options={"id": "id"})
    public function edit(Request $request, DailyMenu $dailyMenu, HandleImage $handleImage): Response
    {
        $form = $this->createForm(DailyMenuType::class, $dailyMenu);
        $form->handleRequest($request);

        $vintageImage = $dailyMenu->getImage();

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image_upload')->getData(); 

            if($imageFile)
            {
                $handleImage->editImage($imageFile, $dailyMenu, $vintageImage); 



            }



            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/daily_menu/edit.html.twig', [
            'daily_menu' => $dailyMenu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'daily_menu_delete', methods: ['POST'])]
    
    public function delete(Request $request, DailyMenu $dailyMenu, HandleImage $handleImage): Response
    {
        if ($this->isCsrfTokenValid('delete' .$dailyMenu->getId(), $request->request->get('_token'))) {


            $vintageImage = $dailyMenu->getImage();

            $handleImage->deleteImage($vintageImage); 


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dailyMenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('daily_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
