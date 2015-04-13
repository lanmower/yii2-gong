<?php
echo CHtml::openTag ( 'ul', array (
		'class' => 'GInlineEditableGallery' 
) );
foreach ( $model->imageFiles as $file ) {
	echo CHtml::openTag ( 'li', array (
			'class' => 'GPostFile-' . $file->hash 
	) );
	echo CHtml::link ( CHtml::image ( $file->getFileUrl ( "downloadImage", array (
			'type' => 's' 
	) ), 'File thumbnail' ), '', array (
			'onclick' => '$(this).parent().parent().parent().find("input").val("' . $file->getFileUrl ( "downloadImage/type/m" ) . '");$(this).parent().parent().parent().parent().find(".modal-footer").children()[1].click();' 
	) );
	echo CHtml::closeTag ( 'li' );
}
echo CHtml::closeTag ( 'ul' );
?>
