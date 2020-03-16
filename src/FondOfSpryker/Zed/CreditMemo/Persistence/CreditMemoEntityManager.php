<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoAddress;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoPersistenceFactory getFactory()
 */
class CreditMemoEntityManager extends AbstractEntityManager implements CreditMemoEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function createCreditMemo(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer {
        $fosCreditMemo = $this->getFactory()
            ->createCreditMemoMapper()
            ->mapTransferToEntity($creditMemoTransfer, new FosCreditMemo());

        $fosCreditMemo->save();

        return $creditMemoTransfer->setIdCreditMemo(
            $fosCreditMemo->getIdCreditMemo()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function createCreditMemoAddress(
        AddressTransfer $addressTransfer
    ): AddressTransfer {
        $fosCreditMemoAddress = $this->getFactory()
            ->createCreditMemoAddressMapper()
            ->mapTransferToEntity($addressTransfer, new FosCreditMemoAddress());

        $fosCreditMemoAddress->save();

        return $addressTransfer->setIdCreditMemoAddress(
            $fosCreditMemoAddress->getIdCreditMemoAddress()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function createCreditMemoItem(
        ItemTransfer $itemTransfer
    ): ItemTransfer {
        $fosCreditMemoItem = $this->getFactory()
            ->createCreditMemoItemMapper()
            ->mapTransferToEntity($itemTransfer, new FosCreditMemoItem());

        $fosCreditMemoItem->save();

        return $itemTransfer->setIdCreditMemoItem(
            $fosCreditMemoItem->getIdCreditMemoItem()
        );
    }
}
