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
<div class="suver-notifications-template-view">

    <div class="box">
        <div class="box-header">
            <?= Html::a(Yii::t('common', 'Редактировать'), ['update', 'key' => $model->key], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('common', 'Удалить'), ['delete', 'key' => $model->key], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Вы уверены что хотите удалить эту запись?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

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

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>
