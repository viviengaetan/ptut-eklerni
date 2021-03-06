<?php

namespace Eklerni\DatabaseBundle\Manager;

use Doctrine\ORM\EntityManager;
use Eklerni\DatabaseBundle\Entity\BaseEntity;
use Eklerni\DatabaseBundle\Entity\Classe;
use Eklerni\DatabaseBundle\Entity\Eleve;

class EleveManager extends BaseManager
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository("EklerniDatabaseBundle:Eleve");
    }

    /**
     * {@inheritdoc}
     */
    public function save(BaseEntity $entity)
    {
        if (property_exists($entity, 'dateModification')) {
            $entity->setDateModification(new \DateTime('now'));
        }

        if (null === $entity->getId()) {
            if (property_exists($entity, 'dateCreation')) {
                $entity->setDateCreation(new \DateTime('now'));
            }
            $this->em->persist($entity);
        }
        $this->em->flush();
        $entity->upload();
        $this->em->flush();
    }

    /**
     * @param Classe $classe
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByClasse(Classe $classe)
    {
        return $this->repository->findByClasse($classe->getId())->getQuery()->getResult();
    }

    /**
     * @param Eleve $eleve
     * @return string
     */
    public function defineUsername(Eleve $eleve)
    {
        $i = 1;
        while (!$this->isUsernameExists($eleve->generateUsername($i))) {
            $i++;
        }
        return $eleve->getUsername();
    }

    /**
     * @param $username
     * @return bool
     */
    public function isUsernameExists($username)
    {
        if (count($this->repository->isUsernameExists($username)->getQuery()->getResult())) {
            return false;
        } else {
            return true;
        }
    }
}