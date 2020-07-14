<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;

class CreditMemoMapper implements CreditMemoMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo
     */
    public function mapTransferToEntity(
        CreditMemoTransfer $creditMemoTransfer,
        FosCreditMemo $fosCreditMemo
    ): FosCreditMemo {
        $fosCreditMemo->fromArray(
            $creditMemoTransfer->modifiedToArray(false)
        );

        if ($creditMemoTransfer->getLocale() !== null) {
            $fosCreditMemo->setFkLocale($creditMemoTransfer->getLocale()->getIdLocale());
        }

        $addressTransfer = $creditMemoTransfer->getAddress();

        if ($addressTransfer !== null && $addressTransfer->getIdCreditMemoAddress() !== null) {
            $fosCreditMemo->setFkCreditMemoAddress(
                $addressTransfer->getIdCreditMemoAddress()
            );
        }

        return $fosCreditMemo;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemo $fosCreditMemo,
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer {
        return $creditMemoTransfer->fromArray($fosCreditMemo->toArray(), true);
    }
}
