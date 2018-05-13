<?php
return [

    'default' => 'default',

    'namespaces' => [

        'default' => [
            'panel' => [
                'class' => FrenchFrogs\Panel\Panel\Panel::class,
                'renderer' => FrenchFrogs\Panel\Renderer\AdminLTE::class,
            ],

            'table' => [
                'class' => FrenchFrogs\Table\Table\Table::class,
                'renderer' => FrenchFrogs\Table\Renderer\AdminLTE::class,
                'filterer' => \FrenchFrogs\Table\Filterer\Filterer::class
            ],

            'form' => [
                'class' => FrenchFrogs\Form\Form\Form::class,
                'renderer' => FrenchFrogs\Form\Renderer\AdminLTE::class,
                'renderer_modal' => FrenchFrogs\Form\Renderer\AdminLTEModal::class,
                'filterer' => FrenchFrogs\Filterer\Filterer::class,
                'method' => 'POST',
                'csrf' => true,
                'element' => [
                    'date' => [
                        'formatDisplay' => 'd-m-Y',
                        'formatjs' => 'dd-mm-yyyy',
                        'formatStore' => 'Y-m-d',
                    ]
                ]

            ],

            'date' => 'd/m/Y',
            'datetime' => 'd/m/Y h:i',


            'modal' => [
                'class' => FrenchFrogs\Modal\Modal\Modal::class,
                'renderer' => FrenchFrogs\Modal\Renderer\Bootstrap::class,
                'closeButtonLabel' => 'Fermer',
                'backdrop' => true,
                'escToclose' => true,
                'is_remote' => false,
                'remoteId' => 'modal-remote',
            ],

            'toastr' => [
                'success' => 'Action realised with success',
                'error' => 'Oups, something bad happened',
                'warning' => 'Something happened....',
            ],

            'button' => [
                'create' => [
                    'icon' => 'fa fa-plus',
                    'name' => 'ff_create',
                    'label' => 'Nouveau',
                ],

                'edit' => [
                    'icon' => 'fa fa-pencil',
                    'name' => 'ff_edit',
                    'label' => 'Editer',
                ],
                'delete' => [
                    'icon' => 'fa fa-trash-o',
                    'name' => 'ff_delete',
                    'label' => 'Supprimer',
                ],
            ]

        ]
    ]
];