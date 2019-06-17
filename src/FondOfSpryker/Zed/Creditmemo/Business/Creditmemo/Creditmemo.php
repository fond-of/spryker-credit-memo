<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use FondOfSpryker\Zed\Creditmemo\CreditmemoConfig;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToCountryInterface;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToProductInterface;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToSalesInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
use Generated\Shared\Transfer\CreditmemoResponseTransfer;
use Generated\Shared\Transfer\CreditmemoTransfer;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemo;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemoItem;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemoItemQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;


class Creditmemo implements CreditmemoInterface
{
    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToProductInterface
     */
    protected $productFacade;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToSalesInterface
     */
    protected $salesFacade;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToCountryInterface
     */
    protected $countryFacade;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\CreditmemoConfig
     */
    protected $creditmemoConfig;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoValidatorInterface
     */
    protected $creditmemoValidator;

    /**
     * @var \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected $localeQueryContainer;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * Creditmemo constructor.
     *
     * @param \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToProductInterface $productFacade
     * @param \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToSalesInterface $salesFacade
     * @param \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToCountryInterface $countryFacade
     * @param \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface $queryContainer
     * @param \FondOfSpryker\Zed\Creditmemo\CreditmemoConfig $creditmemoConfig
     * @param \FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoValidatorInterface $creditmemoValidator
     * @param \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface $localeQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(
        CreditmemoToProductInterface $productFacade,
        CreditmemoToSalesInterface $salesFacade,
        CreditmemoToCountryInterface $countryFacade,
        CreditmemoQueryContainerInterface $queryContainer,
        CreditmemoConfig $creditmemoConfig,
        CreditmemoValidatorInterface $creditmemoValidator,
        LocaleQueryContainerInterface $localeQueryContainer,
        Store $store
    ) {
        $this->countryFacade = $countryFacade;
        $this->productFacade = $productFacade;
        $this->salesFacade = $salesFacade;
        $this->queryContainer = $queryContainer;
        $this->creditmemoConfig = $creditmemoConfig;
        $this->creditmemoValidator = $creditmemoValidator;
        $this->localeQueryContainer = $localeQueryContainer;
        $this->store = $store;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     * @param \Generated\Shared\Transfer\CreditmemoItemTransfer[] $creditmemoItemCollection
     *
     * @return \Generated\Shared\Transfer\CreditmemoResponseTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function add(
        CreditmemoTransfer $creditmemoTransfer,
        array $creditmemoItemCollection
    ): CreditmemoResponseTransfer {
        $creditmemoEntity = new FosCreditmemo();
        $creditmemoEntity->fromArray($creditmemoTransfer->toArray());

        if ($creditmemoTransfer->getLocale() !== null) {
            $this->addLocaleByLocaleName($creditmemoEntity, $creditmemoTransfer->getLocale());
        }

        if ($creditmemoTransfer->getCurrency() !== null) {
            $creditmemoEntity->setCurrencyIsoCode($creditmemoTransfer->getCurrency());
        }

        $this->addIdSalesOrderAddressesToCreditmemoEntity($creditmemoEntity);
        $creditmemoEntity->save();
        $this->saveCreditmemoItems($creditmemoEntity, $creditmemoItemCollection);

        $creditmemoTransfer->setIdCreditmemo($creditmemoEntity->getPrimaryKey());
        $creditmemoTransfer->setCreatedAt($creditmemoEntity->getCreatedAt()->format("Y-m-d H:i:s.u"));
        $creditmemoTransfer->setUpdatedAt($creditmemoEntity->getUpdatedAt()->format("Y-m-d H:i:s.u"));

        $creditmemoResponseTransfer = new CreditmemoResponseTransfer();
        $creditmemoResponseTransfer
            ->setIsSuccess(true)
            ->setCreditmemoTransfer($creditmemoTransfer);

        return $creditmemoResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function findById(CreditmemoTransfer $creditmemoTransfer): CreditmemoTransfer
    {
        $creditmemoEntity = $this->queryContainer
            ->queryCreditmemoById($creditmemoTransfer->getIdCreditmemo())
            ->findOne();
        if ($creditmemoEntity === null) {
            return null;
        }

        $creditmemoTransfer = $this->hydrateCreditmemoTransferFromEntity($creditmemoTransfer, $creditmemoEntity);

        return $creditmemoTransfer;
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     */
    protected function addIdSalesOrderAddressesToCreditmemoEntity(FosCreditmemo $creditmemoEntity): void
    {
        $orderTransfer = $this->salesFacade->findSalesOrderByOrderReference($creditmemoEntity->getOrderReference());
        $creditmemoEntity->setFkSalesOrderAddressBilling($orderTransfer->getBillingAddress()->getIdSalesOrderAddress());
        $creditmemoEntity->setFkSalesOrderAddressShipping($orderTransfer->getShippingAddress()->getIdSalesOrderAddress());
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     * @param array $creditmemoItemCollection
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function saveCreditmemoItems(FosCreditmemo $creditmemoEntity, array $creditmemoItemCollection): void
    {
        foreach ($creditmemoItemCollection as $creditmemoItemTransfer) {
            $idProductConcrete = $this->productFacade->findProductConcreteIdBySku($creditmemoItemTransfer->getSku());
            $idProductAbstract = $this->productFacade->findIdProductAbstactByConcreteSku($creditmemoItemTransfer->getSku());
            $creditmemoItemTransfer->setFkCreditmemo($creditmemoEntity->getPrimaryKey());
            $creditmemoItemTransfer->setFkProductAbstract($idProductAbstract);
            $creditmemoItemTransfer->setFkProduct($idProductConcrete);

            $creditmemoItemEntity = new FosCreditmemoItem();
            $creditmemoItemEntity->fromArray($creditmemoItemTransfer->toArray());
            $creditmemoItemEntity->save();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    protected function hydrateCreditmemoTransferFromEntity(
        CreditmemoTransfer $creditmemoTransfer,
        FosCreditmemo $creditmemoEntity
    ): CreditmemoTransfer {
        $creditmemoTransfer->fromArray($creditmemoEntity->toArray(), true);

        return $creditmemoTransfer;
    }

    /**
     * @param \Orm\Zed\Creditmemo\Persistence\FosCreditmemo $creditmemoEntity
     * @param string $localeName
     *
     * @return void
     */
    protected function addLocaleByLocaleName(FosCreditmemo $creditmemoEntity, $localeName)
    {
        $localeEntity = $this->localeQueryContainer->queryLocaleByName($localeName)->findOne();

        if ($localeEntity) {
            $creditmemoEntity->setFkLocale($localeEntity->getIdLocale());
        }
    }

}