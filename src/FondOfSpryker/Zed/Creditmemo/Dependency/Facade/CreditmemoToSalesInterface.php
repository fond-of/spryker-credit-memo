<?php

namespace FondOfSpryker\Zed\Creditmemo\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface CreditmemoToSalesInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function findSalesOrderByOrderReference(string $orderReference): OrderTransfer;
}
