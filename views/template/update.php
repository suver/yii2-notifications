<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model suver\notifications\models\NotificationsTemplate */

$this->title = Yii::t('suver/notifications', 'Редактировать {modelClass}: ', [
        'modelClass' => 'Шаблон',
    ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('suver/notifications', 'Уведомления'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('suver/notifications', 'Спсиок шаблонов'), 'url' => ['template/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'key' => $model->key]];
$this->params['breadcrumbs'][] = Yii::t('suver/notifications', 'Редактировать');

\suver\notifications\assets\AppAsset::register($this);
?>
<div class="suver-notifications-template-update">

    <div class="box">
        <div class="box-header">

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>
