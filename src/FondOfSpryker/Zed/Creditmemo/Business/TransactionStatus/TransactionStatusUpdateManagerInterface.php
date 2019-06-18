<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\TransactionStatus;

interface TransactionStatusUpdateManagerInterface
{
    /**
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    public function isCreditmemoAppointed(int $idSalesOrder, int $idSalesOrderItem): bool;

}