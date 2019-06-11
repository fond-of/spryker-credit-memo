<?php

namespace FondOfSpryker\Zed\Creditmemo\Dependency\Facade;

interface CreditmemoToCountryInterface
{
    /**
     * @param string $iso2Code
     *
     * @return \Generated\Shared\Transfer\CountryTransfer
     */
    public function getCountryByIso2Code($iso2Code);

    /**
     * @param string $iso2Code
     *
     * @return int
     */
    public function getIdRegionByIso2Code($iso2Code);
}
