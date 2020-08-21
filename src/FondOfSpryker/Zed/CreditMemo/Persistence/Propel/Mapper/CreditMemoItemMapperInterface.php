<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem;

interface CreditMemoItemMapperInterface
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
    ): FosCreditMemoItem;

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem $fosCreditMemoItem
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemoItem $fosCreditMemoItem,
        ItemTransfer $itemTransfer
    ): ItemTransfer;
}
