<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use ArrayObject;

use FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToLocaleInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManagerInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface;
use Generated\Shared\Transfer\CreditmemoListTransfer;
use Orm\Zed\Locale\Persistence\SpyLocale;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Propel\Runtime\Collection\ObjectCollection;

class CreditmemoReader implements CreditmemoReaderInterface
{

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManagerInterface
     */
    protected $creditmemoEntityManager;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface
     */
    protected $creditmemoHydrator;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;


    public function __construct(
        CreditmemoToLocaleInterface $localeFacade,
        CreditmemoEntityManagerInterface $creditmemoEntityManager,
        CreditmemoHydratorInterface $creditmemoHydrator,
        CreditmemoRepositoryInterface $creditmemoRepository
    ) {
        $this->creditmemoEntityManager = $creditmemoEntityManager;
        $this->creditmemoHydrator = $creditmemoHydrator;
        $this->creditmemoRepository = $creditmemoRepository;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoListTransfer $creditmemoListTransfer
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\CreditmemoListTransfer
     */
    public function findCreditmemosByOrderReference(CreditmemoListTransfer $creditmemoListTransfer, string $orderReference): CreditmemoListTransfer
    {
        $creditmemoCollection = $this->creditmemoRepository->findCreditmemosByOrderReference($orderReference);
        $creditmemoListCollection = $this->hydrateCreditmemoListCollectionTransferFromEntityCollection($creditmemoCollection);

        $creditmemoListTransfer->setItems($creditmemoListCollection);

        return $creditmemoListTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $orderCollection
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\OrderTransfer[]
     *
     * @throws 
     */
    protected function hydrateCreditmemoListCollectionTransferFromEntityCollection(ObjectCollection $creditmemoCollection): ArrayObject
    {
        $creditmemos = new ArrayObject();

        /** @var \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity */
        foreach ($creditmemoCollection as $creditmemoEntity) {
            if ($creditmemoEntity->countItems() === 0) {
                continue;
            }

            $creditmemoTransfer = $this->creditmemoHydrator->hydrateCreditmemoTransferFromPersistenceByCreditmemo($creditmemoEntity);
            $creditmemoTransfer->setCurrency($creditmemoEntity->getCurrencyIsoCode());
            $creditmemoTransfer->setLocale(
                $this->localeFacade->getLocaleByIdLocale($creditmemoEntity->getFkLocale())->getLocaleName()
            );

            $creditmemos->append($creditmemoTransfer);
        }

        return $creditmemos;
    }
    
}
