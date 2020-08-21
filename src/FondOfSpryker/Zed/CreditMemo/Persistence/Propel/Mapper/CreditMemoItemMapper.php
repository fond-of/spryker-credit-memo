<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem;

class CreditMemoItemMapper implements CreditMemoItemMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem $fosCreditMemoItem
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem
     */
    public function mapTransferToEntity(
        ItemTransfer $itemTransfer,
        FosCreditMemoItem $fosCreditMemoItem
    ): FosCreditMemoItem {
        $fosCreditMemoItem->fromArray(
            $itemTransfer->modifiedToArray(false)
        );

        return $fosCreditMemoItem;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem $fosCreditMemoItem
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemoItem $fosCreditMemoItem,
        ItemTransfer $itemTransfer
    ): ItemTransfer {
        return $itemTransfer->fromArray(
            $fosCreditMemoItem->toArray(),
            true
        );
    }
}
