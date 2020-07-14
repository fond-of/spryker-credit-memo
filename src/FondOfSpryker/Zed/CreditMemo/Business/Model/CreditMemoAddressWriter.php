<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;

class CreditMemoAddressWriter implements CreditMemoAddressWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface $entityManager
     */
    public function __construct(CreditMemoEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function create(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer {
        $creditMemoTransfer->requireAddress();

        $creditMemoAddressTransfer = $this->entityManager->createCreditMemoAddress(
            $creditMemoTransfer->getAddress()
        );

        return $creditMemoTransfer->setAddress($creditMemoAddressTransfer);
    }
}
