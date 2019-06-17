<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface CreditmemoQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param $id
     *
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery
     */
    public function queryCreditmemoById(int $idCreditmemo): FosCreditmemoQuery;
}
