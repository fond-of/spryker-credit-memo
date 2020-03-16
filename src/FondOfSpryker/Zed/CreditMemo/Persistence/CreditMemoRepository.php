<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use Generated\Shared\Transfer\ItemTransfer;
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
}
