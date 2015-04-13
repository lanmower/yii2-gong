<?php
if (Yii::app ()->user->can ( $post->edit, $file->userId )) {
	echo CHtml::openTag ( 'td' );
	echo CHtml::link ( '', "/gong/post/file/delete/id/$file->hash", array (
			'class' => 'glyphicon glyphicon-remove prompt nohash' 
	) );
	CHtml::closeTag ( 'td' );
}
echo CHtml::tag ( 'td', array (), CHtml::value ( $file, 'filename' ) );
echo CHtml::openTag ( 'td', array () );
/*
 * echo CHtml::link(
 * CHtml::openTag('i', array('class' => 'glyphicon glyphicon-search')) . CHtml::closeTag('i'), $this->controller->createUrl('/gong/post/file/details/', array('id' => $file->hash)), array('onclick' => '$(".ui-dialog-titlebar-close").click();',
 * 'class' => 'nohash',
 * 'data-href' => $this->controller->createUrl('/gong/post/file/details/', array('id' => $file->hash))
 * ));
 */
echo CHtml::link ( '', "/gong/post/file/download/id/$file->hash", array (
		'class' => 'glyphicon glyphicon-download nohijack' 
) );
echo CHtml::closeTag ( 'td' );
?>
