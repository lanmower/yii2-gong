<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\Post */
/* @var $model almagest\gong\modules\post\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">

    <?php
				
				$form = ActiveForm::begin ( [ 
						'action' => [ 
								'list' 
						],
						'method' => 'get' 
				] );
				?>

    <?= $form->field($model, 'id')?>

    <?= $form->field($model, 'name')?>

    <?= $form->field($model, 'layout')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
