<?php

namespace suver\notifications;
use yii\base\BootstrapInterface;
use Yii;

/**
 * user module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'suver\notifications\controllers';

    public $dataViewWidget = '\yii\widgets\DetailView';
    public $gridViewWidget = '\yii\grid\GridView';

    public $defaultNotificationsTemplatePerPage = 25;

    public $defaultNotificationsPerPage = 25;

    public $menu = [];

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>', 'route' => $this->id . '/<controller>/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>/<id:[\d]+>', 'route' => $this->id . '/<controller>/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>/<action:[\w-]+>', 'route' => $this->id . '/<controller>/<action>'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/template/<action:[\w-]+>/<key:[\w-_]+>', 'route' => $this->id . '/template/<action>'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/template/<key:[\w-_]+>', 'route' => $this->id . '/template/view'],
            ], false);
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'suver\notifications\commands';

            /*$app->controllerMap[$this->id] = [
                'class' => 'yii\gii\console\GenerateController',
                'generators' => array_merge($this->coreGenerators(), $this->generators),
                'module' => $this,
            ];*/
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // инициализация модуля с помощью конфигурации, загруженной из config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));

        if(empty($this->menu)) {
            $this->menu = [
                [
                    'label' => 'Уведомления',
                    'icon' => 'fa fa-home',
                    'url' => ['/' . $this->id],
                    'alias' => [$this->id],
                    'items' => [
                        [
                            'label' => 'Рассылка',
                            'url' => ['/' . $this->id . '/default'],
                            'alias' => [$this->id . '/default'],
                        ],
                        [
                            'label' => 'Отправленные',
                            'url' => ['/' . $this->id . '/list'],
                            'alias' => [$this->id . '/list'],
                        ],
                        [
                            'label' => 'Шаблоны',
                            'url' => ['/' . $this->id . '/template'],
                            'alias' => [$this->id . '/template'],
                        ],
                    ],
                ],
            ];
        }


        // custom initialization code goes here
    }
}
