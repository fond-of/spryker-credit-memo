<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Processor;

use ArrayIterator;
use FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface;
use Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer;

interface CreditMemoProcessorInterface
{
    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[]
     */
    public function getProcessor(): array;

    /**
     * @param string $processorName
     *
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface
     */
    public function get(string $processorName): CreditMemoProcessorPluginInterface;

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processorPluginNames
     * @param array $ids
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer
     */
    public function process(array $processorPluginNames, array $ids): CreditMemoProcessorResponseCollectionTransfer;

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processor
     *
     * @return $this
     */
    public function setProcessor(array $processor): self;

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface $processorPlugin
     *
     * @return $this
     */
    public function addProcessor(CreditMemoProcessorPluginInterface $processorPlugin): self;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator;
}
