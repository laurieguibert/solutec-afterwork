<?php
/**
 * Created by PhpStorm.
 * User: lguibert
 * Date: 07/09/2018
 * Time: 17:06
 */

namespace App\Controller;

use App\Repository\AfterworkRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index", methods="GET")
     */
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('admin/index.html.twig', ['sites' => $siteRepository->findAll()]);
    }
}