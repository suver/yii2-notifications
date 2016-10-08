<?php

namespace suver\notifications;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'suver\notifications\controller';

    public $menu = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'suver\notifications\commands';
        }

        /*$this->menu = [
            [
                'label' => '<i class="fa fa-home"></i> Загруженые файлы',
                'url' => ['/books'],
                'alias' => ['uploads'],
                'items' => [
                    [
                        'label' => 'Каталог книг',
                        'url' => ['/uploads/list'],
                        'alias' => ['uploads/list'],
                    ],
                ],
            ],
        ];*/

        // инициализация модуля с помощью конфигурации, загруженной из config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));

        // custom initialization code goes here
    }
}
