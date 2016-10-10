<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model suver\notifications\models\NotificationsTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-notifications-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\suver\editor\Editor::className(), []); ?>

    <?= $form->field($model, 'params')->widget(\suver\editor\Editor::className(), []); ?>

    <?= $form->field($model, 'template')->widget(\suver\editor\Editor::className(), []); ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'bind')->checkbox(['maxlength' => true]) ?>


    <?php // echo  $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Добавить') : Yii::t('common', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
