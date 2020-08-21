<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Processor;

use ArrayIterator;
use Countable;
use Exception;
use FondOfSpryker\Zed\CreditMemo\CreditMemoConfig;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface;
use FondOfSpryker\Zed\CreditMemo\Exception\ProcessorNotFoundException;
use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface;
use FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface;
use Generated\Shared\Transfer\CreditMemoCollectionTransfer;
use Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer;
use Generated\Shared\Transfer\CreditMemoProcessorStatusTransfer;
use Generated\Shared\Transfer\CreditMemoTransfer;
use IteratorAggregate;
use Spryker\Shared\Log\LoggerTrait;
use Throwable;

class CreditMemoProcessor implements Countable, IteratorAggregate, CreditMemoProcessorInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[]
     */
    protected $processor = [];

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface
     */
    protected $creditMemoRepository;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface
     */
    protected $store;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig
     */
    protected $config;

    /**
     * @param array $processor
     * @param \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface $creditMemoRepository
     * @param \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface $store
     * @param \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig $config
     */
    public function __construct(
        array $processor,
        CreditMemoRepositoryInterface $creditMemoRepository,
        CreditMemoToStoreFacadeInterface $store,
        CreditMemoConfig $config
    ) {
        $this->setProcessor($processor);
        $this->creditMemoRepository = $creditMemoRepository;
        $this->store = $store;
        $this->config = $config;
    }

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processorPluginNames
     * @param array $ids
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorResponseCollectionTransfer
     */
    public function process(array $processorPluginNames, array $ids): CreditMemoProcessorResponseCollectionTransfer
    {
        $creditMemoCollection = $this->resolveCreditMemos($ids);
        $processor = $this->prepareProcessorPlugins($processorPluginNames);

        $responseCollection = new CreditMemoProcessorResponseCollectionTransfer();
        $count = 0;
        $errorCount = 0;

        foreach ($creditMemoCollection->getCreditMemos() as $creditMemoTransfer) {
            try {
                $response = $this->startProcessing($processor, $creditMemoTransfer);
            } catch (Throwable $exception) {
                $response = $this->createErrorResponse($creditMemoTransfer, $exception);
                $errorCount++;
                $this->getLogger()->error($exception->getMessage(), $exception->getTrace());
            }
            $count++;
            $responseCollection->addStatus($response);
        }
        $responseCollection->setCount($count);
        $responseCollection->setErrorCount($errorCount);

        return $responseCollection;
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[]
     */
    public function getProcessor(): array
    {
        return $this->processor;
    }

    /**
     * @param string $processorName
     *
     * @throws \FondOfSpryker\Zed\CreditMemo\Exception\ProcessorNotFoundException
     *
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface
     */
    public function get(string $processorName): CreditMemoProcessorPluginInterface
    {
        if (array_key_exists($processorName, $this->processor)) {
            return $this->processor[$processorName];
        }

        throw new ProcessorNotFoundException(sprintf('Processor with name %s not found! Please register first!'));
    }

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processor
     *
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Processor\CreditMemoProcessorInterface
     */
    public function setProcessor(array $processor): CreditMemoProcessorInterface
    {
        foreach ($processor as $processorPlugin) {
            $this->addProcessor($processorPlugin);
        }

        return $this;
    }

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface $processorPlugin
     *
     * @return \FondOfSpryker\Zed\CreditMemo\Business\Processor\CreditMemoProcessorInterface
     */
    public function addProcessor(CreditMemoProcessorPluginInterface $processorPlugin): CreditMemoProcessorInterface
    {
        $this->processor[$processorPlugin->getName()] = $processorPlugin;

        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->processor);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->processor);
    }

    /**
     * @param \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[] $processorPlugins
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorStatusTransfer
     */
    protected function startProcessing(
        array $processorPlugins,
        CreditMemoTransfer $creditMemoTransfer
    ): CreditMemoProcessorStatusTransfer {
        $statusResponse = $this->createDefaultResponse($creditMemoTransfer);

        foreach ($processorPlugins as $processorPlugin) {
            if ($processorPlugin->canProcess($creditMemoTransfer)) {
                return $processorPlugin->process($creditMemoTransfer, $statusResponse);
            }
        }

        return $statusResponse;
    }

    /**
     * @param string[] $processorPlugins
     *
     * @return \FondOfSpryker\Zed\CreditMemoExtension\Dependency\Plugin\CreditMemoProcessorPluginInterface[]
     */
    protected function prepareProcessorPlugins(array $processorPlugins): array
    {
        if ($processorPlugins === []) {
            return $this->getProcessor();
        }

        $processor = [];
        foreach ($processorPlugins as $processorPluginName) {
            $processor[$processorPluginName] = $this->get($processorPluginName);
        }

        return $processor;
    }

    /**
     * @param array $ids
     *
     * @return \Generated\Shared\Transfer\CreditMemoCollectionTransfer|null
     */
    protected function resolveCreditMemos(array $ids): ?CreditMemoCollectionTransfer
    {
        if ($ids === []) {
            return $this->creditMemoRepository->findUnprocessedCreditMemoByStore($this->store->getCurrentStore(), $this->config->getProcessSizeMax());
        }

        return $this->creditMemoRepository->findUnprocessedCreditMemoByStoreAndIds(
            $this->store->getCurrentStore(),
            $ids
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorStatusTransfer
     */
    protected function createDefaultResponse(CreditMemoTransfer $creditMemoTransfer): CreditMemoProcessorStatusTransfer
    {
        $alesPaymentMethodType = $creditMemoTransfer->getSalesPaymentMethodType();

        $statusResponse = (new CreditMemoProcessorStatusTransfer())
            ->setSuccess(false)
            ->setId($creditMemoTransfer->getIdCreditMemo())
            ->setMessage(sprintf(
                'No credit memo processor available to process order with payment method %s and payment provider %s',
                $alesPaymentMethodType->getPaymentMethod(),
                $alesPaymentMethodType->getPaymentProvider()
            ));

        return $statusResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     * @param \Exception $exception
     *
     * @return \Generated\Shared\Transfer\CreditMemoProcessorStatusTransfer
     */
    protected function createErrorResponse(
        CreditMemoTransfer $creditMemoTransfer,
        Exception $exception
    ): CreditMemoProcessorStatusTransfer {
        return (new CreditMemoProcessorStatusTransfer())
            ->setSuccess(false)
            ->setId($creditMemoTransfer->getIdCreditMemo())
            ->setMessage($exception->getMessage());
    }
}
