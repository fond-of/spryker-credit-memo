<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;

class CreditMemoItemsWriter implements CreditMemoItemsWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface
     */
    protected $entityManager;

    /**
     * CreditMemoAddressWriter constructor.
     *
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
        $creditMemoTransfer->requireIdCreditMemo();
        $creditMemoTransfer->requireItems();

        foreach ($creditMemoTransfer->getItems() as $creditMemoItemTransfer) {
            $this->entityManager->createCreditMemoItem(
                $creditMemoItemTransfer->setFkCreditMemo(
                    $creditMemoTransfer->getIdCreditMemo()
                )
            );
        }

        return $creditMemoTransfer;
    }
}
