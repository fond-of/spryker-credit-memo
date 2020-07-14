<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoStateTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoState;

interface CreditMemoStateMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoStateTransfer $creditMemoStateTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoState $fosCreditMemoState
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoState
     */
    public function mapTransferToEntity(
        CreditMemoStateTransfer $creditMemoStateTransfer,
        FosCreditMemoState $fosCreditMemoState
    ): FosCreditMemoState;

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoState $fosCreditMemoState
     * @param \Generated\Shared\Transfer\CreditMemoStateTransfer $creditMemoStateTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemoState $fosCreditMemoState,
        CreditMemoStateTransfer $creditMemoStateTransfer
    ): CreditMemoStateTransfer;

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function convertToStateTransfer(CreditMemoTransfer $creditMemoTransfer): CreditMemoStateTransfer;
}
