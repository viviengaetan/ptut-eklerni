<?php

namespace Eklerni\DatabaseBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Eklerni\DatabaseBundle\Entity\Activite;
use Eklerni\DatabaseBundle\Entity\Eleve;
use Eklerni\DatabaseBundle\Entity\Enseignant;
use Eklerni\DatabaseBundle\Entity\Matiere;
use Eklerni\DatabaseBundle\Entity\Resultat;
use Eklerni\DatabaseBundle\Entity\Serie;

class ResultatManager extends BaseManager
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository("EklerniDatabaseBundle:Resultat");
    }

    /**
     * @param Enseignant $enseignant
     * @param integer $limit
     * @param array $orderby
     * @return mixed
     */
    public function findByProf(Enseignant $enseignant, $limit = null, array $orderby = array())
    {
        /** @var QueryBuilder $query */
        $query = $this->repository->findByProf($enseignant->getId());
        if ($limit) {
            $query->setMaxResults($limit);
        }
        if (isset($orderby["champs"])) {
            if (isset($orderby["order"])) {
                $query->orderBy("r." . $orderby["champs"], $orderby["order"]);
            } else {
                $query->orderBy("r." . $orderby["champs"]);
            }
        }

        return $query->getQuery()->getResult();
    }

    public function findByEleve(Eleve $eleve, $limit = null, array $orderby = array())
    {

        /** @var QueryBuilder $query */
        $query = $this->repository->findByEleve($eleve->getId());

        if ($limit) {
            $query->setMaxResults($limit);
        }
        if (isset($orderby["champs"])) {
            if (isset($orderby["order"])) {
                $query->orderBy("r." . $orderby["champs"], $orderby["order"]);
            } else {
                $query->orderBy("r." . $orderby["champs"]);
            }
        }

        return $query->getQuery()->getResult();
    }


    public function findResults(array $condition = array(), $limit = null, array $orderby = array())
    {
        /** @var QueryBuilder $query */
        $query = $this->repository->findAll();

        /** @var Serie $serie */
        if (isset($condition["serie"]) && $serie = $condition['serie']) {
            $query->innerJoin("r.serie", "s")
                ->andWhere("s.id = :idserie")
                ->setParameter("idserie", $serie->getId());
        }

        /** @var Eleve $eleve */
        if (isset($condition["eleve"]) && $eleve = $condition['eleve']) {
            $query->innerJoin("r.eleve", "e")
                ->andWhere("e.id = :ideleve")
                ->setParameter("ideleve", $eleve->getId());
        }

        /** @var Activite $activite */
        if (isset($condition["activite"]) && $activite = $condition['activite']) {
            if (!isset($condition["serie"])) {
                $query->innerJoin("r.serie", "s");
            }
            $query->innerJoin("s.activite", "a")
                ->andwhere("a.id = :idactivite")
                ->setParameter("idactivite", $activite->getId());
        }

        /** @var Matiere $matiere */
        if (isset($condition["matiere"]) && $matiere = $condition['matiere']) {
            if (!isset($condition["serie"])) {
                $query->innerJoin("r.serie", "s");
            }
            if (!isset($condition["activite"])) {
                $query->innerJoin("s.activite", "a");
            }
            $query->innerJoin("a.matiere", "m")
                ->andwhere("m.id = :idmatiere")
                ->setParameter("idmatiere", $matiere->getId());
        }

        /** @var Enseignant $enseignant */
        if (isset($condition["enseignant"]) && $enseignant = $condition['enseignant']) {
            if (!isset($condition["serie"]) && !isset($condition["activite"]) && !isset($condition["matiere"])) {
                $query->innerJoin("r.serie", "s");
            }
            $query->innerJoin("s.enseignant", "p")
                ->andWhere("p.id = :idenseignant")
                ->setParameter("idenseignant", $enseignant->getId());
        }


        if ($limit) {
            $query->setMaxResults($limit);
        }
        if (isset($orderby["champs"])) {
            if (isset($orderby["order"])) {
                $query->orderBy("r." . $orderby["champs"], $orderby["order"]);
            } else {
                $query->orderBy("r." . $orderby["champs"]);
            }
        }

        return $query->getQuery()->getResult();
    }

} 