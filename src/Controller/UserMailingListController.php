<?php

namespace App\Controller;

use App\Entity\UserMailingList;
use App\Form\UserMailingListType;
use App\Repository\UserMailingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/mailing/list")
 */
class UserMailingListController extends Controller
{
    /**
     * @Route("/", name="user_mailing_list_index", methods="GET")
     */
    public function index(UserMailingListRepository $userMailingListRepository): Response
    {
        return $this->render('user_mailing_list/index.html.twig', ['user_mailing_lists' => $userMailingListRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_mailing_list_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $userMailingList = new UserMailingList();
        $form = $this->createForm(UserMailingListType::class, $userMailingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userMailingList);
            $em->flush();

            return $this->redirectToRoute('user_mailing_list_index');
        }

        return $this->render('user_mailing_list/new.html.twig', [
            'user_mailing_list' => $userMailingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_mailing_list_show", methods="GET")
     */
    public function show(UserMailingList $userMailingList): Response
    {
        return $this->render('user_mailing_list/show.html.twig', ['user_mailing_list' => $userMailingList]);
    }

    /**
     * @Route("/{id}/edit", name="user_mailing_list_edit", methods="GET|POST")
     */
    public function edit(Request $request, UserMailingList $userMailingList): Response
    {
        $form = $this->createForm(UserMailingListType::class, $userMailingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_mailing_list_edit', ['id' => $userMailingList->getId()]);
        }

        return $this->render('user_mailing_list/edit.html.twig', [
            'user_mailing_list' => $userMailingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_mailing_list_delete", methods="DELETE")
     */
    public function delete(Request $request, UserMailingList $userMailingList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userMailingList->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userMailingList);
            $em->flush();
        }

        return $this->redirectToRoute('user_mailing_list_index');
    }
}
