<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Resolver;

use Generated\Shared\Transfer\CreditMemoTransfer;

interface PaymentMethodResolverInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function resolveAndAdd(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer;
}
