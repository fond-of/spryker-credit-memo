<?php

namespace FondOfSpryker\Zed\Creditmemo\Dependency\Facade;

interface CreditmemoToProductInterface
{
    /**
     * @param string $sku
     *
     * @return int
     */
    public function findIdProductAbstactByConcreteSku(string $sku): int;

    /**
     * @param string $sku
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $sku): int;
}
