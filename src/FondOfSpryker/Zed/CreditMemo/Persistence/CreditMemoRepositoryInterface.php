<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use Generated\Shared\Transfer\ItemTransfer;

interface CreditMemoRepositoryInterface
{
    /**
     * @param int $idSalesOrderItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer|null
     */
    public function findCreditMemoItemByIdSalesOrderItem(int $idSalesOrderItem): ?ItemTransfer;
}
