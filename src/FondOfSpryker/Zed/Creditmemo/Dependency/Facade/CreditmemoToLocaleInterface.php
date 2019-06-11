<?php

namespace FondOfSpryker\Zed\Creditmemo\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface CreditmemoToLocaleInterface
{
    /**
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocaleByIdLocale(int $idLocale): LocaleTransfer;
}
