<?php return [

    FrenchFrogs\Core\Configurator::NAMESPACE_DEFAULT => [
        'table.class' => FrenchFrogs\Table\Table\Conquer::class,
        'table.renderer.class' =>  FrenchFrogs\Table\Renderer\Conquer::class,
        'panel.renderer.class' =>  FrenchFrogs\Panel\Renderer\Conquer::class,
        'form.renderer.class' =>  FrenchFrogs\Form\Renderer\Conquer::class,
        'form.renderer.modal.class' => FrenchFrogs\Form\Renderer\ConquerModal::class,
        'ruler.class' => FrenchFrogs\Acl\Acl::class,
        'user.business.class' => \Models\Business\User::class,

        'form.element.date.formatjs' => 'dd/mm/yyyy',
        'form.element.date.formatDisplay' => 'd/m/Y',
        'form.element.date.formatStore' => 'Y-m-d',
    ]
];