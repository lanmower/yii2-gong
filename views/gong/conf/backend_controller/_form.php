<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use devgroup\jsoneditor\Jsoneditor;
use yii\helpers\VarDumper;
use almagest\gong\models\Item;
use almagest\gong\components\DynamicRecord;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-form">

    <?php 
    $form = ActiveForm::begin();
    
    ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => 32])?>

    <?= $form->field($model, 'menu_link')->textarea()?>
    
    <?= $form->field($model, 'icon')->textarea()?>
    
    <?= Jsoneditor::widget(    [
        'editorOptions' => [
            'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
            'mode' => 'tree', // current mode
        ],
        'model'=>$model,
        'attribute' => 'json_settings', // input name. Either 'name', or 'model' and 'attribute' properties must be specified.
        'options' => [], // html options
    ])
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
