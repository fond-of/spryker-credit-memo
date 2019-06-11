<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Generated\Shared\Transfer\CreditmemoListTransfer;

interface CreditmemoRepositoryInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(string $orderReference);

}
