<?php
/**
 * Created by PhpStorm.
 * User: lguibert
 * Date: 06/09/2018
 * Time: 12:17
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends Controller
{
    /**
     * Default routing
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * Affiche la page d'accueil avec un compteur jusqu'au prochain afterwork
     */
    public function index(Environment $twig){
        $nextAfterwork = $this->getDoctrine()->getRepository('App:Afterwork')->findOneByDateField();
        return new Response($twig->render('home/index.html.twig', [
            "nextAfterwork" => $nextAfterwork[0]
        ]));
    }
}