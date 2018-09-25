<?php

namespace App\Controller;

use App\Entity\Afterwork;
use App\Entity\Involvement;
use App\Form\AfterworkType;
use App\Form\NewAfterworkType;
use App\Repository\AfterworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/afterwork")
 */
class AfterworkController extends Controller
{
    /**
     * @Route("/", name="afterwork_index", methods="GET")
     */
    public function index(AfterworkRepository $afterworkRepository): Response
    {
        return $this->render('afterwork/index.html.twig', ['afterworks' => $afterworkRepository->findBy([], ['date' => 'DESC'])]);
    }

    /**
     * @Route("/new", name="afterwork_new", methods="GET|POST")
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $afterwork = new Afterwork();
        $form = $this->createForm(NewAfterworkType::class, $afterwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($form['users']->getData() as $user){
                $involvement = new Involvement();
                $involvement->setUser($user);
                $involvement->setAfterwork($afterwork);
                $involvement->setResponse('Sans réponse');
                $em->persist($involvement);

                /*$vCalendar = new \Eluceo\iCal\Component\Calendar('myCalendar');
                $vEvent = new \Eluceo\iCal\Component\Event();

                $vEvent
                    ->setDtStart($form['date']->getData())
                    ->setNoTime(true)
                    ->setSummary('Christmas')
                ;

                $vCalendar->addComponent($vEvent);

                header('Content-Type: text/calendar; charset=utf-8');
                header('Content-Disposition: attachment; filename="cal.ics"');

                $vCalendar->render();

                $attachment = (new \Swift_Attachment())
                    ->setContentType('text/calendar')
                    ->setBody($vCalendar)
                ;*/

                $message = (new \Swift_Message($form['name']->getData()))
                    ->setFrom('laurie.guibert@consultants-solutec.fr')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $form['content'],
                        'text/html'
                    );
                    //->attach($attachment);

                $mailer->send($message);
            }
            $em->persist($afterwork);
            $em->flush();

            return $this->redirectToRoute('afterwork_index');
        }

        return $this->render('afterwork/new.html.twig', [
            'afterwork' => $afterwork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="afterwork_show", methods="GET")
     */
    public function show(Afterwork $afterwork): Response
    {
        return $this->render('afterwork/show.html.twig', ['afterwork' => $afterwork]);
    }

    /**
     * @Route("/{id}/edit", name="afterwork_edit", methods="GET|POST")
     */
    public function edit(Request $request, Afterwork $afterwork): Response
    {
        $form = $this->createForm(AfterworkType::class, $afterwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('afterwork_index');
        }

        return $this->render('afterwork/edit.html.twig', [
            'afterwork' => $afterwork,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="afterwork_delete", methods="DELETE")
     */
    public function delete(Request $request, Afterwork $afterwork): Response
    {
        if ($this->isCsrfTokenValid('delete'.$afterwork->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($afterwork);
            $em->flush();
        }

        return $this->redirectToRoute('afterwork_index');
    }
}
