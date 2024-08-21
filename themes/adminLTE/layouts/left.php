<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->nombrecompleto ?></p>
                <a href="#"><i class="fa fa-circle text-primary"></i> Online</a>
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
                                    'label' => 'ARCHIVOS',
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
                                                ['label' => 'Tallas', 'icon' => 'plus-square-o', 'url' => ['/tallas/index']],
                                                 ['label' => 'Grupo', 'icon' => 'plus-square-o', 'url' => ['/grupo-referencia/index']],
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
                                             ['label' => 'Subir imagenes', 'icon' => 'plus-square-o', 'url' => ['/referencia-producto/validador_imagen']],     
                                        ]        
                                        ],
                                        [
                                            'label' => 'Consultas',
                                            'icon' => 'question',
                                            'url' => '#',
                                            'items' => [
                                              ['label' => 'Clientes', 'icon' => 'plus-square-o', 'url' => ['/clientes/index_consulta']],
                                              ['label' => 'Cotizaciones', 'icon' => 'plus-square-o', 'url' => ['/cotizaciones/index_cotizaciones']],
                                              ['label' => 'Utilidad x Referencia', 'icon' => 'plus-square-o', 'url' => ['/cotizaciones/search_rentabilidad']],
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
                             
                                [
                                    'label' => 'GENERAL',
                                    'icon' => 'wrench',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Empresa', 'icon' => 'nav-icon fas fa-file', 'url' => ['empresa/empresa', 'id' => 1]],
                                         
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
