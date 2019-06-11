<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use Generated\Shared\Transfer\CreditmemoListTransfer;

interface CreditmemoReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer, string $orderReference): CreditmemoListTransfer;
}
