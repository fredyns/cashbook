<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use fredyns\suite\filters\AdminLTELayout;

/**
 * This is the class for controller "CashflowController".
 */
class CashflowController extends \app\controllers\base\CashflowController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'layout' => [
                'class' => AdminLTELayout::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
}
