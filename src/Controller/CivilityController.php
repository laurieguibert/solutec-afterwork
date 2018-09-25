<?php

namespace App\Controller;

use App\Entity\Civility;
use App\Form\CivilityType;
use App\Repository\CivilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/civility")
 */
class CivilityController extends Controller
{
    /**
     * @Route("/", name="civility_index", methods="GET")
     * @param CivilityRepository $civilityRepository
     * @return Response
     *
     * Liste toutes les civilités
     */
    public function index(CivilityRepository $civilityRepository): Response
    {
        return $this->render('civility/index.html.twig', ['civilities' => $civilityRepository->findAll()]);
    }

    /**
     * @Route("/new", name="civility_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     *
     * Crée une civilité
     */
    public function new(Request $request): Response
    {
        $civility = new Civility();
        $form = $this->createForm(CivilityType::class, $civility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($civility);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('civility/new.html.twig', [
            'civility' => $civility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="civility_show", methods="GET")
     * @param Civility $civility
     * @return Response
     *
     * Affiche une civilité
     */
    public function show(Civility $civility): Response
    {
        return $this->render('civility/show.html.twig', ['civility' => $civility]);
    }

    /**
     * @Route("/{id}/edit", name="civility_edit", methods="GET|POST")
     * @param Request $request
     * @param Civility $civility
     * @return Response
     *
     * Modifie une civilité
     */
    public function edit(Request $request, Civility $civility): Response
    {
        $form = $this->createForm(CivilityType::class, $civility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('civility/edit.html.twig', [
            'civility' => $civility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="civility_delete", methods="DELETE")
     * @param Request $request
     * @param Civility $civility
     * @return Response
     *
     * Supprime une civilité
     */
    public function delete(Request $request, Civility $civility): Response
    {
        if ($this->isCsrfTokenValid('delete'.$civility->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($civility);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
