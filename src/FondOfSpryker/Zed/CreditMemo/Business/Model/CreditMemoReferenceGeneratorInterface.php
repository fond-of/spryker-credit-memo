<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Model;

interface CreditMemoReferenceGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
