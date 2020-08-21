<?php

namespace FondOfSpryker\Shared\CreditMemo;

use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;

trait CreditMemoRefundHelperTrait
{
    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[] $creditMemoEntities
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    protected function resolveAndPrepareCreditMemos(array $creditMemoEntities): array
    {
        $creditMemos = [];
        foreach ($creditMemoEntities as $creditMemoEntity) {
            if ($creditMemoEntity->getInProgress() === true || $creditMemoEntity->getProcessed() === true) {
                continue;
            }

            $this->lockCreditMemo($creditMemoEntity);

            $creditMemos[$creditMemoEntity->getCreditMemoReference()] = $creditMemoEntity;
        }

        return $creditMemos;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemoEntity
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $salesOrderItems
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItem[]
     */
    protected function getRefundableItemsByCreditMemo(FosCreditMemo $creditMemoEntity, array $salesOrderItems): array
    {
        $refundItems = [];
        foreach ($creditMemoEntity->getFosCreditMemoItems() as $creditMemoItem) {
            foreach ($salesOrderItems as $salesOrderItem) {
                if ($salesOrderItem->getIdSalesOrderItem() === $creditMemoItem->getFkSalesOrderItem()) {
                    $refundItems[$creditMemoEntity->getCreditMemoReference()][$salesOrderItem->getIdSalesOrderItem()] = $salesOrderItem;

                    break;
                }
            }
        }

        return $refundItems;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemoEntity
     *
     * @return void
     */
    protected function lockCreditMemo(FosCreditMemo $creditMemoEntity): void
    {
        $creditMemoTransfer = new CreditMemoTransfer();
        $creditMemoTransfer->setInProgress(true);
        $creditMemoTransfer->setState(CreditMemoConstants::STATE_IN_PROGRESS);
        $this->updateCreditMemo($creditMemoEntity, $creditMemoTransfer);
    }

    /**
     * This is just a fake method, in a normal environment you would call your facade and trigger the refund process.
     *
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return bool
     */
    protected function isRefundableAmount(RefundTransfer $refundTransfer)
    {
        return ($refundTransfer->getAmount() > 0);
    }

    /**
     * @param array $results
     *
     * @return bool
     */
    protected function validateRefundResult(array $results): bool
    {
        $return = true;
        foreach ($results as $ref => $state) {
            if ($state === false) {
                $return = false;
                $this->getLogger()->error(sprintf('Could not refund %s', $ref));
            }
        }

        return $return;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return void
     */
    protected function updateCreditMemo(FosCreditMemo $fosCreditMemo, CreditMemoTransfer $creditMemoTransfer): void
    {
        $fosCreditMemo->fromArray($creditMemoTransfer->modifiedToArray());
        $fosCreditMemo->save();
    }

    /**
     * @param array $refundItems
     *
     * @return array
     */
    protected function resolveAndCheckItemsForRefund(array $refundItems): array
    {
        $itemsToRefund = [];
        foreach ($refundItems as $idSalesOrderItem => $salesOrderItem) {
            if (!array_key_exists($idSalesOrderItem, $itemsToRefund)) {
                $itemsToRefund[$idSalesOrderItem] = $salesOrderItem;
            }
        }

        return $itemsToRefund;
    }
}
