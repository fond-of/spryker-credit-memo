<?php

namespace FondOfSpryker\Client\Creditmemo;

use FondOfSpryker\Client\Creditmemo\Zed\CreditmemoStub;
use Spryker\Client\Kernel\AbstractFactory;

class CreditmemoFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Sales\Zed\SalesStubInterface
     */
    public function createZedCreditmemoStub()
    {
        return new CreditmemoStub(
            $this->getProvidedDependency(CreditmemoDependencyProvider::SERVICE_ZED)
        );
    }
}
