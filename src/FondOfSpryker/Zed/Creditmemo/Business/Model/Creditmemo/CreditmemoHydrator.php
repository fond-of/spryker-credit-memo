<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo;

use FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\CreditmemoItemTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Orm\Zed\Country\Persistence\SpyCountry;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemo;
use Propel\Runtime\ActiveQuery\Criteria;

class CreditmemoHydrator implements CreditmemoHydratorInterface
{
    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * CreditmemoHydrator constructor.
     *
     * @param \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface $queryContainer
     */
    public function __construct(
        CreditmemoQueryContainerInterface $queryContainer
    ) {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     * 
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function hydrateCreditmemoTransferFromPersistenceByCreditmemo(FosCreditmemo $creditmemoEntity): CreditmemoTransfer
    {
        return $this->applyCreditmemoTransferHydrators($creditmemoEntity);
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    protected function applyCreditmemoTransferHydrators(FosCreditmemo $creditmemoEntity): CreditmemoTransfer
    {
        $creditmemoTransfer = $this->hydrateBaseCreditmemoTransfer($creditmemoEntity);
        $this->hydrateCreditmemoItemsToCreditmemoTransfer($creditmemoEntity, $creditmemoTransfer);

        return $creditmemoTransfer;
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function hydrateBaseCreditmemoTransfer(FosCreditmemo $creditmemoEntity): CreditmemoTransfer
    {
        $creditmemoTransfer = new CreditmemoTransfer();
        $creditmemoTransfer->fromArray($creditmemoEntity->toArray(), true);

        return $creditmemoTransfer;
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function hydrateCreditmemoItemsToCreditmemoTransfer(FosCreditmemo $creditmemoEntity, CreditmemoTransfer $creditmemoTransfer): void
    {
        foreach ($creditmemoEntity->getItems() as $creditmemoItemEntity) {
            $itemTransfer = $this->hydrateCreditmemoItemTransfer($creditmemoItemEntity);
            $creditmemoTransfer->addCreditmemoItem($itemTransfer);
        }

    }

    /**
     * @param \FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\FosCreditmemoItem $creditmemoItemEntity
     *
     * @return \Generated\Shared\Transfer\CreditmemoItemTransfer
     */
    protected function hydrateCreditmemoItemTransfer(FosCreditmemoItem $creditmemoItemEntity): CreditmemoItemTransfer
    {
        $itemTransfer = new CreditmemoItemTransfer();
        $itemTransfer->fromArray($creditmemoItemEntity->toArray(), true);

        return $itemTransfer;
    }

}

