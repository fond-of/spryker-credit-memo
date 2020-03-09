<?php

namespace FondOfSpryker\Zed\CreditMemo\Business;

use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Business\CreditMemoBusinessFactory getFactory()
 */
class CreditMemoFacade extends AbstractFacade implements CreditMemoFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditMemoTransfer
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function createCreditMemo(CreditmemoTransfer $creditMemoTransfer): CreditMemoResponseTransfer
    {
        // TODO: Implement createCreditMemo() method.
    }
}
