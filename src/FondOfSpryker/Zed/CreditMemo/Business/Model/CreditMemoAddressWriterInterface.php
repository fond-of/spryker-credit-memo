<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use Generated\Shared\Transfer\CreditMemoTransfer;

interface CreditMemoAddressWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function create(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer;
}
