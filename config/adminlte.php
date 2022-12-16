<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    // 'title' => 'Агентии беҳдошти замин ва обёрии назди Ҳукумати Ҷумҳурии Тоҷикистон',
    //'title' => 'Агентство мелиорации и ирригации при Правительстве Республики Таджикистан',
    'title' => 'Структура базы данных Института водных проблем, гидроэнергетики и экологии',
    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>ИВОГЭиЭ</b>',

    'logo_mini' => '<b>ИВОГЭиЭ</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we have the option to enable a right sidebar.
    | When active, you can use @section('right-sidebar')
    | The icon you configured will be displayed at the end of the top menu,
    | and will show/hide de sidebar.
    | The slide option will slide the sidebar over the content, while false
    | will push the content, and have no animation.
    | You can also choose the sidebar theme (dark or light).
    | The right Sidebar can only be used if layout is not top-nav.
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'light',
    'right_sidebar_slide' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'password_reset_url' => '',
    // 'password_reset_url' => 'password/reset',

    // 'register_url' => '',
    'register_url' => 'register-new',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and a URL. You can also specify an icon from Font
    | Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    */

    'menu' => [
        ['header' => 'main_navigation'],
        [
            'text'        => 'Главная',
            'url'         => 'home',
            'icon'        => 'fas fa-home',
            'submenu' => [
                [
                    'text' => 'История',
                    'url'  => '#',
                    'icon' => 'fas fa-history',
                ],
                [
                    'text' => 'Новости',
                    'url'  => '#',
                    'icon' => 'fas fa-newspaper',
                ],
                [
                    'text' => 'Характеристика БД',
                    'url'  => '#',
                    'icon' => 'fas fa-database',
                ],
            ]
        ],
        [
            'text'        => 'Водные ресурсы',
            'url'         => '#',
            'icon'        => 'fab fa-water',
            'submenu' => [
                [
                    'text' => 'Водные зоны',
                    'url'  => '#',
                    'icon' => 'fas fa-minus',
                ],
                [ 
                    'text' => 'Уровень воды (H)',
                    'url'  => 'modeli/water-level',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Карта Гидропостов',
                    'url'  => 'izmeriteli/graph',
                    'icon' => 'fas fa-minus',
                ],
            ],
        ],
        [
            'text'        => 'Планирование',
            'url'         => 'planirovanie/seva',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'План сева',
                    'url'  => 'planirovanie/seva',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'План водопадачи',
                    'url'  => 'planirovanie/vodopadachi',
                    'icon' => 'fas fa-minus',
                ],
                /*[
                    'text' => 'Балансовая ведомость',
                    'url'  => 'planirovanie/vodoraspredeleniia',
                    'icon' => 'fas fa-minus',
                ],*/
            ],
        ],
        [
            'text'        => 'Водоподача',
            // 'url'         => 'vodopodacha/zhurnal',
            'url'         => 'modeli/qms',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'Расход и объем воды',
                    'url'  => 'modeli/qms',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Расход и объем воды в АВП',
                    'url'  => 'modeli/qwua',
                    'icon' => 'fas fa-minus',
                ],
                /*[
                    'text' => 'Журнал водопадачи',
                    'url'  => 'vodopodacha/zhurnal',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Акты водоподачи',
                    'url'  => 'vodopodacha/akty',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Балансовая ведемость',
                    'url'  => 'vodopodacha/vedemost',
                    'icon' => 'fas fa-minus',
                ],*/
            ],
        ],
        [
            'text'        => 'Гидропосты',
            'url'         => 'izmeriteli/table',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'Таблица координатов (Q)',
                    'url'  => 'modeli/qcordinate',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Уровень воды (H)',
                    'url'  => 'modeli/water-level',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Карта Гидропостов',
                    'url'  => 'izmeriteli/graph',
                    'icon' => 'fas fa-minus',
                ],
            ],
        ],
        [
            'text'        => 'Производительность',
            'url'         => 'spravochnik/orostelnye',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'Фактическая водопадача',
                    'url'  => 'planirovanie/vodopadachi',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Балансовая ведомость',
                    'url'  => 'planirovanie/vodoraspredeleniia',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Эффективность канала',
                    'url'  => 'planirovanie/effectivnost',
                    'icon' => 'fas fa-minus',
                ],
            ]
        ],
        /*[
            'text'        => 'Справочник',
            'url'         => 'spravochnik/orostelnye',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'Оростельные системы',
                    'url'  => 'spravochnik/orostelnye',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Гидроучастки',
                    'url'  => 'spravochnik/gidrouchastki',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Гидропосты',
                    'url'  => 'spravochnik/gidroposty-ruchnye',
                    'icon' => 'fas fa-plus',
                    'submenu' => [
                        [
                            'text' => 'Ручные',
                            'url'  => 'spravochnik/gidroposty-ruchnye',
                            'icon' => 'fas fa-minus',
                        ],
                        [
                            'text' => 'Автоматич. (Online)',
                            'url'  => 'spravochnik/gidroposty-avtomat',
                            'icon' => 'fas fa-minus',
                        ],
                    ],
                ],
                [
                    'text' => 'Каналы',
                    'url'  => 'spravochnik/kanaly',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Виды поливов',
                    'url'  => 'spravochnik/polivov',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Виды сельхозкультур',
                    'url'  => 'spravochnik/selkhozkultur',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Области',
                    'url'  => 'spravochnik/oblasti',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Районы ',
                    'url'  => 'spravochnik/raiony',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Хозяйства',
                    'url'  => 'spravochnik/khoziaistva',
                    'icon' => 'fas fa-minus',
                ],
            ],
        ],*/
        [
            'text'        => 'Справочник',
            'url'         => 'modeli/water-basin-zone',
            'icon'        => 'fab fa-pagelines',
            'submenu' => [
                [
                    'text' => 'Водные зоны бассейна',
                    'url'  => 'modeli/water-basin-zone',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Главные реки',
                    'url'  => 'modeli/main-river',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Озера',
                    'url'  => 'modeli/lake',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Водохранилища',
                    'url'  => 'modeli/reservoir',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Водосборные площади',
                    'url'  => 'modeli/catchment-area',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Каналы',
                    'url'  => 'modeli/canal',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Ирригация',
                    'url'  => 'modeli/irrigation',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Дренажная система',
                    'url'  => 'modeli/drainage',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Гидропосты',
                    'url'  => 'modeli/hydropost',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'АВП',
                    'url'  => 'modeli/wua',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Область',
                    'url'  => 'modeli/oblast',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Районы',
                    'url'  => 'modeli/region',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Крупные ГЭС',
                    'url'  => 'modeli/hydroelectric',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Малые ГЭС',
                    'url'  => 'modeli/smallhydroelectric',
                    'icon' => 'fas fa-minus',
                ],
                /*[
                    'text' => 'План водопользования',
                    'url'  => 'modeli/qtarget',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Запрос водопользования',
                    'url'  => 'modeli/qrequest',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Пользователи',
                    'url'  => 'modeli/user',
                    'icon' => 'fas fa-users',
                ],*/
                [
                    'text' => 'Карта АВП',
                    'url'  => 'izmeriteli/table',
                    'icon' => 'fas fa-minus',
                ],
            ],
        ],

        [
            'text'        => 'Администратор',
            'url'         => 'administrator',
            'icon'        => 'fas fa-users',
            'can'         => 'super-admin',
            'submenu' => [
                /*[
                    'text' => 'Организации',
                    'url'  => 'administrator/organizatsii',
                    'icon' => 'fas fa-minus',
                ],*/
                [
                    'text' => 'Пользователи',
                    'url'  => 'administrator/polzovateli',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'Роли',
                    'url'  => 'administrator/roli',
                    'icon' => 'fas fa-minus',
                ],
                [
                    'text' => 'История(Logs)',
                    'url'  => 'administrator/logs',
                    'icon' => 'fas fa-minus',
                ],
            ],
        ],
        /*['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'admin/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'url'  => 'admin/change-password',
            'icon' => 'fas fa-fw fa-lock',
        ],*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Configure which JavaScript plugins should be included. At this moment,
    | DataTables, Select2, Chartjs and SweetAlert are added out-of-the-box,
    | including the Javascript and CSS files from a CDN via script and link tag.
    | Plugin Name, active status and files array (even empty) are required.
    | Files, when added, need to have type (js or css), asset (true or false) and location (string).
    | When asset is set to true, the location will be output using asset() function.
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/libs/datatables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/libs/datatables.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/libs/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/libs/select2.min.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/libs/chart.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/libs/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/libs/pace.min.js',
                ],
            ],
        ],
    ],
];
