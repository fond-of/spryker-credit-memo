<?php

namespace FondOfSpryker\Zed\Creditmemo\Dependency\Facade;

use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface CreditmemoToSalesInterface
{
    /**
     * @param string $orderReference
     *
     * @return int
     */
    public function findSalesOrderByOrderReference(string $orderReference);
}
