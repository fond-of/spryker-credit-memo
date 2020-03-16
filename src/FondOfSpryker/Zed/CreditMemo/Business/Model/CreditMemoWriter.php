<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use ArrayObject;
use Exception;
use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface;
use Generated\Shared\Transfer\CreditMemoErrorTransfer;
use Generated\Shared\Transfer\CreditMemoResponseTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class CreditMemoWriter implements CreditMemoWriterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoPluginExecutorInterface
     */
    protected $creditMemoPluginExecutor;

    /**
     * CreditMemoWriter constructor.
     *
     * @param \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface $entityManager
     * @param \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoPluginExecutorInterface $creditMemoPluginExecutor
     */
    public function __construct(
        CreditMemoEntityManagerInterface $entityManager,
        CreditMemoPluginExecutorInterface $creditMemoPluginExecutor
    ) {
        $this->entityManager = $entityManager;
        $this->creditMemoPluginExecutor = $creditMemoPluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoResponseTransfer
     */
    public function create(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoResponseTransfer {
        $creditMemoResponseTransfer = (new CreditMemoResponseTransfer())
            ->setIsSuccess(false)
            ->setCreditMemoTransfer(null);

        try {
            $creditMemoTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($creditMemoTransfer) {
                    return $this->executeCreateTransaction($creditMemoTransfer);
                }
            );

            $creditMemoResponseTransfer->setIsSuccess(true)
                ->setCreditMemoTransfer($creditMemoTransfer);
        } catch (Exception $exception) {
            $errorTransferList = new ArrayObject();

            $errorTransferList->append((new CreditMemoErrorTransfer())->setMessage($exception->getMessage()));

            $creditMemoResponseTransfer->setErrors($errorTransferList);
        }

        return $creditMemoResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    protected function executeCreateTransaction(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer {
        $creditMemoTransfer = $this->creditMemoPluginExecutor
            ->executePreSavePlugins($creditMemoTransfer);

        $creditMemoTransfer = $this->entityManager->createCreditMemo($creditMemoTransfer);

        return $this->creditMemoPluginExecutor
            ->executePostSavePlugins($creditMemoTransfer);
    }
}
