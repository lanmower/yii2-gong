<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model almagest\gong\modules\view\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php
				
				$form = ActiveForm::begin ( [ 
						'action' => [ 
								'list' 
						],
						'method' => 'get' 
				] );
				?>

    <?= $form->field($model, 'id')?>

    <?= $form->field($model, 'className')?>

    <?= $form->field($model, 'json_settings')?>

    <?= $form->field($model, 'mode')?>

    <?= $form->field($model, 'prefix')?>

    <?php // echo $form->field($model, 'suffix') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'start') ?>

    <?php // echo $form->field($model, 'end') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
