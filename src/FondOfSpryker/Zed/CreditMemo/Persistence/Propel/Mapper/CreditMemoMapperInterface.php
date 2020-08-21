<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;

interface CreditMemoMapperInterface
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
    ): FosCreditMemo;

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $fosCreditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function mapEntityToTransfer(
        FosCreditMemo $fosCreditMemo,
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer;
}
