<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemo;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoPersistenceFactory getFactory()
 */
class CreditmemoRepository extends AbstractRepository implements CreditmemoRepositoryInterface
{

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(string $orderReference)
    {
        return $this->getFactory()
            ->createCreditmemoQuery()
            ->findByOrderReference($orderReference);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemo|null
     */
    public function findCreditmemosByIdSalesOrder(int $idSalesOrder): ?FosCreditmemo
    {
        return $this->getFactory()
            ->createCreditmemoQuery()
            ->findOneByFkSalesOrder($idSalesOrder);
    }

}
