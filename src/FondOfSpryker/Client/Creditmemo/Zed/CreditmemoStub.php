<?php

namespace FondOfSpryker\Client\Creditmemo\Zed;

use Generated\Shared\Transfer\CreditmemoListTransfer;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Spryker\Client\ZedRequest\ZedRequestClient;

class CreditmemoStub implements CreditmemoStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected $zedStub;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClient $zedStub
     */
    public function __construct(ZedRequestClient $zedStub)
    {
        $this->zedStub = $zedStub;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer): CreditmemoListTransfer
    {
        /** @var \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer */
        $creditmemoListTransfer = $this->zedStub->call('/creditmemo/gateway/find-creditmemos-by-order-reference', $creditmemoListTransfer);

        return $creditmemoListTransfer;
    }

}
