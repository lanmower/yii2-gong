<?php
if ($edit) {
	if (empty ( $model->title ))
		$model->title = 'Click here to enter a title';
	if (empty ( $model->summary ))
		$model->summary = 'Click here enter a brief summary';
	if (empty ( $model->content ))
		$model->content = 'Click here enter a post content';
	$this->widget ( 'GInlineEditable', array (
			'pk' => $model->primaryKey,
			'htmlOptions' => array (
					'id' => $id . '-titleEditor',
					'class' => 'titleEditor' 
			),
			'url' => '/gong/post/post/inlineUpdate',
			'name' => 'title',
			'value' => CHtml::value ( $model, 'title' ),
			'type' => 'text' 
	) );
	echo '<br/>';
	$this->widget ( 'GInlineEditable', array (
			'pk' => $model->primaryKey,
			'htmlOptions' => array (
					'id' => $id . '-summayEditor',
					'class' => 'summaryEditor' 
			),
			'url' => '/gong/post/post/inlineUpdate',
			'name' => 'summary',
			'value' => CHtml::value ( $model, 'summary' ),
			'type' => 'text' 
	) );
} else {
	echo CHtml::tag ( 'h2', array (), CHtml::value ( $this->model, 'title' ) );
	echo '<br/>';
	echo CHtml::value ( $this->model, 'summary' );
}
?>
