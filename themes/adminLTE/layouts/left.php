<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->nombrecompleto ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        
        <!-- /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'MENÚ PRINCIPAL', 'options' => ['class' => 'header']],
                        //['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                        //['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                        [
                            'label' => ' VER.. ',
                            'icon' => 'share',
                            'url' => '#',
                            'items' => [
                                //['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                                //['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                                [
                                    'label' => 'Archivos',
                                    'icon' => 'database',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Administración',
                                            'icon' => 'database',
                                            'url' => '#',
                                            'items' => [
                                                
                                                ['label' => 'Departamento', 'icon' => 'plus-square-o', 'url' => ['/departamento/index']],  
                                                ['label' => 'Municipio', 'icon' => 'plus-square-o', 'url' => ['/municipio/index']],
                                                ['label' => 'Tipo Documento', 'icon' => 'plus-square-o', 'url' => ['/tipo-documento/index']],
                                            ],
                                        ],
                                        [
                                            'label' => 'Movimiento',
                                            'icon' => 'book',
                                            'url' => '#',
                                            'items' => [
                                            ['label' => 'Cliente', 'icon' => 'plus-square-o', 'url' => ['/clientes/index']],
                                            ['label' => 'Insumos', 'icon' => 'plus-square-o', 'url' => ['/insumos/index']], 
                                            ['label' => 'Referencias', 'icon' => 'plus-square-o', 'url' => ['/referencia-producto/index']], 
                                        ]        
                                        ],
                                        [
                                            'label' => 'Consultas',
                                            'icon' => 'question',
                                            'url' => '#',
                                            'items' => [
                                              ['label' => 'Clientes', 'icon' => 'plus-square-o', 'url' => ['/clientes/index_consulta']],
                                              ['label' => 'Cumpleaños', 'icon' => 'plus-square-o', 'url' => ['/clientes/cumpleanos']],
                                            ],
                                        ],
                                        [
                                            'label' => 'Procesos',
                                            'icon' => 'exchange',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Cotizaciones', 'icon' => 'plus-square-o', 'url' => ['/cotizaciones/index']],                                        
                                            ],
                                        ],
                                    ],
                                ],
                             
                             
                                //INICIO DEL MENU CONTABILIDAD
                                 [
                                    'label' => 'Contabilidad',
                                    'icon' => 'bank',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Administración',
                                            'icon' => 'database',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Cuentas', 'icon' => 'plus-square-o', 'url' => ['/cuenta-pub/index']],
                                                ['label' => 'Tipo Recibo', 'icon' => 'plus-square-o', 'url' => ['/tipo-recibo/index']],
                                                ['label' => 'Tipo Compra', 'icon' => 'plus-square-o', 'url' => ['/compra-tipo/index']],
                                                ['label' => 'Concepto Compra', 'icon' => 'plus-square-o', 'url' => ['/compra-concepto/index']],
                                                ['label' => 'Tipo Comprobante Egreso', 'icon' => 'plus-square-o', 'url' => ['/comprobante-egreso-tipo/index']],
                                                ['label' => 'Tipo Comprobante (Exportar)', 'icon' => 'plus-square-o', 'url' => ['/contabilidad-comprobante-tipo/index']],
                                                ['label' => 'Proveedor', 'icon' => 'plus-square-o', 'url' => ['/proveedor/index']],
                                                ['label' => 'Doc Equivalente', 'icon' => 'plus-square-o', 'url' => ['/documento-equivalente/index']],
                                            ],
                                        ],
                                        [
                                            'label' => 'Utilidades',
                                            'icon' => 'cube',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Contabiizar', 'icon' => 'plus-square-o', 'url' => ['/contabilizar/contabilizar']],
                                            ],
                                        ],
                                        [
                                            'label' => 'Consultas',
                                            'icon' => 'question',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Recibo Caja', 'icon' => 'plus-square-o', 'url' => ['/recibocaja/indexconsulta']],
                                                ['label' => 'Compras', 'icon' => 'plus-square-o', 'url' => ['/compra/indexconsulta']],
                                                ['label' => 'Comprobante Egreso', 'icon' => 'plus-square-o', 'url' => ['/comprobante-egreso/indexconsulta']],
                                            ],
                                        ],
                                        [
                                            'label' => 'Movimientos',
                                            'icon' => 'book',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Recibo Caja', 'icon' => 'plus-square-o', 'url' => ['/recibocaja/index']],
                                                ['label' => 'Compras', 'icon' => 'plus-square-o', 'url' => ['/compra/index']],
                                                ['label' => 'Comprobante Egreso', 'icon' => 'plus-square-o', 'url' => ['/comprobante-egreso/index']],
                                            ],
                                        ]
                                    ],
                                ],
                                //TERMINA CONTABILIDAD
                              // mdulo de facturacion
                                [
                                    'label' => 'Facturacion',
                                    'icon' => 'dollar',
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Administración',
                                            'icon' => 'database',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Conceptos Notas', 'icon' => 'plus-square-o', 'url' => ['conceptonota/index']],
                                                ['label' => 'Tipo Factura', 'icon' => 'plus-square-o', 'url' => ['tipo-factura/index']],
                                            ],
                                        ],
                                        
                                        [
                                            'label' => 'Consultas',
                                            'icon' => 'question',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Factura Venta', 'icon' => 'plus-square-o', 'url' => ['/facturaventa/indexconsulta']],
                                            ],
                                        ],
                                      
                                        [
                                            'label' => 'Movimientos',
                                            'icon' => 'book',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Factura Venta', 'icon' => 'plus-square-o', 'url' => ['/facturaventa/index']],
                                                ['label' => 'Nota Crédito', 'icon' => 'plus-square-o', 'url' => ['/notacredito/index']],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'label' => 'General',
                                    'icon' => 'wrench',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Empresa', 'icon' => 'nav-icon fas fa-file', 'url' => ['empresa/empresa', 'id' => 1]],
                                         [
                                        'label' => 'Contenido',
                                        'icon' => 'comment',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Formato principal', 'icon' => 'tumblr-square', 'url' => ['formato-contenido/index']],
                                        ]],
                                    ],
                                ],
                                 
                            ],
                        ],
                    ],
                ]
        )
        ?>

    </section>

</aside>
