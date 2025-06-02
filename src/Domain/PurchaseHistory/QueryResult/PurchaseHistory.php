<?php

namespace Tea\PurchaseHistory\Domain\PurchaseHistory\QueryResult;


class PurchaseHistory
{

    private array $data;

    /**
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

}
