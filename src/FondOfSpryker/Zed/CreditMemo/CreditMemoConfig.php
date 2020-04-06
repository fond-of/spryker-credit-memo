<?php

namespace FondOfSpryker\Zed\CreditMemo;

use FondOfSpryker\Shared\CreditMemo\CreditMemoConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CreditMemoConfig extends AbstractBundleConfig
{
    /**
     * @return string|null
     */
    public function getReferenceEnvironmentPrefix(): ?string
    {
        return $this->get(CreditMemoConstants::REFERENCE_ENVIRONMENT_PREFIX, null);
    }

    /**
     * @return string|null
     */
    public function getReferencePrefix(): ?string
    {
        return $this->get(CreditMemoConstants::REFERENCE_PREFIX, null);
    }

    /**
     * @return string|null
     */
    public function getReferenceOffset(): ?string
    {
        return $this->get(CreditMemoConstants::REFERENCE_OFFSET, null);
    }
}
