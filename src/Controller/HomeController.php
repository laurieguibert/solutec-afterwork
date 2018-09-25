<?php
/**
 * Created by PhpStorm.
 * User: lguibert
 * Date: 06/09/2018
 * Time: 12:17
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends Controller
{
    public function index(Environment $twig){
        $nextAfterwork = $this->getDoctrine()->getRepository('App:Afterwork')->findOneByDateField();
        return new Response($twig->render('home/index.html.twig', [
            "nextAfterwork" => $nextAfterwork[0]
        ]));
    }
}