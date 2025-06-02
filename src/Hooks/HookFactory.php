<?php

namespace Tea\PurchaseHistory\Hooks;

use Module;

class HookFactory
{
    /**
     * @param string $hookClass
     * @param Module $module
     * @return mixed
     */
    public function getHook(
        string $hookClass,
        Module $module
    )
    {
        $hookName = 'Tea\PurchaseHistory\Hooks\\' . ucfirst($hookClass);
        return new $hookName($module);
    }

}
