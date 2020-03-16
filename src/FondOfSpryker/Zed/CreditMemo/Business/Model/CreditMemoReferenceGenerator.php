<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

use FondOfSpryker\Shared\CreditMemo\CreditMemoConstants;
use FondOfSpryker\Zed\CreditMemo\CreditMemoConfig;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeInterface;
use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;

class CreditMemoReferenceGenerator implements CreditMemoReferenceGeneratorInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacade;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToSequenceNumberFacadeInterface $sequenceNumberFacade
     * @param \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToStoreFacadeInterface $storeFacade
     * @param \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig $config
     */
    public function __construct(
        CreditMemoToSequenceNumberFacadeInterface $sequenceNumberFacade,
        CreditMemoToStoreFacadeInterface $storeFacade,
        CreditMemoConfig $config
    ) {
        $this->sequenceNumberFacade = $sequenceNumberFacade;
        $this->storeFacade = $storeFacade;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $sequenceNumberSettingsTransfer = $this->getSequenceNumberSettingsTransfer();

        return $this->sequenceNumberFacade->generate($sequenceNumberSettingsTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected function getSequenceNumberSettingsTransfer(): SequenceNumberSettingsTransfer
    {
        return (new SequenceNumberSettingsTransfer())
            ->setName(CreditMemoConstants::NAME_CREDIT_MEMO_REFERENCE)
            ->setPrefix($this->getSequenceNumberPrefix());
    }

    /**
     * @return string
     */
    protected function getSequenceNumberPrefix(): string
    {
        $sequenceNumberPrefixParts = [
            $this->storeFacade->getCurrentStore()->getName(),
            $this->config->getEnvironmentPrefix(),
        ];

        return sprintf(
            '%s%s',
            implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts),
            $this->getUniqueIdentifierSeparator()
        );
    }

    /**
     * Separator for the sequence number
     *
     * @return string
     */
    protected function getUniqueIdentifierSeparator(): string
    {
        return '-';
    }
}
