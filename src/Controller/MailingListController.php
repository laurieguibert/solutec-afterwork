<?php

namespace App\Controller;

use App\Entity\MailingList;
use App\Form\MailingListType;
use App\Repository\MailingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mailing/list")
 *
 * CRUD Liste de diffusion
 */
class MailingListController extends Controller
{
    /**
     * @param Request $request
     * @param MailingListRepository $mailingListRepository
     * @return Response
     *
     * Liste toutes les listes de diffusion et générer le formulaire de création sur la même page (ajax)
     */
    public function index(Request $request, MailingListRepository $mailingListRepository): Response
    {
        $mailingList = new MailingList();
        $form = $this->createForm(MailingListType::class, $mailingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailingList);
            $em->flush();
        }

        return $this->render('mailing_list/index.html.twig', [
            'mailing_lists' => $mailingListRepository->findAll(),
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/{id}", name="mailing_list_show", methods="GET")
     * @param MailingList $mailingList
     * @return Response
     *
     * Affiche une liste de diffusion selon son id
     */
    public function show(MailingList $mailingList): Response
    {
        return $this->render('mailing_list/show.html.twig', ['mailing_list' => $mailingList]);
    }

    /**
     * @Route("/{id}/edit", name="mailing_list_edit", methods="GET|POST")
     * @param Request $request
     * @param MailingList $mailingList
     * @return Response
     *
     * Modifie une liste de diffusion
     */
    public function edit(Request $request, MailingList $mailingList): Response
    {
        $form = $this->createForm(MailingListType::class, $mailingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('mailing_list/edit.html.twig', [
            'mailing_list' => $mailingList,
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mailing_list_delete", methods="DELETE")
     * @param Request $request
     * @param MailingList $mailingList
     * @return Response
     *
     * Supprime une liste de diffusion
     */
    public function delete(Request $request, MailingList $mailingList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailingList->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mailingList);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
