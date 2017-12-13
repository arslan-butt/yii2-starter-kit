<?php
/**
 * @var $this yii\web\View
 */
use backend\assets\BackendAsset;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
//use yii\helpers\Html;
$bundle = BackendAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
       
            <a href="<?php echo Yii::getAlias('@frontendUrl') ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo Yii::$app->name ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
         
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li id="timeline-notifications" class="notifications-menu hidden-xs">
                            <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                                <i class="fa fa-bell"></i>
                                <span class="label label-success">
                                    <?php echo TimelineEvent::find()->today()->count() ?>
                                </span>
                            </a>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li id="log-dropdown" class="dropdown notifications-menu hidden-xs">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl(['/log/view', 'id'=>$logEntry->id]) ?>">
                                                    <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                    <?php echo $logEntry->category ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <?php echo Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="user-image">
                                <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header light-blue">
                                    <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo Yii::$app->user->identity->username ?>
                                        <small>
                                            <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                        </small>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class'=>'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/site/settings'])?>
                        </li>
                    </ul>
                </div>
                <div class="hidden-xs">
                           <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],
                        'url' => ['/site/set-locale', 'locale'=>$code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
            ]]);
                ?>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo Yii::t('backend', 'Hello, {username}', ['username'=>Yii::$app->user->identity->getPublicIdentity()]) ?></p>
                        <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                            <i class="fa fa-circle text-success"></i>
                            <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?php echo Menu::widget([
                    'options'=>['class'=>'sidebar-menu'],
                    'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                    'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                    'activateParents'=>true,
                    'items'=>[
                        [
                            'label'=>Yii::t('backend', 'Main'),
                            'options' => ['class' => 'header']
                        ],
                        [
                            'label'=>Yii::t('backend', 'Dashboard'),
                            'icon'=>'<i class="fa fa-dashboard"></i>',
                            'url'=>['user/dashboard'],
                            'badge'=> TimelineEvent::find()->today()->count(),
                            'badgeBgClass'=>'label-success',
                        ],
                          [
                            'label'=>Yii::t('backend', 'Timeline'),
                            'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                            'url'=>['/timeline-event/index'],
                            'badge'=> TimelineEvent::find()->today()->count(),
                            'badgeBgClass'=>'label-success',
                        ],
                        [
                            'label'=>Yii::t('backend', 'Places'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-map-marker"></i>',
                            'url'=>['#'],
                            'visible'=>!Yii::$app->user->can('Sales Person')?true:false,
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview','id'=>''],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Regions'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Manage Regions'), 'url'=>['/regions/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'Add Region'), 'url'=>['/regions/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Cities'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Manage Cities'), 'url'=>['/city/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'Add City'), 'url'=>['/city/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Sections'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Manage Sections'), 'url'=>['/sections/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'Add Section'), 'url'=>['/sections/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'FDTs'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Manage FDTs'), 'url'=>['/fdts/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'Add FDT'), 'url'=>['/fdts/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Plates'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Manage Plates'), 'url'=>['/plates/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'Add Plate'), 'url'=>['/plates/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
//                                [
//                                    'label'=>Yii::t('backend', 'Plates Map'),
//                                    'url' => ['/maps/maps/'],
//                                    'icon'=>'<i class="fa fa-flag"></i>',
//                                    'options'=>['class'=>'treeview'],
////                                    'items'=>[
////                                        ['label'=>Yii::t('backend', 'Manage Plates'), 'url'=>['/i18n/i18n-source-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
////                                        ['label'=>Yii::t('backend', 'Add Plate'), 'url'=>['/i18n/i18n-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
////                                    ]
//                                ],
                        ],
                            ],
                         [
                            'label'=>Yii::t('backend', 'Projects'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-map-marker"></i>',
                            'url'=>['#'],
                             'visible'=>Yii::$app->user->can('manager'),
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview','id'=>''],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Create Project'),
                                    'url' => ['/projects/create/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Manage Project'),
                                    'url' => ['/projects/index/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                           ],
                         ],
                         [
                            'label'=>Yii::t('backend', 'My Tasks'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-map-marker"></i>',
                            'url'=>['#'],
                             'visible'=>Yii::$app->user->can('Sales Person'),
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Task List'),
                                    'url' => ['/tasks/index/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Task Map'),
                                    'url' => ['/maps/map-sale/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                           ],
                         ],
                         [
                            'label'=>Yii::t('backend', 'Tasks'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-map-marker"></i>',
                            'url'=>['#'],
                             'visible'=>Yii::$app->user->can('menu_task'),
//                             'visible'=>Yii::$app->user->can('Sales Person'),
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview','id'=>''],
                            'items'=>[
                                 [
                                    'label'=>Yii::t('backend', 'Manage Tasks'),
                                    'url' => ['/tasks/index/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                              
                                [
                                    'label'=>Yii::t('backend', 'Assign Task'),
                                    'url' => ['/maps/map-rmanager/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                     'visible'=>Yii::$app->user->can('Regional Manager'),
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Assign Task'),
                                    'url' => ['/maps/map-supervisor/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                     'visible'=>Yii::$app->user->can('Supervisor'),
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                               
                           ],
                         ],
                         [
                            'label'=>Yii::t('backend', 'QR Management'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-map-marker"></i>',
                            'url'=>['#'],
                             'visible'=>Yii::$app->user->can('manager'),
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview','id'=>''],
                            'items'=>[
                                 [
                                    'label'=>Yii::t('backend', 'QR Writer'),
                                    'url' => ['/qr-code/generator/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview','id'=>''],
                                ],
                           ],
                         ],
                      
                      
                        [
                            'label'=>Yii::t('backend', 'System'),
                            'options' => ['class' => 'header']
                        ],
                        [
                            'label'=>Yii::t('backend', 'Users'),
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['/user/index'],
                            'visible'=>Yii::$app->user->can('administrator')
                        
                        ],
                        [
                            'label'=>Yii::t('backend', 'Assign Region To RM'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['#'],
                             'visible'=>Yii::$app->user->can('manager'),
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'Assign Region'),
                                    'url' => ['/regional-manager/create/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Manage RM'),
                                    'url' => ['/regional-manager/index/'],
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                           ],
                         ],
                        
                        
                         [
                            'label'=>Yii::t('backend', 'Team Management'),
                            '<span class="pull-right-container"></span>',
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['#'],
                             'visible'=>!Yii::$app->user->can('Sales Person')?true:false,
                            'badgeBgClass'=>'label-success',
                             'options'=>['class'=>'treeview'],
                            'items'=>[
//                                [
//                                    'label'=>Yii::t('backend', 'Team'),
//                                    'url' => '#',
//                                    'icon'=>'<i class="fa fa-users"></i>',
//                                    'options'=>['class'=>'treeview'],
//                                    'items'=>[
//                                        ['label'=>Yii::t('backend', 'Manage Team'), 'url'=>['/team/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                        ['label'=>Yii::t('backend', 'Add Team'), 'url'=>['/team/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                    ]
//                                ],
                                [
                                    'label'=>Yii::t('backend', 'Add Team'),
                                    'url' => ['/team/create'],
                                    'icon'=>'<i class="fa fa-users"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Manage Team'),
                                    'url' => ['/team/index'],
                                    'icon'=>'<i class="fa fa-users"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
//                                [
//                                    'label'=>Yii::t('backend', 'Assign Team'),
//                                    'url' => ['/team-users/create'],
//                                    'icon'=>'<i class="fa fa-users"></i>',
//                                    'options'=>['class'=>'treeview'],
//                                ],
                                [
                                    'label'=>Yii::t('backend', 'Assign Supervisor'),
                                    'url' => ['/team-users/assign-supervisor'],
                                    'icon'=>'<i class="fa fa-users"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                                
                                [
                                    'label'=>Yii::t('backend', 'Assign Sales Person'),
                                    'url' => ['/team-users/assign-salesperson'],
                                    'icon'=>'<i class="fa fa-users"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
                             
                                [
                                    'label'=>Yii::t('backend', 'Manage Assigned Team'),
                                    'url' => ['/team-users/index'],
                                    'icon'=>'<i class="fa fa-users"></i>',
                                    'options'=>['class'=>'treeview'],
                                ],
//                                [
//                                    'label'=>Yii::t('backend', 'Assign Team'),
//                                    'url' => '#',
//                                    'icon'=>'<i class="fa fa-users"></i>',
//                                    'options'=>['class'=>'treeview'],
//                                    'items'=>[
//                                        ['label'=>Yii::t('backend', 'Manage Assign Team'), 'url'=>['/team-users/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                        ['label'=>Yii::t('backend', 'Assign Team'), 'url'=>['/team-users/create'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
//                                    ]
//                                ],
                              
//                               
                        ],
                            ],
                        [
                            'label'=>Yii::t('backend', 'Other'),
                            'url' => '#',
                            'visible'=>Yii::$app->user->can('manager') || Yii::$app->user->can('administrator'),
                            'icon'=>'<i class="fa fa-cogs"></i>',
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'i18n'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'i18n Source Message'), 'url'=>['/i18n/i18n-source-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'i18n Message'), 'url'=>['/i18n/i18n-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                ['label'=>Yii::t('backend', 'Key-Value Storage'), 'url'=>['/key-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Storage'), 'url'=>['/file-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Cache'), 'url'=>['/cache/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Manager'), 'url'=>['/file-manager/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'System Information'),
                                    'url'=>['/system-information/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Logs'),
                                    'url'=>['/log/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=>\backend\models\SystemLog::find()->count(),
                                    'badgeBgClass'=>'label-danger',
                                ],
                            ],
                             
                        ],
                        [
                            'label'=>Yii::t('backend', 'RBAC Management'),
                            'options' => ['class' => 'header'],
                            'visible'=>Yii::$app->user->can('manager') || Yii::$app->user->can('administrator'),
                            
                        ],
                         [
                            'label'=>Yii::t('backend', 'RBAC Dashbaord'),
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['/admin/'],
                            'visible'=>Yii::$app->user->can('manager') || Yii::$app->user->can('administrator')
                        
                        ],
                    ]
                ])                     
                       
                        ?>
                 <?php  //echo $this->render('../../../vendor/mdmsoft/yii2-admin/views/layouts/left-menu.php');
//     $controller=$this->context;
//     $menus = $controller->module->menus;
//     $route = $controller->route;
//     foreach ($menus as $i => $menu) {
//    $menus[$i]['active'] = strpos($route, trim($menu['url'][0], '/')) === 0;
//}
//$this->params['nav-items'] = $menus;
//foreach ($menus as $menu) {
//                $label = Html::tag('i', '', ['class' => 'fa fa-angle-double-right']) .
//                    Html::tag('span', Html::encode($menu['label']), []);
//                $active = $menu['active'] ? ' active' : '';
//                echo Html::a($label, $menu['url'], [
//                    'class' => 'list-group-item' . $active,
//                ]);
//            
//                
//}
//                list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');
//$this->registerCssFile($url . '/list-item.css');

            ?>
                
                
                
                
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?php echo $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>

                <?php echo Breadcrumbs::widget([
                    'tag'=>'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if (Yii::$app->session->hasFlash('alert')):?>
                    <?php echo \yii\bootstrap\Alert::widget([
                        'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                        'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                    ])?>
                <?php endif; ?>
                <?php echo $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    
    
      
<?php $this->endContent(); ?>
