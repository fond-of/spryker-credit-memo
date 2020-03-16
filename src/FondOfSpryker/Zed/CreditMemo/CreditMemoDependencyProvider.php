<?php

namespace FondOfSpryker\Zed\CreditMemo;

use FondOfSpryker\Zed\CreditMemo\Communication\Plugin\CreditMemoExtension\AddressCreditMemoPreSavePlugin;
use FondOfSpryker\Zed\CreditMemo\Communication\Plugin\CreditMemoExtension\ItemsCreditMemoPostSavePlugin;
use FondOfSpryker\Zed\CreditMemo\Communication\Plugin\CreditMemoExtension\ReferenceCreditMemoPreSavePlugin;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeBridge;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 */
class CreditMemoDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SEQUENCE_NUMBER = 'FACADE_SEQUENCE_NUMBER';
    public const FACADE_STORE = 'FACADE_STORE';

    public const PLUGINS_POST_SAVE = 'PLUGINS_POST_SAVE';
    public const PLUGINS_PRE_SAVE = 'PLUGINS_PRE_SAVE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addSequenceNumberFacade($container);
        $container = $this->addStoreFacade($container);

        $container = $this->addCreditMemoPreSavePlugins($container);
        $container = $this->addCreditMemoPostSavePlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSequenceNumberFacade(Container $container): Container
    {
        $container[static::FACADE_SEQUENCE_NUMBER] = static function (Container $container) {
            return new CreditMemoToSequenceNumberFacadeBridge(
                $container->getLocator()->sequenceNumber()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new CreditMemoToStoreFacadeBridge(
                $container->getLocator()->store()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCreditMemoPreSavePlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRE_SAVE] = static function () use ($self) {
            return $self->getCreditMemoPreSavePlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPreSavePluginInterface[]
     */
    protected function getCreditMemoPreSavePlugins(): array
    {
        return [
            new AddressCreditMemoPreSavePlugin(),
            new ReferenceCreditMemoPreSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCreditMemoPostSavePlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_POST_SAVE] = static function () use ($self) {
            return $self->getCreditMemoPostSavePlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoPostSavePluginInterface[]
     */
    protected function getCreditMemoPostSavePlugins(): array
    {
        return [
            new ItemsCreditMemoPostSavePlugin(),
        ];
    }
}
