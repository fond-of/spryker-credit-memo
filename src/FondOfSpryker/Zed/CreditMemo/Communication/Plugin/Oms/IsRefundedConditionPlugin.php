<?php

namespace FondOfSpryker\Zed\CreditMemo\Communication\Plugin\Oms;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Business\CreditMemoFacade getFacade()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepository getRepository()
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 */
class IsRefundedConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        $idSalesOrderItem = $orderItem->getIdSalesOrderItem();
        $itemTransfer = $this->getRepository()->findCreditMemoItemByIdSalesOrderItem($idSalesOrderItem);

        return $itemTransfer !== null
            && $itemTransfer->getIdCreditMemoItem() !== null
            && $itemTransfer->getFkCreditMemo() !== null;
    }
}
