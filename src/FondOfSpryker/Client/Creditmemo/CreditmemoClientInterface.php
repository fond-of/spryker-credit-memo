<?php

namespace FondOfSpryker\Client\Creditmemo;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;

interface CreditmemoClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer): CreditmemoListTransfer;

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function createCreditmemo(CreditmemoTransfer $creditmemoTransfer): CreditmemoResponseTransfer;

}
