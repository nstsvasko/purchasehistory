<?php

namespace Tea\PurchaseHistory\Domain\PurchaseHistory\Query;

use PrestaShop\PrestaShop\Core\Domain\Product\ValueObject\ProductId;

class GetPurchaseHistory
{
    /**
     * @var int|ProductId|null
     */
    private int|null|ProductId $productId;

    /**
     * @param int $productId
     * @throws \PrestaShop\PrestaShop\Core\Domain\Product\Exception\ProductConstraintException
     */
    public function __construct(
        int $productId
    )
    {
        $this->productId = null !== $productId ? new ProductId((int) $productId) : null;
    }

    /**
     * @return int|ProductId|null
     */
    public function getProductId()
    {
        return $this->productId;
    }


}