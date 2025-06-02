<?php

namespace Tea\PurchaseHistory\ReadModel;

use Db;
use DbQuery;
use Doctrine\DBAL\Connection;
use PrestaShop\PrestaShop\Adapter\Currency\Repository\CurrencyRepository;
use PrestaShop\PrestaShop\Adapter\Validate;
use PrestaShop\PrestaShop\Core\Domain\Currency\ValueObject\CurrencyId;
use PrestaShopBundle\Exception\ProductNotFoundException;
use Product;
use PrestaShop\PrestaShop\Core\Localization\LocaleInterface;

class ProductHistory extends AbstractReadModel
{
    /**
     * @param Connection $connection
     * @param string $databasePrefix
     * @param LocaleInterface $locale
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(
        private readonly Connection $connection,
        private readonly string $databasePrefix,
        private readonly LocaleInterface $locale,
        private readonly CurrencyRepository $currencyRepository,
    )
    {
        parent::__construct(
            $connection,
            $databasePrefix
        );
    }

    /**
     * @param int $productId
     * @return array
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShop\PrestaShop\Core\Domain\Currency\Exception\CurrencyException
     */
    public function getPurchaseHistoryByProductId(
        int $productId
    ): array
    {
        $product = new Product($productId);
        if (!Validate::isLoadedObject($product) ) {
            throw new ProductNotFoundException(sprintf('Product is not exists for ID=%d.', $productId));
        }

        $dbQuery = new DbQuery();
        $dbQuery
            ->select('o.`date_add`, od.`product_quantity`, od.`unit_price_tax_excl`, o.`id_currency`, o.`id_order`')
            ->from('order_detail', 'od')
            ->where('od.`product_id` = ' . $productId)
            ->innerJoin(
                'orders',
                'o',
                'o.`id_order` = od.`id_order`'
            )
        ;

        $history = Db::getInstance()->executeS($dbQuery);

        if (empty($history)) {
            return [];
        }

        $structuredData = [];

        foreach ($history as $orderDetail) {
            $structuredData[] = [
                'date_add' => $orderDetail['date_add'],
                'product_quantity' => $orderDetail['product_quantity'],
                'price_excl' => $this->locale->formatPrice(
                    $orderDetail['unit_price_tax_excl'],
                    $this->currencyRepository->getIsoCode(new CurrencyId($orderDetail['id_currency'])) ?: 'unknown',
                ),
            ];
        }
        return $structuredData;
    }

    /**
     * @return LocaleInterface
     */
    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    /**
     * @return CurrencyRepository
     */
    public function getCurrencyRepository(): CurrencyRepository
    {
        return $this->currencyRepository;
    }

}
