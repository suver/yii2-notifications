<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model suver\notifications\models\NotificationsTemplate */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Уведомления'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Спсиок шаблонов'), 'url' => ['template/index']];
$this->params['breadcrumbs'][] = $this->title;

\suver\notifications\assets\AppAsset::register($this);
?>
<div class="book-notifications-template-view">

    <?php $widget = $module->dataViewWidget;
    echo $widget::widget([
        'model' => $model,
        'attributes' => [
            'key',
            'title',
            'subject',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => \suver\editor\TransformationWidget::widget(['message' => $model->description]),
            ],
            [
                'attribute' => 'params',
                'format' => 'raw',
                'value' => \suver\editor\TransformationWidget::widget(['message' => $model->params]),
            ],
            [
                'attribute' => 'template',
                'format' => 'raw',
                'value' => \suver\editor\TransformationWidget::widget(['message' => $model->template]),
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <div class="control">
        <?= Html::a(Yii::t('common', 'Редактировать'), ['update', 'key' => $model->key], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Удалить'), ['delete', 'key' => $model->key], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Вы уверены что хотите удалить эту запись?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
