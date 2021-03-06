<?php

namespace Eklerni\DatabaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AttribuerRepository extends EntityRepository {

    public function findByEleve($idEleve)
    {
        echo "repo";
        return $this->_em->createQueryBuilder()
            ->select("a")
            ->from("EklerniDatabaseBundle:Attribuer", "a")
            ->innerJoin("a.eleve", "e")
            ->where("e.id = :idEleve")
            ->andwhere("a.isDelete = 0")
            ->setParameter("idEleve", $idEleve );
    }

    public function findBySerie($idSerie)
    {
        return $this->_em->createQueryBuilder()
            ->select("a")
            ->from("EklerniDatabaseBundle:Attribuer", "a")
            ->where("a.idSerie = :idSerie")
            ->andwhere("a.isDelete = 0")
            ->setParameter("idSerie", $idSerie );
    }

} 