<?php
echo CHtml::openTag ( 'div', array (
		'class' => 'replace',
		'target' => '.PostCover-' . $model->hash 
) );
echo GPostView::coverImage ( $model );
echo CHtml::closeTag ( 'div' );
echo CHtml::openTag ( 'div', array (
		'class' => 'liveDialog' 
) );
echo "Cover art updated.";
echo CHtml::closeTag ( 'div' );
?>
