<?php

namespace Tea\PurchaseHistory\Hooks;

interface HookInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params = []);
}
