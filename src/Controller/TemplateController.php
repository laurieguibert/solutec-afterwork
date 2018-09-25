<?php

namespace App\Controller;

use App\Entity\Template;
use App\Form\TemplateType;
use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/template")
 *
 * CRUD Template de mails
 */
class TemplateController extends Controller
{
    /**
     * @param TemplateRepository $templateRepository
     * @return Response
     *
     * Liste tous les templates de mails
     */
    public function index(TemplateRepository $templateRepository): Response
    {
        return $this->render('template/index.html.twig', ['templates' => $templateRepository->findAll()]);
    }

    /**
     * @Route("/new", name="template_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     *
     * Crée un template de mail
     */
    public function new(Request $request): Response
    {
        $template = new Template();
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($template);
            $em->flush();

            $fileSystem = new Filesystem();
            $fileSystem->dumpFile($this->get('kernel')->getRootDir() . "/../templates/emails/" . str_replace(' ', '_', $template->getName()) . ".html.twig", $template->getBody());

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('template/new.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="template_show", methods="GET")
     * @param Template $template
     * @return Response
     *
     * Affiche un template de mails
     */
    public function show(Template $template): Response
    {
        return $this->render('template/show.html.twig', ['template' => $template]);
    }

    /**
     * @Route("/{id}/edit", name="template_edit", methods="GET|POST")
     * @param Request $request
     * @param Template $template
     * @return Response
     *
     * Modifie un template de mails
     */
    public function edit(Request $request, Template $template): Response
    {
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('template/edit.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="template_delete", methods="DELETE")
     * @param Request $request
     * @param Template $template
     * @return Response
     *
     * Supprime un template de mails
     */
    public function delete(Request $request, Template $template): Response
    {
        if ($this->isCsrfTokenValid('delete'.$template->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($template);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
