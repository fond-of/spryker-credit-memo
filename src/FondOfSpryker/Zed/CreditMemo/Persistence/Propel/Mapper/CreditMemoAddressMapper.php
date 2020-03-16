<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoAddress;

class CreditMemoAddressMapper implements CreditMemoAddressMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\CreditMemo\Persistence\FosCreditMemoAddress $fosCreditMemoAddress
     *
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoAddress
     */
    public function mapTransferToEntity(
        AddressTransfer $addressTransfer,
        FosCreditMemoAddress $fosCreditMemoAddress
    ): FosCreditMemoAddress {
        $fosCreditMemoAddress->fromArray(
            $addressTransfer->modifiedToArray(false)
        );

        return $fosCreditMemoAddress;
    }
}
