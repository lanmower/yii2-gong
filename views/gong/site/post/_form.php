<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\web\JsExpression;
use almagest\gong\widgets\Upload;
use almagest\gong\widgets\ChildGrid;
use almagest\gong\widgets\SirTrevor;
use almagest\gong\widgets\SirGong;
use yii\helpers\Url;

/* @var $this yii\web\post */
/* @var $model almagest\gong\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255])?>
	<?= Upload::widget(['model'=>$model,'url'=>['upload', 'parent'=>$model->id]]); ?>
    <?php
		if (isset ( $model->_conf ['behaviors'] ['children'] )) {
			$className = $model->_conf ['behaviors'] ['children'] ['className'];
			echo ChildGrid::widget ( [ 
				'model' => $model 
			] );
		}
	?>    
	<?= $form->field($model, 'content')->widget(SirGong::className(), [ 'imageUploadUrl'=>'sirTrevorUpload']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
