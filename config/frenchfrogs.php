<?php return [

    FrenchFrogs\Core\Configurator::NAMESPACE_DEFAULT => [

        'app.name' => 'Alliwant',
//        'ruler.class' => Models\Acl\Inside::class,
//        'user.business.class' => \Models\Business\User::class,

        // FORM
        'form.element.date.formatjs' => 'dd/mm/yyyy',
        'form.element.date.formatDisplay' => 'd/m/Y',
        'form.element.date.formatStore' => 'Y-m-d',

        // TABLE
        'table.column.date.format' => 'd/m/Y',

        //MAKER
        'maker.renderer.class' => \FrenchFrogs\Maker\Renderer\Php::class,
        'navigations.model.class' => \App\Models\Db\Users\Navigations::class
    ]
];