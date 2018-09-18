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
 */
class MailingListController extends Controller
{
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
     * @Route("/new", name="mailing_list_new", methods="GET|POST")
     */
    /**public function new(Request $request): Response
    {
        $mailingList = new MailingList();
        $form = $this->createForm(MailingListType::class, $mailingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailingList);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('mailing_list/new.html.twig', [
            'mailing_list' => $mailingList,
            'form' => $form->createView(),
        ]);
    }**/

    /**
     * @Route("/{id}", name="mailing_list_show", methods="GET")
     */
    public function show(MailingList $mailingList): Response
    {
        return $this->render('mailing_list/show.html.twig', ['mailing_list' => $mailingList]);
    }

    /**
     * @Route("/{id}/edit", name="mailing_list_edit", methods="GET|POST")
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
