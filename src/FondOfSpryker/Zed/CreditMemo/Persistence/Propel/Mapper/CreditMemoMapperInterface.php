<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;

interface CreditMemoMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $shipmentDeliveryNoteTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo
     */
    public function mapTransferToEntity(
        CreditMemoTransfer $shipmentDeliveryNoteTransfer,
        FosCreditMemo $fosCreditMemo
    ): FosCreditMemo;

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $shipmentDeliveryNoteTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemo $fosCreditMemo,
        CreditMemoTransfer $shipmentDeliveryNoteTransfer
    ): CreditMemoTransfer;
}
