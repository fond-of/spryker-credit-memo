<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoItemStateTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemState;

class CreditMemoItemStateMapper implements CreditMemoItemStateMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoItemStateTransfer $itemTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemState $fosCreditMemoItemState
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemState
     */
    public function mapTransferToEntity(
        CreditMemoItemStateTransfer $itemTransfer,
        FosCreditMemoItemState $fosCreditMemoItemState
    ): FosCreditMemoItemState {
        $fosCreditMemoItemState->fromArray(
            $itemTransfer->modifiedToArray(false)
        );

        return $fosCreditMemoItemState;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemState $fosCreditMemoItemState
     * @param \Generated\Shared\Transfer\CreditMemoItemStateTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoItemStateTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemoItemState $fosCreditMemoItemState,
        CreditMemoItemStateTransfer $itemTransfer
    ): CreditMemoItemStateTransfer {
        return $itemTransfer->fromArray(
            $fosCreditMemoItemState->toArray(),
            true
        );
    }
}
