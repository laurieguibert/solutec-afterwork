<?php
/**
 * Created by PhpStorm.
 * User: lguibert
 * Date: 14/09/2018
 * Time: 10:44
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailerController extends Controller
{
    public function index($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            )
        ;

        $mailer->send($message);
    }
}