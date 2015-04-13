<?php
if ($file->processed)
	echo CHtml::image ( '/gong/post/file/downloadImage/type/s/id/' . $file->hash, 'File thumbnail', array (
			'width' => $file->getImage ( 's' )->width,
			'height' => $file->getImage ( 's' )->height 
	) );
else
	echo CHtml::tag ( 'span', array (
			"class" => "alert alert-info" 
	), "Queued for processing." );

echo CHtml::openTag ( 'span', array (
		'class' => 'controls' 
) );
if (Yii::app ()->user->can ( $post->edit, $file->userId )) {
	echo CHtml::link ( '', "/gong/post/file/delete/id/$file->hash", array (
			'class' => 'glyphicon glyphicon-remove prompt nohash' 
	) );
	echo CHtml::link ( '', "/gong/post/post/setCover/id/{$post->hash}/coverId/$file->hash", array (
			'class' => 'glyphicon glyphicon-star prompt' 
	) );
}
echo CHtml::link ( CHtml::openTag ( 'i', array (
		'class' => 'glyphicon glyphicon-search' 
) ) . CHtml::closeTag ( 'i' ), $this->controller->createUrl ( '/gong/post/file/details/', array (
		'id' => $file->hash 
) ), array (
		'class' => 'nohash',
		'data-href' => $this->controller->createUrl ( '/gong/post/file/details/', array (
				'id' => $file->hash 
		) ) 
) );
echo CHtml::closeTag ( 'span' );
?>