<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use FondOfSpryker\Zed\Creditmemo\CreditmemoConfig;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToCountryInterface;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToProductInterface;
use FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToSalesInterface;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
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

}