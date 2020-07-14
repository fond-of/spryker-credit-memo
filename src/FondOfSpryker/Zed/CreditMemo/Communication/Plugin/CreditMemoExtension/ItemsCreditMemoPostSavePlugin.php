<?php

namespace FondOfSpryker\Zed\CreditMemo\Communication\Plugin\CreditMemoExtension;

use FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPostSavePluginInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Business\CreditMemoFacade getFacade()
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 */
class ItemsCreditMemoPostSavePlugin extends AbstractPlugin implements CreditMemoPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function postSave(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFacade()->createCreditMemoItems($creditMemoTransfer);
    }
}
