<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Model\Creditmemo;

use Generated\Shared\Transfer\CreditmemoTransfer;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemo;

interface CreditmemoHydratorInterface
{
    /**
     * @param \Orm\Zed\Creditmemo\Persistence\Base\FosCreditmemo $creditmemoEntity
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function hydrateCreditmemoTransferFromPersistenceByCreditmemo(FosCreditmemo $creditmemoEntity): CreditmemoTransfer;

}


