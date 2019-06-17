<?php

namespace FondOfSpryker\Zed\Creditmemo\Business;

use FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\Creditmemo;
use FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoInterface;
use FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoReader;
use FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoReaderInterface;
use FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoValidator;
use FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydrator;
use FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface;
use FondOfSpryker\Zed\Creditmemo\CreditmemoDependencyProvider;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManager;
use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManagerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Creditmemo\CreditmemoConfig getConfig()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface getRepository()
 */
class CreditmemoBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoReaderInterface
     */
    public function createCreditmemoReader(): CreditmemoReaderInterface
    {
        return new CreditmemoReader(
            $this->getLocaleFacade(),
            $this->getEntityManager(),
            $this->createCreditmemoHydrator(),
            $this->getRepository()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Business\Creditmemo\CreditmemoInterface
     */
    public function createCreditmemo(): CreditmemoInterface
    {
        return new Creditmemo(
            $this->getProductFacade(),
            $this->getSalesFacade(),
            $this->getCountryFacade(),
            $this->getQueryContainer(),
            $this->getConfig(),
            $this->createCreditmemoValidator(),
            $this->getLocaleQueryContainer(),
            $this->getStore()
        );
    }

    /**
     * @return \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected function getLocaleQueryContainer()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::QUERY_CONTAINER_LOCALE);
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo\CreditmemoHydratorInterface
     */
    public function createCreditmemoHydrator(): CreditmemoHydratorInterface
    {
        return new CreditmemoHydrator(
            $this->getQueryContainer(),
            $this->getSalesQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface
     */
    protected function createCreditmemoValidator()
    {
        return new CreditmemoValidator(
            $this->getQueryContainer(),
            $this->getSalesQueryContainer()
        );
    }

    protected function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::QUERY_CONTAINER_SALES);
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToCountryInterface
     */
    protected function getCountryFacade()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::FACADE_COUNTRY);
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToProductInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \FondOfSpryker\Zed\Creditmemo\Dependency\Facade\CreditmemoToSalesInterface
     */
    protected function getSalesFacade()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore()
    {
        return $this->getProvidedDependency(CreditmemoDependencyProvider::STORE);
    }
}
