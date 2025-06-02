<?php

namespace Tea\PurchaseHistory\Form\Type;

use PrestaShopBundle\Form\Admin\Type\CustomContentType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PurchaseHistoryTabType extends TranslatorAwareType
{

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param \Currency $defaultCurrency
     */
    public function __construct(
        private readonly TranslatorInterface $translator,
        array $locales,
    ) {
        parent::__construct($translator, $locales);
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $purchaseHistoryData = $options['data'];

        $builder->add(
            'product_purchase_history',
            CustomContentType::class,
            [
            'label' => false,
                'template' => '@Modules/teapurchasehistory/views/templates/admin/purchase_history_template_list.html.twig',
                'data' => $purchaseHistoryData,
            ]
        );

    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(
        OptionsResolver $resolver
    )
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'label' => $this->trans('Purchase History', 'Modules.Teapurchasehistory.Admin'),
                'data' => []
            ])
        ;
    }

}
