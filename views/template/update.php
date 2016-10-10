<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model suver\notifications\models\NotificationsTemplate */

$this->title = Yii::t('common', 'Редактировать {modelClass}: ', [
        'modelClass' => 'Шаблон',
    ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Уведомления'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Спсиок шаблонов'), 'url' => ['template/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'key' => $model->key]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Редактировать');

\suver\notifications\assets\AppAsset::register($this);
?>
<div class="book-notifications-template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
