<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

interface CreditMemoReaderInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $spySalesOrderItems
     *
     * @throws \Exception
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemo[]
     */
    public function getCreditMemoBySalesOrderItems(array $spySalesOrderItems): array;
}
