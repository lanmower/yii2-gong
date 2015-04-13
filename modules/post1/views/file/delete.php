<?php
Yii::app ()->clientScript->registerScript ( 'modelDelete-' . $model->hash, "$('.Gmodel-$model->hash').remove();" );
if ($model->post->coverId == $model->id || count ( $model->post->imageFiles ) == 0 && $model->type == 'image')
	$this->renderPartial ( 'gong.modules.post.views.post.setCover', array (
			'model' => $model->post 
	) );
$this->renderPartial ( '_update', array (
		'post' => $model->post 
) );
?>
