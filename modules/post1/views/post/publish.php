<?php
Yii::app ()->clientScript->registerScript ( "createDone-" . $model->hash, '
                            $(".GPostCreator input").val("");
                            $(".SearchUploads form input").val("");
    ' );
Yii::import ( "gong.modules.site.models.*" );
$model = GSitePageElement::model ()->find ( "name = 'search_uploads_list'" );
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

$model = GSitePageElement::model ()->find ( "name = 'search_uploads_list'" );
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

$model = GSitePageElement::model ()->find ( "name = 'search_uploads_list'" );
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

$model = GSitePageElement::model ()->find ( "name = 'search_published'" );
$list = GElementRenderer::renderElement ( $model, array (
		'search' => '',
		'publishedPosts' => false,
		'action' => '/gong/post/post/search',
		'searchInput' => false
) );
echo CHtml::tag ( 'div', array (
		'class' => 'replace',
		'target' => 'search_published'
), $list );
?>