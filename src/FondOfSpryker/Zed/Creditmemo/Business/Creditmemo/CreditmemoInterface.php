<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;

interface CreditmemoInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function create(CreditmemoTransfer $creditmemoTransfer): CreditmemoResponseTransfer;
}
