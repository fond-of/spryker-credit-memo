<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemo;

interface CreditmemoRepositoryInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(string $orderReference);

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemo|null
     */
    public function findCreditmemosByIdSalesOrder(int $idSalesOrder): ?FosCreditmemo;

}
