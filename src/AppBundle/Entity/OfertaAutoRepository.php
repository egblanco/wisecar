<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OfertaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OfertaAutoRepository extends EntityRepository
{
    public function getAllByOferta($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT oa FROM AppBundle:OfertaAuto oa ' .
            'JOIN oa.oferta o '.
            'WHERE o.id = :id '
        ) ->setParameter('id', $id);;
        $result = $query->getSingleResult();
        return $result;
    }
}