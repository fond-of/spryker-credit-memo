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
        return $this->getFactory()->createCreditMemoWriter()->create($creditMemoTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function createCreditMemoAddress(CreditmemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFactory()->createCreditMemoAddressWriter()->create($creditMemoTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function createCreditMemoItems(CreditmemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFactory()->createCreditMemoItemsWriter()->create($creditMemoTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string
     */
    public function createCreditMemoReference(): string
    {
        return $this->getFactory()->createCreditMemoReferenceGenerator()->generate();
    }
}