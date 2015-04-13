<?php
if ($edit) {
	$this->widget ( 'GInlineEditable', array (
			'galleryUrl' => $this->controller->createUrl ( '/gong/post/post/gallery/id/' . $this->model->hash ),
			'pk' => $this->model->primaryKey,
			'htmlOptions' => array (
					'class' => 'contentEditor' 
			),
			'url' => '/gong/post/post/inlineUpdate',
			'name' => 'content',
			'value' => CHtml::value ( $this->model, 'content' ),
			'type' => 'editor',
			'id' => $this->id . '-contentEditor' 
	) );
} else {
	echo '<div class="nohijackLinks postContent postContent-' . $this->id . '">';
	echo CHtml::value ( $this->model, 'content' );
	echo '</div>';
}

?>
