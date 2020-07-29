<?php

namespace FondOfSpryker\Zed\CreditMemo\Business\Resolver;

use FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToLocaleFacadeInterface;
use Generated\Shared\Transfer\CreditMemoTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

class LocaleResolver implements ResolverInterface
{
    /**
     * @var \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \FondOfSpryker\Zed\CreditMemo\Dependency\Facade\CreditMemoToLocaleFacadeInterface $localeFacade
     */
    public function __construct(CreditMemoToLocaleFacadeInterface $localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CreditMemoTransfer $creditMemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditMemoTransfer
     */
    public function resolveAndAdd(CreditMemoTransfer $creditMemoTransfer): CreditMemoTransfer
    {
        $creditMemoTransfer->setLocale($this->resolve($creditMemoTransfer->getFkLocale()));

        return $creditMemoTransfer;
    }

    /**
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function resolve(int $idLocale): LocaleTransfer
    {
        return $this->localeFacade->getLocaleById($idLocale);
    }
}
