<?php
$list = array ();
$edit = Yii::app ()->user->can ( $file->file->edit );
if ($file->type == 'image') {
	$list [] = CHtml::image ( $file->fileUrl, '', array (
			'width' => $file->file->image->width,
			'height' => $file->file->image->height 
	) );
}
if ($file->type == 'video') {
	$list [] = CHtml::image ( $file->fileUrl, '', array (
			'width' => $file->file->image->width,
			'height' => $file->file->image->height 
	) );
}
if (isset ( $file->audio )) {
	$columns = array (
			array (
					'field' => 'name' 
			),
			array (
					'field' => 'value' 
			) 
	);
	$data = array (
			array (
					'name' => 'Track',
					'value' => CHtml::value ( $file, 'audio.track' ) 
			),
			array (
					'name' => 'Title',
					'value' => CHtml::value ( $file, 'audio.title' ) 
			),
			array (
					'name' => 'Artist',
					'value' => CHtml::value ( $file, 'audio.artist' ) 
			),
			array (
					'name' => 'Album',
					'value' => CHtml::value ( $file, 'audio.album' ) 
			),
			array (
					'name' => 'Year',
					'value' => CHtml::value ( $file, 'audio.year' ) 
			),
			array (
					'name' => 'Genre',
					'value' => CHtml::value ( $file, 'audio.genre' ) 
			),
			array (
					'name' => 'Comment',
					'value' => CHtml::value ( $file, 'audio.comment' ) 
			) 
	);
	$list [] = $this->widget ( 'GDataTable', array (
			'columns' => $columns,
			'data' => $data 
	), true );
} else {
	// $list .= $this->row('File name', 'filename', $file, true, '/gong/post/file/inlineUpdate');
}
if (! empty ( $list )) {
	echo CHtml::tag ( 'div', array (
			'class' => 'liveDialog' 
	), CHtml::tag ( 'div', array (
			'class' => 'fileDetails well PostFileDetails-' . $file->hash 
	), implode ( '\n', $list ) ) );
}
?>