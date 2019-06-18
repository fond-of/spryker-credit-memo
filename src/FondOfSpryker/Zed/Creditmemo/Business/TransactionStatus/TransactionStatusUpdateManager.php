<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\TransactionStatus;

use FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface;
use Generated\Shared\Transfer\CreditmemoTransfer;

class TransactionStatusUpdateManager implements TransactionStatusUpdateManagerInterface
{
    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface
     */
    protected $creditmemoHydrator;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;

    /**
     * TransactionStatusUpdateManager constructor.
     *
     * @param \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface $queryContainer
     * @param \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface $creditmemoRepository
     * @param \FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface $creditmemoHydrator
     */
    public function __construct(
        CreditmemoQueryContainerInterface $queryContainer,
        CreditmemoRepositoryInterface $creditmemoRepository,
        CreditmemoHydratorInterface $creditmemoHydrator
    ) {

        $this->queryContainer = $queryContainer;
        $this->creditmemoRepository = $creditmemoRepository;
        $this->creditmemoHydrator = $creditmemoHydrator;
    }

    /**
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    public function isCreditmemoAppointed(int $idSalesOrder, int $idSalesOrderItem): bool
    {
        return $this->IsCreditmemoCreated($idSalesOrder, $idSalesOrderItem);
    }

    /**
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    protected function IsCreditmemoCreated(int $idSalesOrder, int $idSalesOrderItem): bool
    {
        $creditmemoTransfer = $this->findCreditmemoByIdSalesOrder($idSalesOrder);

        if ($creditmemoTransfer == null) {
            return false;
        }

        return true;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer|null
     */
    protected function findCreditmemoByIdSalesOrder(int $idSalesOrder): ?CreditmemoTransfer
    {
        $creditmemoEntity = $this->creditmemoRepository->findCreditmemosByIdSalesOrder($idSalesOrder);

        if ($creditmemoEntity == null)
        {
            return null;
        }

        return $this->creditmemoHydrator->hydrateCreditmemoTransferFromPersistenceByCreditmemo($creditmemoEntity);
    }

}