<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoStateTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoState;

class CreditMemoStateMapper implements CreditMemoStateMapperInterface
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
    ): FosCreditMemoState {
        $fosCreditMemoState->fromArray(
            $creditMemoStateTransfer->modifiedToArray(false)
        );

        return $fosCreditMemoState;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoState $fosCreditMemoState
     * @param \Generated\Shared\Transfer\CreditMemoStateTransfer $creditMemoStateTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemoState $fosCreditMemoState,
        CreditMemoStateTransfer $creditMemoStateTransfer
    ): CreditMemoStateTransfer {
        return $creditMemoStateTransfer->fromArray($fosCreditMemoState->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function convertToStateTransfer(CreditMemoTransfer $creditMemoTransfer): CreditMemoStateTransfer
    {
        $stateTransfer = new CreditMemoStateTransfer();
        $stateTransfer->fromArray($creditMemoTransfer->toArray(), true);

        return $stateTransfer;
    }
}
