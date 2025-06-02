<?php

namespace Tea\PurchaseHistory\Domain\PurchaseHistory\QueryHandler;

use PrestaShop\PrestaShop\Core\Domain\Currency\ValueObject\CurrencyId;
use Tea\PurchaseHistory\Domain\PurchaseHistory\Query\GetPurchaseHistory;
use Tea\PurchaseHistory\Domain\PurchaseHistory\QueryResult\PurchaseHistory as PurchaseHistoryQueryResult;
use Tea\PurchaseHistory\ReadModel\ProductHistory as ProductHistoryReadModel;

class GetPurchaseHistoryHandler
{
    /**
     * @param ProductHistoryReadModel $productHistoryReadModel
     */
    public function __construct(
        private readonly ProductHistoryReadModel $productHistoryReadModel
    )
    {
    }

    /**
     * @param GetPurchaseHistory $getPurchaseHistory
     * @return PurchaseHistoryQueryResult
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \PrestaShop\PrestaShop\Core\Domain\Currency\Exception\CurrencyException
     */
    public function handle(
        GetPurchaseHistory $getPurchaseHistory
    ): PurchaseHistoryQueryResult
    {
        $productId = $getPurchaseHistory->getProductId()->getValue();

        $qb = $this->productHistoryReadModel->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $history = $qb->select('o.`date_add`, od.`product_quantity`, od.`unit_price_tax_excl`, o.`id_currency`, o.`id_order`')
            ->from($this->productHistoryReadModel->getDatabasePrefix() . 'order_detail', 'od')
            ->join('od', $this->productHistoryReadModel->getDatabasePrefix() . 'orders', 'o', 'o.id_order = od.id_order')
            ->where($expr->eq('od.product_id', ':productId'))
            ->setParameter('productId', $productId)
            ->execute()
            ->fetchAllAssociative();

        if (empty($history)) {
            return new PurchaseHistoryQueryResult();
        }

        $structuredData = [];

        foreach ($history as $orderDetail) {
            $structuredData[] = [
                'date_add' => $orderDetail['date_add'],
                'product_quantity' => $orderDetail['product_quantity'],
                'price_excl' => $this->productHistoryReadModel->getLocale()->formatPrice(
                    $orderDetail['unit_price_tax_excl'],
                    $this->productHistoryReadModel->getCurrencyRepository()->getIsoCode(new CurrencyId($orderDetail['id_currency'])) ?: 'unknown',
                ),
            ];
        }

        return new PurchaseHistoryQueryResult(
            $structuredData
        );

    }

}