<?php
/**
 * Created by PhpStorm.
 * User: lguibert
 * Date: 07/09/2018
 * Time: 17:06
 */

namespace App\Controller;

use App\Entity\MailingList;
use App\Form\MailingListType;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/", name="admin_index", methods="GET|POST")
     */
    public function index(Request $request, SiteRepository $siteRepository): Response
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

        return $this->render('admin/index.html.twig', [
            'sites' => $siteRepository->findAll(),
            'mailing_list' => $mailingList,
            'form' => $form->createView()
        ]);
    }
}