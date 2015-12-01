<?php

namespace PassVault\PassBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PasswordRepository extends EntityRepository
{

    public function search($params)
    {
        $params = explode(' ', $params);

        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();

        $qb->select('p')
            ->from('PassVaultPassBundle:Password', 'p');

        for ($i = 0; $i < count($params); $i++) {
            $qb->andWhere('p.account like :param' . $i.
                ' OR p.name like :param' . $i.
                ' OR p.link like :param' . $i.
                ' OR p.password like :param' . $i)
                ->setParameter('param'.$i, '%'.$params[$i].'%');
        }

        $query = $qb->getQuery();
        return $query->getResult();
    }

}

?>