<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoPersistenceFactory getFactory()
 */
class CreditmemoQueryContainer extends AbstractQueryContainer implements CreditmemoQueryContainerInterface
{
    /**
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery
     */
    public function queryCreditmemo(): FosCreditmemoQuery
    {
        return $this->getFactory()->createCreditmemoQuery();
    }

    /**
     * @param int $idCreditmemo
     *
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery
     */
    public function queryCreditmemoById(int $idCreditmemo): FosCreditmemoQuery
    {
        $query = $this->queryCreditmemo();
        $query->filterByIdCreditmemo($idCreditmemo);

        return $query;
    }
}
