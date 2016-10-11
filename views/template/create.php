<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model suver\notifications\models\NotificationsTemplate */

$this->title = Yii::t('common', 'Добавить шаблон');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Уведомления'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Спсиок шаблонов'), 'url' => ['template/index']];
$this->params['breadcrumbs'][] = $this->title;

\suver\notifications\assets\AppAsset::register($this);
?>
<div class="suver-notifications-template-create">


    <div class="box">
        <div class="box-header">

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

