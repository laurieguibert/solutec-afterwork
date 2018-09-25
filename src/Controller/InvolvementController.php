<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvolvementController extends Controller
{
    /**
     * @Route("/involvement", name="involvement")
     * @return Response
     *
     * Liste toutes les participations des consultants aux afterworks
     */
    public function index()
    {
        return $this->render('involvement/index.html.twig', [
            'controller_name' => 'InvolvementController',
        ]);
    }

    /**
     * @Route("/involvement/response", name="involvement_ajax_response")
     * @param Request $request
     * @return Response
     *
     * Requête ajax
     * Modifie la réponse d'un consultant concernant sa participation à un afterwork
     */
    public function changeUserResponse(Request $request){
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'UPDATE involvement SET response = :response WHERE user_id = :user_id AND afterwork_id = :afterwork';

        $statement = $em->getConnection()->prepare($RAW_QUERY);

        $statement->bindValue('response', $request->query->get('response'));
        $statement->bindValue('user_id', $request->query->get("user_id"));
        $statement->bindValue('afterwork', $request->query->get('afterwork_id'));
        $statement->execute();

        /*$involvement->setResponse($request->query->get("response"));

        $em->persist($involvement);
        $em->flush();*/

        return new Response("ok");
    }
}
