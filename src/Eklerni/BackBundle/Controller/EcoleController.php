<?php

namespace Eklerni\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eklerni\DatabaseBundle\Entity\Ecole;
use Symfony\Component\HttpFoundation\Request;

class EcoleController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $ecole = new Ecole();

        $form = $this->createForm('eklerni_ecole', $ecole);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get("eklerni.manager.ecole")->save($ecole);
            return $this->redirect($this->generateUrl('eklerni_back_classe'));
        } else {
            return $this->render(
                'EklerniBackBundle:Ecole:ajouter.html.twig',
                array("form" => $form->createView(), "title" => $this->get('translator')->trans("title.create_ecole"))
            );
        }
    }

    public function modifierAction(Request $request, $idEcole)
    {
        /** @var Ecole $ecole */
        $ecole = $this->get("eklerni.manager.ecole")->findById($idEcole)[0];

        $form = $this->createForm('eklerni_ecole', $ecole);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get("eklerni.manager.ecole")->save($ecole);
            return $this->redirect($this->generateUrl('eklerni_back_direction'));
        } else {
            return $this->render(
                'EklerniBackBundle:Ecole:modifier.html.twig',
                array(
                    "form" => $form->createView(),
                    "title" => $this->get('translator')->trans("title.modify_ecole")
                )
            );
        }
    }
}