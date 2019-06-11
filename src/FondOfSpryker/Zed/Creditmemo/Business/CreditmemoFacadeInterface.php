<?php

namespace FondOfSpryker\Zed\Creditmemo\Business;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;

interface CreditmemoFacadeInterface
{

    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer, string $orderReference);

}
