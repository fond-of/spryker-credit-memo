<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Resolver;

use FondOfSpryker\Zed\CreditMemo\Exception\SalesPaymentMethodTypeNotFoundException;
use FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\SalesPaymentMethodTypeTransfer;

class PaymentMethodResolver implements ResolverInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfSpryker\Zed\CreditMemo\Persistence\CreditMemoRepositoryInterface $repository
     */
    public function __construct(CreditMemoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function resolveAndAdd(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        $salesPaymentMethodType = $this->resolve($creditMemoTransfer->getFkSalesOrder());
        $creditMemoTransfer->setFkSalesPaymentMethodType($salesPaymentMethodType->getIdSalesPaymentMethodType());
        $creditMemoTransfer->setSalesPaymentMethodType($salesPaymentMethodType);

        return $creditMemoTransfer;
    }

    /**
     * @param int $idSalesOrder
     *
     * @throws \FondOfSpryker\Zed\CreditMemo\Exception\SalesPaymentMethodTypeNotFoundException
     *
     * @return \Generated\Shared\Transfer\SalesPaymentMethodTypeTransfer
     */
    protected function resolve(int $idSalesOrder): SalesPaymentMethodTypeTransfer
    {
        $salesPaymentMethodType = $this->repository->getSalesPaymentMethodType($idSalesOrder);

        if ($salesPaymentMethodType !== null) {
            return $salesPaymentMethodType;
        }

        throw new SalesPaymentMethodTypeNotFoundException(sprintf(
            'Sales payment method type not found for order with id %s',
            $idSalesOrder
        ));
    }
}
