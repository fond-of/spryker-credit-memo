<?php

namespace FondOfSpryker\Zed\CreditMemo\Business;

use Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer;
use Generated\Shared\Transfer\CreditMemoResponseTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Business\CreditMemoBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface getRepository()
 */
class CreditMemoFacade extends AbstractFacade implements CreditMemoFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoResponseTransfer
     */
    public function createCreditMemo(CreditMemoTransfer $creditMemoTransfer): CreditMemoResponseTransfer
    {
        return $this->getFactory()->createCreditMemoWriter()->create($creditMemoTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoResponseTransfer
     */
    public function updateCreditMemo(CreditMemoTransfer $creditMemoTransfer): CreditMemoResponseTransfer
    {
        return $this->getFactory()->createCreditMemoWriter()->update($creditMemoTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function addSalesPaymentMethodTypeToCreditMemo(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFactory()->createCreditMemoPaymentResolver()->resolveAndAdd($creditMemoTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function createCreditMemoItems(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        return $this->getFactory()->createCreditMemoItemsWriter()->create($creditMemoTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function createCreditMemoReference(): string
    {
        return $this->getFactory()->createCreditMemoReferenceGenerator()->generate();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[]
     */
    public function getRegisteredProcessor(): array
    {
        return $this->getFactory()->createCreditMemoProcessor()->getProcessor();
    }

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processorPlugins
     * @param array $ids
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer
     */
    public function processCreditMemos(
        array $processorPlugins,
        array $ids
    ): CreditMemoProcessorResponseCollectionTransfer {
        return $this->getFactory()->createCreditMemoProcessor()->process($processorPlugins, $ids);
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    public function getSalesOrderByCreditMemo(CreditMemoTransfer $creditMemoTransfer): SpySalesOrder
    {
        return $this->getRepository()->getSalesOrderByCreditMemo($creditMemoTransfer);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    public function getCreditMemoBySalesOrderId(int $idSalesOrder): array
    {
        return $this->getRepository()->findCreditMemoByFkSalesOrder($idSalesOrder);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItem
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo|null
     */
    public function getCreditMemoBySalesOrderItem(SpySalesOrderItem $salesOrderItem): ?FosCreditMemo
    {
        return $this->getRepository()->findCreditMemoByFkSalesOrderItem($salesOrderItem);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $spySalesOrderItems
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    public function getCreditMemosBySalesOrderItems(array $spySalesOrderItems): array
    {
        return $this->getFactory()->createCreditMemoReader()->getCreditMemoBySalesOrderItems($spySalesOrderItems);
    }
}
