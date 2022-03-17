<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'OrganizadorETN',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Organizador</b>INGETN',
    'logo_img' => 'logos/logo.png',//'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Organizador ETN',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

/*     'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary', */
    'classes_auth_card' => 'bg-primario',
    'classes_auth_header' => 'bg-primario',
    'classes_auth_body' => 'bg-primario',
    'classes_auth_footer' => 'text-center',
    'classes_auth_icon' => 'fa-fw text-light',
    'classes_auth_btn' => 'btn-flat btn-info',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'bg-white',
    'classes_brand' => 'bg-dark',
    'classes_brand_text' => '',
    'classes_content_wrapper' => 'bg-white',
    'classes_content_header' => 'bg-white',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar navbar-dark fondo-primario',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'bg-primario',
    'sidebar_scrollbar_auto_hide' => 'n',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '', //aqui va el detalle
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,//'register',
    'password_reset_url' => false,//'forgot-password',
    'password_email_url' => 'reset-password',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
/*         [
            'type'         => 'navbar-search',
            'text'         => 'buscar',
            'topnav_right' => true,
        ], */
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
/*         [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ], */
        ['header' => 'ADMINISTRADOR',
        'can'        => 'admin.eventosVista'],
/*         [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ], */
        [
            'text'        => 'Eventos vista',
            'url'         => '/inicioAdministrador/eventosVista',
            'icon'        => 'fas fa-calendar',
            'can'        => 'admin.eventosVista',
            'icon_color' => 'green'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Eventos',
            'url'         => '/inicioAdministrador/adminEventos',
            'icon'        => 'fas fa-calendar',
            'can'        => 'admin.eventos',
            'icon_color' => 'blue'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Horarios vista',
            'url'         => '/inicioAdministrador/horariosVista',
            'icon'        => 'fas fa-clipboard-list',
            'can'        => 'admin.horarios',
            'icon_color' => 'red'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Horarios',
            'url'         => '/inicioAdministrador/adminHorarios',
            'icon'        => 'fas fa-clipboard-list',
            'can'        => 'admin.horarios',
            'icon_color' => 'purple'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Exportar Horarios',
            'url'         => '/inicioAdministrador/exporHorarios',
            'icon'        => 'fas fa-file-pdf',
            'can'        => 'admin.horarios',
            'icon_color' => 'grey'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Registros',
            'url'         => '/inicioAdministrador/adminRegistros',
            'icon'        => 'fas fa-user-edit',
            'can'        => 'admin.registros',
            'icon_color' => 'orange'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Asignaturas',
            'url'         => '/inicioAdministrador/adminAsignaturas',
            'icon'        => 'fas fa-chalkboard-teacher',
            'can'        => 'admin.asignaturas',
            'icon_color' => 'cyan'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Grupos',
            'url'         => '/inicioAdministrador/adminGrupos',
            'icon'        => 'fas fa-object-group',
            'can'        => 'admin.asignaturas',
            'icon_color' => 'green'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Menciones',
            'url'         => '/inicioAdministrador/adminProgramas',
            'icon'        => 'fas fa-microchip',
            'can'        => 'admin.programas',
            'icon_color' => 'blue'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Materias',
            'url'         => '/inicioAdministrador/adminMaterias',
            'icon'        => 'fas fa-university',
            'can'        => 'admin.materias',
            'icon_color' => 'red'

            /* 'label_color' => 'success', */
        ],
        [
            'text'        => 'Usuarios',
            'url'         => '/inicioAdministrador/adminUsers',
            'icon'        => 'fas fa-users-cog',
            'can'        => 'admin.users',
            'icon_color' => 'purple'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        ['header' => 'EVENTOS DOCENTE',
        'can'        => 'docente.eventosVista'],
/*         [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ], */
        [
            'text'        => 'Mis eventos',
            'url'         => '/inicioDocente/eventosVista',
            'icon'        => 'fas fa-calendar-alt',
            'can'        => 'docente.eventosVista',
            'icon_color' => 'green'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Editar eventos',
            'url'         => '/inicioDocente/eventosEdicion',
            'icon'        => 'fas fa-edit',
            'can'        => 'docente.eventosEdicion',
            'icon_color' => 'cyan'
/*             'label'       => 4,
            'label_color' => 'success', */
        ], [
            'text'        => 'Registros',
            'url'         => '/inicioDocente/registro',
            'icon'        => 'fas fa-user-edit',
            'can'        => 'docente.reporte',
            'icon_color' => 'orange'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Generar reporte',
            'url'         => '/inicioDocente/reporteDocente',
            'icon'        => 'fas fa-address-book',
            'can'        => 'docente.reporte',
            'icon_color' => 'red'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        ['header' => 'EVENTOS AUXILIAR',
        'can'        => 'auxiliar.eventosEdicion'],
/*         [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ], */
        [
            'text'        => 'Mis eventos',
            'url'         => '/inicioAuxiliar/eventosVista',
            'icon'        => 'fas fa-calendar-alt',
            'can'        => 'auxiliar.eventosVista',
            'icon_color' => 'green'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Editar eventos',
            'url'         => '/inicioAuxiliar/eventosEdicion',
            'icon'        => 'fas fa-edit',
            'can'        => 'auxiliar.eventosEdicion',
            'icon_color' => 'cyan'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Horarios',
            'url'         => '/inicioEstudiante/horario',
            'icon'        => 'fas fa-clipboard-list',
            'can'        => 'auxiliar.eventosVista',
            'icon_color' => 'purple'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        ['header' => 'EVENTOS ESTUDIANTE',
        'can'        => 'estudiante.eventosVista'],
/*         [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ], */
        [
            'text'        => 'Mis eventos',
            'url'         => '/inicioEstudiante/eventosVista',
            'icon'        => 'fas fa-calendar-alt',
            'can'        => 'estudiante.eventosVista',
            'icon_color' => 'green'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
        [
            'text'        => 'Horarios',
            'url'         => '/inicioEstudiante/horario',
            'icon'        => 'fas fa-clipboard-list',
            'can'        => 'estudiante.eventosVista',
            'icon_color' => 'purple'
/*             'label'       => 4,
            'label_color' => 'success', */
        ],
/*         [
            'text'        => 'Inscripciones',
            'url'         => '/inicioEstudiante/registro',
            'icon'        => 'fas fa-user-edit',
            'can'        => 'estudiante.registro',
            'icon_color' => 'orange' */
/*             'label'       => 4,
            'label_color' => 'success', */
        /* ], */
        [
            'text'        => 'Reportes',
            'url'         => '/inicioAuxiliar/reporteAuxiliar',
            'icon'        => 'fas fa-address-book',
            'can'        => 'auxiliar.reporte',
            'icon_color' => 'red',
/*             'label'       => 4,
            'label_color' => 'success', */
        ],

        ['header' => 'CONFIGURACIÓN '],
        [
            'text' => 'Perfil',
            'url'  => 'user/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
/*         [
            'text' => 'change_password',
            'url'  => 'admin/settings',
            'icon' => 'fas fa-fw fa-lock',
        ], */
/*         [
            'text'    => 'multilevel',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ], */
/*         ['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
        ], */
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
            
        ],
        'momentjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js',
                ],
            ],
        ],
        'full-calendar5P' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fullcalendar5p/lib/main.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fullcalendar5/daygrid/main.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'fullcalendar5/timegrid/main.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'fullcalendar5p/lib/main.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'fullcalendar5/daygrid/main.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'fullcalendar5/timegrid/main.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'fullcalendar5/lib/locales/es.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'fullcalendar5/moment/locale/es.js',
                ]
            ],
        ],
        'bootstrap-clockpicker' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/bootstrap-clockpicker.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/bootstrap-clockpicker.js',
                ],
            ],
        ],
        'jquery-confirm' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/jquery-confirm.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/jquery-confirm.js',
                ],
            ],
        ],
        'bootstrap-select' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/bootstrap-select.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/bootstrap-select.js',
                ],
            ],
        ],
        'pushjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'push.js-master/bin/push.min.js',
                ],
            ],
        ],
        'bootstrap-table' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/bootstrap-table.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/bootstrap-table.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/bootstrap-table-es-ES.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/bootstrap-table-auto-refresh.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
