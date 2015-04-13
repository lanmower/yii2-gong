<?php
$list = GElementRenderer::renderElement ( $model, array (
		'search' => '',
		'publishedPosts' => false,
		'action' => '/gong/post/post/searchUploads',
		'searchInput' => false 
) );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => '.searchList' 
), $list );
?>
