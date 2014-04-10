<?php

namespace Eklerni\CASBundle\Controller;

use Eklerni\DatabaseBundle\Entity\Enseignant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SignController extends Controller
{

    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();


        $enseignant = new Enseignant();
        $formLogin = $this->createForm("eklerni_login", $enseignant);
        $error = null;

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('translator')->trans("login.error");
        } else {
            if ($request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR))
                $error = $this->get('translator')->trans("login.error");
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }


        return $this->render('EklerniCASBundle:Sign:login.html.twig', array(
            'form' => $formLogin->createView(),
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'form_error' => $error,
            'title' => $this->get('translator')->trans("login.title")
        ));
    }

    public function loginCheckAction()
    {
        // The security layer will intercept this request
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        // The security layer will intercept this request
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
} 