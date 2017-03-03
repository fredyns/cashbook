<?php

use yii\helpers\Html;
use yii\helpers\Url;
use fredyns\suite\helpers\ActiveUser;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image img-circle" style="overflow: hidden">

                <?php
                $profile = Yii::$app->user->identity->profile;

                if (!empty($profile->picture_id)) {
                    echo Html::img(
                        ['/file', 'id' => $profile->picture_id],
                        [
                        'class' => '',
                        'alt' => $profile->user->username,
                        'style' => 'max-length: 45px; max-width: 45px;',
                        ]
                    );
                } else {
                    echo Html::img('@web/image/user-160.png', ['class' => "img-circle", 'alt' => "User Image"]);
                }
                ?>
            </div>
            <div class="pull-left info">
                <p>
                    <?php
                    $name = Yii::$app->user->identity->profile->name;
                    $label = empty($name) ? Yii::$app->user->identity->username : $name;

                    echo Html::a($label, ['/user/settings/profile']);
                    ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?= Url::to(['/site/search']) ?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input
                    type="text"
                    name="sitesearch"
                    class="form-control"
                    placeholder="<?= Yii::t('app', 'Search') ?>..."
                    value="<?= Yii::$app->request->get('sitesearch'); ?>"
                    />
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
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Transaction'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Cashflow'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/cashflow'],
                    ],
                    [
                        'label' => Yii::t('app', 'Monthly Book'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Monthly Budget Item'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/monthly-budget-item'],
                    ],
                    [
                        'label' => Yii::t('app', 'Master'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Account'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/account'],
                    ],
                    [
                        'label' => Yii::t('app', 'Budget Item'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/budget-item'],
                    ],
                    [
                        'label' => Yii::t('app', 'Cashflow Type'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/cashflow-type'],
                    ],
                    [
                        'label' => 'Administrator',
                        'visible' => ActiveUser::isAdmin(),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => 'User Management',
                        'visible' => ActiveUser::isAdmin(),
                        'encode' => FALSE,
                        'icon' => 'fa fa-user',
                        'url' => ['/user/admin'],
                    ],
                    [
                        'label' => 'Development',
                        'options' => ['class' => 'header'],
                        'visible' => YII_DEBUG,
                    ],
                    [
                        'label' => 'Yii2',
                        'visible' => YII_DEBUG,
                        'icon' => 'fa fa-gears',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                        ],
                    ],
                ],
            ]
        )
        ?>

    </section>

</aside>
