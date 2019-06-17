<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CreditmemoInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     * @param array $creditmemoItemCollection
     * 
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function add(CreditmemoTransfer $creditmemoTransfer, array $creditmemoItemCollection): CreditmemoResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     * 
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function findById(CreditmemoTransfer $creditmemoTransfer): CreditmemoTransfer;
}
