<?php

namespace FondOfSpryker\Zed\Creditmemo\Communication\Controller;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpyker\Zed\Creditmemo\Business\CreditmemoFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\Creditmemo\Communication\CreditmemoCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function findCreditmemosByOrderReferenceAction(CreditmemoListTransfer $creditmemoListTransfer)
    {
        return $this->getFacade()->findCreditmemosByOrderReference($creditmemoListTransfer, $creditmemoListTransfer->getOrderReference());
    }
}
