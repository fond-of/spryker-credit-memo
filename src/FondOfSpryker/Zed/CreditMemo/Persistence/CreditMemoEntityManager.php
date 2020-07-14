<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use Exception;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CreditMemoItemStateTransfer;
use Generated\Shared\Transfer\CreditMemoStateTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemo;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoAddress;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItem;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemState;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoState;
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
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function updateCreditMemo(
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoTransfer {
        $creditMemoTransfer->requireIdCreditMemo();

        $fosCreditMemo = $this->getFactory()->createCreditMemoQuery()->findOneByIdCreditMemo($creditMemoTransfer->getIdCreditMemo());

        if ($fosCreditMemo === null) {
            throw new Exception(sprintf('Could not update credit memo with id %s because no credit memo with given id was found', $creditMemoTransfer->getIdCreditMemo()));
        }

        $fosCreditMemo->fromArray($creditMemoTransfer->modifiedToArray());
        $fosCreditMemo->save();
        $creditMemoTransfer->fromArray($fosCreditMemo->getModifiedColumns(), true);

        return $creditMemoTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoStateTransfer $creditMemoStateTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function updateCreditMemoState(
        CreditMemoStateTransfer $creditMemoStateTransfer
    ): CreditMemoTransfer {
        $creditMemoStateTransfer->requireIdCreditMemoState();

        $fosCreditMemoState = $this->getFactory()->createCreditMemoStateQuery()->findOneByIdCreditMemoState($creditMemoStateTransfer->getIdCreditMemoState());

        if ($fosCreditMemoState === null) {
            throw new Exception(sprintf('Could not update credit memo state with id %s because no credit memo state with given id was found', $creditMemoStateTransfer->getIdCreditMemoState()));
        }

        foreach ($creditMemoStateTransfer->getCreditMemoItemStates() as $creditMemoItemStateTransfer) {
            if ($creditMemoItemStateTransfer->getIdCreditMemoItemState() !== null) {
                $this->createCreditMemoItemState($creditMemoItemStateTransfer);

                continue;
            }
            $this->updateCreditMemoStateItem($creditMemoItemStateTransfer);
        }

        $fosCreditMemoState->fromArray($creditMemoStateTransfer->modifiedToArray());
        $fosCreditMemoState->save();
        $creditMemoStateTransfer->fromArray($fosCreditMemoState->getModifiedColumns(), true);

        return $creditMemoStateTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoItemStateTransfer $creditMemoItemStateTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CreditMemoItemStateTransfer
     */
    public function updateCreditMemoStateItem(
        CreditMemoItemStateTransfer $creditMemoItemStateTransfer
    ): CreditMemoTransfer {
        $creditMemoItemStateTransfer->requireIdCreditMemoItemState();

        $fosCreditMemoItemState = $this->getFactory()->createCreditMemoItemStateQuery()->findOneByIdCreditMemoItemState($creditMemoItemStateTransfer->getIdCreditMemoItemState());

        if ($fosCreditMemoItemState === null) {
            throw new Exception(sprintf('Could not update credit memo item state with id %s because no credit memo item state with given id was found', $creditMemoItemStateTransfer->getIdCreditMemoItemState()));
        }

        $fosCreditMemoItemState->fromArray($creditMemoItemStateTransfer->modifiedToArray());
        $fosCreditMemoItemState->save();
        $creditMemoItemStateTransfer->fromArray($fosCreditMemoItemState->getModifiedColumns(), true);

        return $creditMemoItemStateTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoStateTransfer $creditMemoSateTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoStateTransfer
     */
    public function createCreditMemoState(
        CreditMemoStateTransfer $creditMemoSateTransfer
    ): CreditMemoStateTransfer {
        $fosCreditMemoState = $this->getFactory()
            ->createCreditMemoStateMapper()
            ->mapTransferToEntity($creditMemoSateTransfer, new FosCreditMemoState());

        $fosCreditMemoState->save();

        return $creditMemoSateTransfer->setIdCreditMemoState(
            $fosCreditMemoState->getIdCreditMemoState()
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

    /**
     * @param \Generated\Shared\Transfer\CreditMemoItemStateTransfer $itemStateTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function createCreditMemoItemState(
        CreditMemoItemStateTransfer $itemStateTransfer
    ): CreditMemoItemStateTransfer {
        $fosCreditMemoItemState = $this->getFactory()
            ->createCreditMemoItemStateMapper()
            ->mapTransferToEntity($itemStateTransfer, new FosCreditMemoItemState());

        $fosCreditMemoItemState->save();

        return $itemStateTransfer->setIdCreditMemoItemState(
            $fosCreditMemoItemState->getIdCreditMemoItemState()
        );
    }
}
