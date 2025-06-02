<?php

namespace Tea\PurchaseHistory\Form\Modifier;

use PrestaShop\PrestaShop\Core\Domain\Product\Exception\ProductConstraintException;
use PrestaShop\PrestaShop\Core\Domain\Product\ValueObject\ProductId;
use PrestaShopBundle\Form\FormBuilderModifier;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Tea\PurchaseHistory\Domain\PurchaseHistory\Query\GetPurchaseHistory;
use Tea\PurchaseHistory\Form\Type\PurchaseHistoryTabType;
use Tea\PurchaseHistory\ReadModel\ProductHistory as ReadModelProductHistory;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;

class ProductFormModifier
{

    /**
     * @param TranslatorInterface $translator
     * @param FormBuilderModifier $formBuilderModifier
     * @param ReadModelProductHistory $readModelProductHistory
     * @param CommandBusInterface $queryBus
     */
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly FormBuilderModifier $formBuilderModifier,
        private readonly ReadModelProductHistory $readModelProductHistory,
        private readonly CommandBusInterface $queryBus,
    ) {
    }

    /**
     * @param ProductId|null $productId
     * @param FormBuilderInterface $productFormBuilder
     * @return void
     * @throws ProductConstraintException
     */
    public function modify(
        ?ProductId $productId,
        FormBuilderInterface $productFormBuilder
    ): void
    {
        $idValue = $productId?->getValue();

        //tea001 - via CQRS
        $purchaseHistoryModel = $this->queryBus->handle(
            new GetPurchaseHistory(
                $idValue
            )
        );
        $purchaseHistory = $purchaseHistoryModel->getData();

        //tea001 -> via readModel
//        $purchaseHistory = $this->readModelProductHistory->getPurchaseHistoryByProductId(
//            $idValue
//        );

        $this->formBuilderModifier->addAfter(
            $productFormBuilder,
            'pricing',
            'purchase_history',
            PurchaseHistoryTabType::class,
            [
                'data' => $purchaseHistory,
            ]
        );

    }

}
