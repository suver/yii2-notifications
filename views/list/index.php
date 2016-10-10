<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel suver\notifications\models\search\NotificationsTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Список');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Уведомления'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Отправленные'), 'url' => ['list/index']];
$this->params['breadcrumbs'][] = $this->title;

\suver\notifications\assets\AppAsset::register($this);
?>
<div class="book-notifications-template-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-header">
            <?= Html::a(Yii::t('common', 'Добавить шаблон'), ['create'], ['class' => 'btn btn-success']) ?>
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

                        <?php Pjax::begin(); ?>
                        <?php $widget = $module->gridViewWidget;
                        echo $widget::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'emptyText' => 'Уведомлений не отправленно',
                            'summary' => 'Показано <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b> {totalCount, plural, one{запись} other{записей}}',
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'id',
                                'user_id',
                                'subject',
                                'channel',
                                'user_id',
                                'viewed_at',
                                'created_at',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                ],
                            ],
                        ]); ?>
                        <?php Pjax::end(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>

