<?php

namespace FondOfSpryker\Zed\CreditMemo\Communication\Plugin\CreditMemoExtension;

use FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPreSavePluginInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Business\CreditMemoFacade getFacade()
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 */
class SalesPaymentMethodTypeCreditMemoPreSavePlugin extends AbstractPlugin implements CreditMemoPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function preSave(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFacade()->addSalesPaymentMethodTypeToCreditMemo($creditMemoTransfer);
    }
}
