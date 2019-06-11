<?php

namespace FondOfSpryker\Client\Creditmemo;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\Creditmemo\CreditmemoFactory getFactory()
 */
class CreditmemoClient extends AbstractClient implements CreditmemoClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer): CreditmemoListTransfer
    {
        return $this->getFactory()
            ->createZedCreditmemoStub()
            ->findCreditmemosByOrderReference($creditmemoListTransfer);
    }


    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     */
    public function createCreditmemo(CreditmemoTransfer $creditmemoTransfer): CreditmemoResponseTransfer
    {
        return $this->getFactory()
            ->createZedCreditmemoStub()
            ->create($creditmemoTransfer);
    }
}
