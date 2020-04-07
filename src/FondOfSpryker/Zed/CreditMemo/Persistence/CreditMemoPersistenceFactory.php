<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoAddressMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoAddressMapperInterface;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapperInterface;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapperInterface;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CreditMemo\CreditMemoConfig getConfig()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface getRepository()
 */
class CreditMemoPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemQuery
     */
    public function createCreditMemoItemQuery(): FosCreditMemoItemQuery
    {
        return FosCreditMemoItemQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapperInterface
     */
    public function createCreditMemoMapper(): CreditMemoMapperInterface
    {
        return new CreditMemoMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoAddressMapperInterface
     */
    public function createCreditMemoAddressMapper(): CreditMemoAddressMapperInterface
    {
        return new CreditMemoAddressMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapperInterface
     */
    public function createCreditMemoItemMapper(): CreditMemoItemMapperInterface
    {
        return new CreditMemoItemMapper();
    }
}
