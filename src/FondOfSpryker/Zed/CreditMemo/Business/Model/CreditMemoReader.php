<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface;

class CreditMemoReader implements CreditMemoReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface
     */
    protected $creditMemoRepository;

    /**
     * @param \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface $creditMemoRepository
     */
    public function __construct(CreditMemoRepositoryInterface $creditMemoRepository)
    {
        $this->creditMemoRepository = $creditMemoRepository;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $spySalesOrderItems
     *
     * @throws \Exception
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    public function getCreditMemoBySalesOrderItems(array $spySalesOrderItems): array
    {
        $ids = [];
        $creditMemos = [];
        foreach ($spySalesOrderItems as $salesOrderItem) {
            $creditMemo = $this->creditMemoRepository->findCreditMemoByFkSalesOrderItem($salesOrderItem);

            if ($creditMemo === null) {
                $ids[] = $salesOrderItem->getIdSalesOrderItem();
            }

            if ($creditMemo !== null) {
                $creditMemos[$creditMemo->getCreditMemoReference()] = $creditMemo;
            }
        }

        if ($creditMemos === []) {
            throw new Exception(sprintf('No CreditMemo found for ids %s', implode(', ', $ids)));
        }

        return $creditMemos;
    }
}
