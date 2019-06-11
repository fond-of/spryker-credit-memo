<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

interface CreditmemoValidatorInterface
{
    /**
     * @param string $orderReference
     *
     * @return bool
     */
    public function isOrderReferenceValid(string $orderReference): bool;
}
