<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/category")
 *
 * CRUD catégorie
 */
class CategoryController extends Controller
{
    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     *
     * Liste toutes les catégories
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', ['categories' => $categoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="category_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     *
     * Créer une nouvelle catégorie de campagnes
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods="GET")
     * @param Category $category
     * @return Response
     *
     * Affiche une catégorie
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods="GET|POST")
     * @param Request $request
     * @param Category $category
     * @return Response
     *
     * Modifie une catégorie
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods="DELETE")
     * @param Request $request
     * @param Category $category
     * @return Response
     *
     * Supprime une catégorie
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
