<?php

namespace FondOfSpryker\Zed\Creditmemo\Business\Creditmemo;

use FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;

class CreditmemoValidator implements CreditmemoValidatorInterface
{
    /**
     * @var \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected $salesQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * CreditmemoValidator constructor.
     * @param \FondOfSpryker\Zed\Creditmemo\Persistence\CreditmemoQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $salesQueryContainer
     */
    public function __construct(
        CreditmemoQueryContainerInterface $queryContainer,
        SalesQueryContainerInterface $salesQueryContainer
    )
    {
        $this->salesQueryContainer = $salesQueryContainer;
        $this->queryContainer = $queryContainer;

    }

    /**
     * @param string $orderReference
     *
     * @return bool
     */
    public function isOrderReferenceValid(string $orderReference): bool
    {
        $salesOrderEntity = $this->salesQueryContainer
            ->querySalesOrder()
            ->filterByOrderReference($orderReference)
            ->findOne();

        return ($salesOrderEntity !== null);
    }


}
