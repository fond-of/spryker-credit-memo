<?php

namespace FondOfSpryker\Zed\CreditMemo\Persistence;

use FondOfSpryker\Zed\CreditMemo\CreditMemoDependencyProvider;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapperInterface;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemStateMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemStateMapperInterface;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapperInterface;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoStateMapper;
use FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoStateMapperInterface;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemQuery;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemStateQuery;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoQuery;
use Orm\Zed\CreditMemo\Persistence\FosCreditMemoStateQuery;
use Orm\Zed\Payment\Persistence\SpySalesPaymentQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
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
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoQuery
     */
    public function createCreditMemoQuery(): FosCreditMemoQuery
    {
        return FosCreditMemoQuery::create();
    }

    /**
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoStateQuery
     */
    public function createCreditMemoStateQuery(): FosCreditMemoStateQuery
    {
        return FosCreditMemoStateQuery::create();
    }

    /**
     * @return \Orm\Zed\CreditMemo\Persistence\FosCreditMemoItemStateQuery
     */
    public function createCreditMemoItemStateQuery(): FosCreditMemoItemStateQuery
    {
        return FosCreditMemoItemStateQuery::create();
    }

    /**
     * @return \Orm\Zed\Payment\Persistence\SpySalesPaymentQuery
     */
    public function getSpySalesPaymentQuery(): SpySalesPaymentQuery
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::QUERY_SALES_PAYMENT);
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function getSpySalesOrderQuery(): SpySalesOrderQuery
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::QUERY_SALES_ORDER);
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery
     */
    public function getSpySalesOrderItemQuery(): SpySalesOrderItemQuery
    {
        return $this->getProvidedDependency(CreditMemoDependencyProvider::QUERY_SALES_ORDER_ITEM);
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoMapperInterface
     */
    public function createCreditMemoMapper(): CreditMemoMapperInterface
    {
        return new CreditMemoMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemMapperInterface
     */
    public function createCreditMemoItemMapper(): CreditMemoItemMapperInterface
    {
        return new CreditMemoItemMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoStateMapperInterface
     */
    public function createCreditMemoStateMapper(): CreditMemoStateMapperInterface
    {
        return new CreditMemoStateMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CreditMemo\Persistence\Propel\Mapper\CreditMemoItemStateMapperInterface
     */
    public function createCreditMemoItemStateMapper(): CreditMemoItemStateMapperInterface
    {
        return new CreditMemoItemStateMapper();
    }
}
