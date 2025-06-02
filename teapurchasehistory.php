<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class teapurchasehistory extends Module
{

    private \Tea\PurchaseHistory\Hooks\HookFactory $hookFactory;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->version = '1.0.0';
        $this->author = 'Yauheni';
        $this->name = 'teapurchasehistory';
        $this->tab = 'administration';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('Product purchase history');
        $this->description = $this->trans('Product purchase history');
        $this->ps_versions_compliancy = ['min' => '8.1', 'max' => '8.99.99.99'];
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?');

        $this->initExtended();
    }

    public function hookActionProductFormBuilderModifier(
        array $params
    )
    {
        return $this->executeHook(
            __FUNCTION__,
            $params
        );
    }

    public function getContent()
    {
        return 'Hello how are you?';
    }

    /**
     * @return bool
     */
    public function install(): bool
    {
        if (!parent::install()) {
            return false;
        }

        $installer = new \Tea\PurchaseHistory\Install\Installer($this);
        return $installer->install();
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        $installer = new \Tea\PurchaseHistory\Install\Installer($this);
        if (!$installer->uninstall()) {
            return false;
        }

        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    /**
     * @param string $functionName
     * @param array $params
     * @return mixed
     */
    private function executeHook(
        string $functionName,
        array $params = []
    )
    {
        return $this->hookFactory->getHook($functionName, $this)->execute($params);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function initExtended(): void
    {
        $this->hookFactory = new \Tea\PurchaseHistory\Hooks\HookFactory();
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

}
