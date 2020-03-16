<?php

namespace FondOfSpryker\Zed\CreditMemo;

use FondOfSpryker\Shared\CreditMemo\CreditMemoConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CreditMemoConfig extends AbstractBundleConfig
{
    /**
     * @return string|null
     */
    public function getEnvironmentPrefix(): ?string
    {
        return $this->get(CreditMemoConstants::ENVIRONMENT_PREFIX, null);
    }
}
