<?php

namespace FondOfSpryker\Shared\CreditMemo;

use Spryker\Shared\SequenceNumber\SequenceNumberConstants;

interface CreditMemoConstants
{
    public const REFERENCE_NAME_VALUE = 'ShipmentDeliveryNoteReference';
    public const REFERENCE_PREFIX = 'CREDIT_MEMO:REFERENCE_PREFIX';
    public const REFERENCE_ENVIRONMENT_PREFIX = SequenceNumberConstants::ENVIRONMENT_PREFIX;
    public const REFERENCE_OFFSET = 'CREDIT_MEMO:REFERENCE_OFFSET';
}
