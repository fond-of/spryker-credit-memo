<?php

namespace FondOfSpryker\Zed\Creditmemo\Persistence;

use Orm\Zed\Creditmemo\Persistence\FosCreditmemoItemQuery;
use Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\Creditmemo\CreditmemoConfig getConfig()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoRepositoryInterface getRepository()
 */
class CreditmemoPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemoQuery
     */
    public function createCreditmemoQuery(): FosCreditmemoQuery
    {
        return FosCreditmemoQuery::create();
    }

    /**
     * @return \Orm\Zed\Creditmemo\Persistence\FosCreditmemoItemQuery
     */
    public function createCreditmemoItemQuery(): FosCreditmemoItemQuery
    {
        return FosCreditmemoItemQuery::create();
    }

}
