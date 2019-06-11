<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Generated\Shared\Transfer\CreditmemoListTransfer;
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

}
