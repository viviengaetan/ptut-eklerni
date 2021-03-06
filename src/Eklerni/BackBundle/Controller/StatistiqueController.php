<?php

namespace Eklerni\BackBundle\Controller;

use Eklerni\BackBundle\Form\Type\ResultatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatistiqueController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        //TODO datedebut use calandar
        $form = $this->createForm(
            new ResultatType(
                $this->getUser()
            ), null
        );
        $form->handleRequest($request);
        $resultats = null;
        $moyennes = null;
        $typemoyenne = null;
        $typerecherche = null;
        $typechoisi = null;
        if ($form->isValid()) {
            $data = $form->getData();
            //$data["enseignant"] = $this->getUser();
            $resultats = $this->get('eklerni.manager.resultat')->findResults($data, $data["limit"], array());
            if($data["moyenne"]) {
                $typemoyenne = $data["moyenne"];
                $temp_resultat = array();
                $moyennes = array();
                foreach($resultats as $result) {
                    $temp_resultat[] = $result[0];
                    if(isset($result["note"])) {
                        $moyennes[$result[0]->getId()] = round($result["note"]);
                    } else {
                        $moyennes[$result[0]->getId()] = null;
                    }
                }
                $resultats = $temp_resultat;
            }
            if($data["matiere"] || $data["moyenne"] == "matiere"){$typerecherche = "1";}
            if($data["activite"]){$typerecherche = "2";}
            if($data["serie"])  {$typerecherche = "3";}
            if($data["classe"] || $data["moyenne"] == "classe") {$typechoisi = "1";}
            if($data["eleve"]  || $data["moyenne"] == "eleve")  {$typechoisi = "2";}
        }

        return $this->render(
            'EklerniBackBundle:Statistique:index.html.twig',
            array(
                'title' => $this->get('translator')->trans("title.statistiques"),
                'form' => $form->createView(),
                'resultats' => $resultats,
                "moyennes" => $moyennes,
                "typemoyenne" => $typemoyenne,
                "typerecherche" => $typerecherche,
                "typechoisi" => $typechoisi
            )
        );
    }
} 