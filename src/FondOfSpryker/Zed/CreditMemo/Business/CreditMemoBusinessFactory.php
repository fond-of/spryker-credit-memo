<?php

namespace FondOfSpryker\Zed\CreditMemo\Business;

use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoAddressWriter;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoAddressWriterInterface;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoItemsWriter;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoItemsWriterInterface;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoPluginExecutor;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoPluginExecutorInterface;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoReferenceGenerator;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoReferenceGeneratorInterface;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoWriter;
use FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoWriterInterface;
use FondOfSpryker\Zed\CreditMemo\CreditMemoDependencyProvider;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeInterface;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManager getEntityManager()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepository getRepository()
 */
class CreditMemoBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoWriterInterface
     */
    public function createCreditMemoWriter(): CreditMemoWriterInterface
    {
        return new CreditMemoWriter(
            $this->getEntityManager(),
            $this->createCreditMemoPluginExecutor()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoPluginExecutorInterface
     */
    protected function createCreditMemoPluginExecutor(): CreditMemoPluginExecutorInterface
    {
        return new CreditMemoPluginExecutor(
            $this->getCreditMemoPreSavePlugins(),
            $this->getCreditMemoPostSavePlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoAddressWriterInterface
     */
    public function createCreditMemoAddressWriter(): CreditMemoAddressWriterInterface
    {
        return new CreditMemoAddressWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoItemsWriterInterface
     */
    public function createCreditMemoItemsWriter(): CreditMemoItemsWriterInterface
    {
        return new CreditMemoItemsWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Model\CreditMemoReferenceGeneratorInterface
     */
    public function createCreditMemoReferenceGenerator(): CreditMemoReferenceGeneratorInterface
    {
        return new CreditMemoReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getStoreFacade(),
            $this->getConfig()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPreSavePluginInterface]|
     */
    protected function getCreditMemoPreSavePlugins(): array
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::PLUGINS_PRE_SAVE);
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPostSavePluginInterface[]
     */
    protected function getCreditMemoPostSavePlugins(): array
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::PLUGINS_POST_SAVE);
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeInterface
     */
    protected function getSequenceNumberFacade(): CreditMemoToSequenceNumberFacadeInterface
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface
     */
    protected function getStoreFacade(): CreditMemoToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::FACADE_STORE);
    }
}
