<?php

namespace Tea\PurchaseHistory\Install;

use Module;

class Installer
{
    private array $hooks = [
        'actionProductFormBuilderModifier',
    ];

    /**
     * @param Module $module
     */
    public function __construct(
        private readonly Module $module
    )
    {
    }

    /**
     * @return bool
     */
    public function install(): bool
    {
        if (!$this->registerHooks()) {
            return false;
        }
        return true;
    }


    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        if (!$this->unregisterHooks()) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    private function registerHooks(): bool
    {
        foreach ($this->hooks as $hook) {
            if (!$this->module->registerHook($hook)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    private function unregisterHooks(): bool
    {
        foreach ($this->hooks as $hook) {
            if ($this->module->isRegisteredInHook($hook) && !$this->module->unregisterHook($hook)) {
                return false;
            }
        }
        return true;
    }

}
