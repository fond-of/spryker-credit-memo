<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use Generated\Shared\Transfer\CreditMemoCollectionTransfer;
use Generated\Shared\Transfer\CreditMemoQueryFilterTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\SalesPaymentMethodTypeTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoPersistenceFactory getFactory()
 */
class CreditMemoRepository extends AbstractRepository implements CreditMemoRepositoryInterface
{
    /**
     * @param int $idSalesOrderItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer|null
     */
    public function findCreditMemoItemByIdSalesOrderItem(int $idSalesOrderItem): ?ItemTransfer
    {
        $fosCreditMemoItemQuery = $this->getFactory()->createCreditMemoItemQuery();

        $fosCreditMemoItem = $fosCreditMemoItemQuery->filterByFkSalesOrderItem($idSalesOrderItem)
            ->findOne();

        if ($fosCreditMemoItem === null) {
            return null;
        }

        return $this->getFactory()->createCreditMemoItemMapper()->mapEntityToTransfer(
            $fosCreditMemoItem,
            new ItemTransfer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return \Generated\Shared\Transfer\CreditMemoCollectionTransfer|null
     */
    public function findUnprocessedCreditMemoByStore(
        StoreTransfer $storeTransfer,
        ?int $limit = null,
        ?int $offset = null
    ): ?CreditMemoCollectionTransfer {
        $filter = new CreditMemoQueryFilterTransfer();
        $filter->setStoreName($storeTransfer->getName());

        $this->handleLimitAndOffset($limit, $offset, $filter);

        $fosCreditMemos = $this->prepareFindUnprocessedCreditMemoQuery($filter)->find();

        if ($fosCreditMemos->getData() === null) {
            return null;
        }

        return $this->prepareCreditMemoData($fosCreditMemos);
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param array $ids
     *
     * @return \Generated\Shared\Transfer\CreditMemoCollectionTransfer|null
     */
    public function findUnprocessedCreditMemoByStoreAndIds(
        StoreTransfer $storeTransfer,
        array $ids
    ): ?CreditMemoCollectionTransfer {
        $filter = new CreditMemoQueryFilterTransfer();
        $filter->setStoreName($storeTransfer->getName());
        $filter->setIds($ids);

        $fosCreditMemos = $this->prepareFindUnprocessedCreditMemoQuery($filter)->find();

        if ($fosCreditMemos->getData() === null) {
            return null;
        }

        return $this->prepareCreditMemoData($fosCreditMemos);
    }

    /**
     * @param int $idCreditMemo
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo|null
     */
    public function findCreditMemoById(int $idCreditMemo): ?FosCreditMemo
    {
        return $this->getFactory()->createCreditMemoQuery()->findOneByIdCreditMemo($idCreditMemo);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    public function findCreditMemoByFkSalesOrder(int $idSalesOrder): array
    {
        $creditMemos = $this->getFactory()->createCreditMemoQuery()->filterByFkSalesOrder($idSalesOrder)->find();

        if ($creditMemos === null) {
            return [];
        }

        return $creditMemos->getData();
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItem
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo|null
     */
    public function findCreditMemoByFkSalesOrderItem(SpySalesOrderItem $salesOrderItem): ?FosCreditMemo
    {
        $creditMemoItem = $this->getFactory()->createCreditMemoItemQuery()->filterByFkSalesOrderItem($salesOrderItem->getIdSalesOrderItem())->findOne();

        if ($creditMemoItem === null) {
            return null;
        }

        return $creditMemoItem->getFosCreditMemo();
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\SalesPaymentMethodTypeTransfer|null
     */
    public function getSalesPaymentMethodType(int $idSalesOrder): ?SalesPaymentMethodTypeTransfer
    {
        $salesPayment = $this->getFactory()->getSpySalesPaymentQuery()->filterByFkSalesOrder($idSalesOrder)->findOne();

        if ($salesPayment === null) {
            return null;
        }

        $paymentMethodType = $salesPayment->getSalesPaymentMethodType();
        if ($paymentMethodType === null) {
            return null;
        }

        return (new SalesPaymentMethodTypeTransfer())->fromArray($paymentMethodType->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Propel\Runtime\Collection\ObjectCollection|null
     */
    public function getSalesOrderItemsByCreditMemo(CreditMemoTransfer $creditMemoTransfer): ?ObjectCollection
    {
        $itemIds = [];
        foreach ($creditMemoTransfer->getItems() as $itemTransfer) {
            $itemIds[] = $itemTransfer->getFkSalesOrderItem();
        }

        $salesOrderItems = $this->getFactory()->getSpySalesOrderItemQuery()->filterByIdSalesOrderItem_In($itemIds)->find();

        if ($salesOrderItems === null) {
            return null;
        }

        return $salesOrderItems;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder|null
     */
    public function getSalesOrderByCreditMemo(CreditMemoTransfer $creditMemoTransfer): ?SpySalesOrder
    {
        $creditMemoTransfer->requireFkSalesOrder();

        return $this->getFactory()->getSpySalesOrderQuery()->filterByIdSalesOrder($creditMemoTransfer->getFkSalesOrder())->findOne();
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoQueryFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoQuery
     */
    protected function prepareFindUnprocessedCreditMemoQuery(CreditMemoQueryFilterTransfer $filterTransfer): FosCreditMemoQuery
    {
        $fosCreditMemoQuery = $this->getFactory()->createCreditMemoQuery();

        $fosCreditMemoQuery->filterByProcessed(false);
        $fosCreditMemoQuery->filterByInProgress(false);

        if ($filterTransfer->getStoreName() !== null) {
            $fosCreditMemoQuery->filterByStore($filterTransfer->getStoreName());
        }

        if ($filterTransfer->getIds() !== []) {
            $fosCreditMemoQuery->filterByIdCreditMemo_In($filterTransfer->getIds());
        }

        if ($filterTransfer->getLimit() !== null) {
            $fosCreditMemoQuery->limit($filterTransfer->getLimit());
        }

        if ($filterTransfer->getOffset() !== null) {
            $fosCreditMemoQuery->offset($filterTransfer->getOffset());
        }

        return $fosCreditMemoQuery;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $fosCreditMemoCollection
     *
     * @return \Generated\Shared\Transfer\CreditMemoCollectionTransfer
     */
    protected function prepareCreditMemoData(ObjectCollection $fosCreditMemoCollection): CreditMemoCollectionTransfer
    {
        $collection = new CreditMemoCollectionTransfer();

        /** @var \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemo */
        foreach ($fosCreditMemoCollection->getData() as $creditMemo) {
            $collection->addCreditMemo($this->prepareCreditMemo($creditMemo));
        }

        return $collection;
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return void
     */
    protected function prepareCreditMemoItems(
        FosCreditMemo $creditMemo,
        CreditMemoTransfer $creditMemoTransfer
    ): void {
        foreach ($creditMemo->getFosCreditMemoItems() as $creditMemoItem) {
            $creditMemoTransfer->addItem(
                $this->getFactory()->createCreditMemoItemMapper()->mapEntityToTransfer(
                    $creditMemoItem,
                    new ItemTransfer()
                )
            );
        }
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemo
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return void
     */
    protected function prepareSalesPaymentMethodType(
        FosCreditMemo $creditMemo,
        CreditMemoTransfer $creditMemoTransfer
    ): void {
        $spySalesPaymentMethodType = $creditMemo->getSpySalesPaymentMethodType();

        if ($spySalesPaymentMethodType !== null) {
            $salesPaymentMethodTypeTransfer = (new SalesPaymentMethodTypeTransfer())->fromArray(
                $spySalesPaymentMethodType->toArray(),
                true
            );
            $creditMemoTransfer->setSalesPaymentMethodType($salesPaymentMethodTypeTransfer);
        }
    }

    /**
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemo $creditMemo
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    protected function prepareCreditMemo(FosCreditMemo $creditMemo): CreditMemoTransfer
    {
        $creditMemoTransfer = new CreditMemoTransfer();
        $creditMemoTransfer->fromArray($creditMemo->toArray(), true);

        $this->prepareCreditMemoItems($creditMemo, $creditMemoTransfer);
        $this->prepareSalesPaymentMethodType($creditMemo, $creditMemoTransfer);

        return $creditMemoTransfer;
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param \Generated\Shared\Transfer\CreditMemoQueryFilterTransfer $filter
     *
     * @return void
     */
    protected function handleLimitAndOffset(?int $limit, ?int $offset, CreditMemoQueryFilterTransfer $filter): void
    {
        if ($offset !== null) {
            $filter->setOffset($offset);
        }
        if ($limit !== null) {
            $filter->setLimit($limit);
        }

        if ($limit === null && $offset !== null) {
            $filter->setOffset(null);
        }
    }
}
