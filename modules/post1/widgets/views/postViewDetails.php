<?php
echo CHtml::openTag ( 'div', array (
		'class' => 'postDetails' 
) );
echo '<br/>';
echo CHtml::openTag ( 'span', array (
		'class' => 'fileTypes' 
) );
echo GPostView::mediaIcon ( 'image', 'glyphicon glyphicon-picture', $model );
echo GPostView::mediaIcon ( 'video', 'glyphicon glyphicon-facetime-video', $model );
echo GPostView::mediaIcon ( 'audio', 'glyphicon glyphicon-music', $model );
echo GPostView::mediaIcon ( 'data', 'glyphicon glyphicon-file', $model );
echo CHtml::closeTag ( 'span' );

echo CHtml::closeTag ( 'div' );
?>
