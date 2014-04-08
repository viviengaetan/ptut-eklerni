<?php

namespace Eklerni\DatabaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClasseRepository extends EntityRepository implements CASRepositoryInterface {

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("EklerniDatabaseBundle:Classe", "c");
    }

    /**
     * @param $id integer
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findById($id)
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("EklerniDatabaseBundle:Classe", "c")
            ->where("c.id = :id")
            ->setParameter("id", $id);
    }

    /**
     * @param $idProf integer
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByProf($idProf)
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("EklerniDatabaseBundle:Classe", "c")
            ->innerJoin("c.enseignants","p")
            ->where("p.id = :id")
            ->setParameter("id", $idProf);

    }

}