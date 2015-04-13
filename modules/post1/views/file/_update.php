<?php
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => ".GPostView-{$post->hash} .imageFilesIcon" 
), GPostView::mediaIcon ( 'image', 'glyphicon glyphicon-picture', $post, false ) );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => ".GPostView-{$post->hash} .audioFilesIcon" 
), GPostView::mediaIcon ( 'audio', 'glyphicon glyphicon-music', $post, false ) );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => ".GPostView-{$post->hash} .dataFilesIcon" 
), GPostView::mediaIcon ( 'data', 'glyphicon glyphicon-file', $post, false ) );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => ".GPostView-{$post->hash} .videoFilesIcon" 
), GPostView::mediaIcon ( 'video', 'glyphicon glyphicon-facetime-video', $post, false ) );
if (count ( $post->imageFiles ) == 0)
	Yii::app ()->clientscript->registerScript ( 'postFileUpdate-' . $post->hash . '-imageDialogClose', '$(".imagedialog-' . $post->hash . ' .ui-dialog-titlebar-close").click();' );
if (count ( $post->audioFiles ) == 0)
	Yii::app ()->clientscript->registerScript ( 'postFileUpdate-' . $post->hash . '-audioDialogClose', '$(".audiodialog-' . $post->hash . ' .ui-dialog-titlebar-close").click();' );
if (count ( $post->dataFiles ) == 0)
	Yii::app ()->clientscript->registerScript ( 'postFileUpdate-' . $post->hash . '-dataDialogClose', '$(\'.datadialog-' . $post->hash . ' .ui-dialog-titlebar-close\').click();' );
if (count ( $post->videoFiles ) == 0)
	Yii::app ()->clientscript->registerScript ( 'postFileUpdate-' . $post->hash . '-videoDialogClose', '$(\'.videodialog-' . $post->hash . ' .ui-dialog-titlebar-close\').click();' );
	// if(!isset($noList)) {
$replace = $this->widget ( 'GPostFileList', array (
		'post' => $post,
		'type' => 'image' 
), true );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => '.PostFileGroup-' . $post->hash . ' .GPostImageFiles' 
), $replace );
// }
// if(!isset($noList)) {
$replace = $this->widget ( 'GPostFileList', array (
		'post' => $post,
		'type' => 'audio' 
), true );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => '.PostFileGroup-' . $post->hash . ' .GPostAudioFiles' 
), $replace );
// }
// if(!isset($noList)) {
$replace = $this->widget ( 'GPostFileList', array (
		'post' => $post,
		'type' => 'data' 
), true );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => '.PostFileGroup-' . $post->hash . ' .GPostDataFiles' 
), $replace );

$replace = $this->widget ( 'GPostFileList', array (
		'post' => $post,
		'type' => 'video' 
), true );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => '.PostFileGroup-' . $post->hash . ' .GPostVideoFiles' 
), $replace );
// }

?>