<?php

namespace Eklerni\DatabaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository implements CASRepositoryInterface
{

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select("m")
            ->from("EklerniDatabaseBundle:Media", "m");
    }
    
    public function findByMedia($media)
    {
        return $this->_em->createQueryBuilder()
            ->select("m")
            ->from("EklerniDatabaseBundle:Media", "m")
            ->where("m.media = :media")
            ->setParameter("media", $media);
    }

    /**
     * @param $idProf integer
     * @return mixed
     */
    public function findByProf($idProf)
    {
        return null;
    }
}