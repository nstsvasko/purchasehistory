<?php

namespace Tea\PurchaseHistory\Hooks;

use Module;
use Tea\PurchaseHistory\Form\Modifier\ProductFormModifier;
use PrestaShop\PrestaShop\Core\Domain\Product\ValueObject\ProductId;

class HookActionProductFormBuilderModifier implements HookInterface
{

    /**
     * @param Module $module
     */
    public function __construct(
        private readonly Module $module
    )
    {
    }

    /**
     * @param array $params
     * @return void
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShop\PrestaShop\Core\Domain\Currency\Exception\CurrencyException
     * @throws \PrestaShop\PrestaShop\Core\Domain\Product\Exception\ProductConstraintException
     */
    public function execute(
        array $params = []
    ): void
    {

        /** @var ProductFormModifier $productFormModifier */
        $productFormModifier = $this->module->get(ProductFormModifier::class);

        $productId = isset($params['id']) ? new ProductId((int) $params['id']) : null;

        $productFormModifier->modify($productId, $params['form_builder']);

    }

}
