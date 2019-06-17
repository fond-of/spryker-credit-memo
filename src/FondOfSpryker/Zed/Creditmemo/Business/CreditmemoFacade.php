<?php

namespace FondOfSpryker\Zed\Creditmemo\Business;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Creditmemo\Business\CreditmemoBusinessFactory getFactory()
 */
class CreditmemoFacade extends AbstractFacade implements CreditmemoFacadeInterface
{

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     * @param array $creditmemoItemCollection
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function addCreditmemo(CreditmemoTransfer $creditmemoTransfer, array $creditmemoItemCollection): CreditmemoResponseTransfer
    {
        return $this->getFactory()
            ->createCreditmemo()
            ->add($creditmemoTransfer, $creditmemoItemCollection);
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer, string $orderReference)
    {
        return $this->getFactory()->createCreditmemoReader()->findCreditmemosByOrderReference($creditmemoListTransfer, $orderReference);
    }

    public function findCreditmemoById(CreditmemoTransfer $creditmemoTransfer): CreditmemoTransfer
    {
        return $this->getFactory()
            ->createCreditmemo()
            ->findById($creditmemoTransfer);
    }
}
