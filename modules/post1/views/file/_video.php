<?php
$video = $file->video;
echo "<td>$file->filename</td>";
if (Yii::app ()->user->can ( $post->edit, $file->userId )) {
	echo CHtml::openTag ( 'td' );
	echo CHtml::link ( '', "/gong/post/file/delete/id/$file->hash", array (
			'class' => 'glyphicon glyphicon-remove prompt nohash' 
	) );
	echo CHtml::closeTag ( 'td' );
}
echo CHtml::openTag ( 'td' );
echo CHtml::link ( CHtml::openTag ( 'i', array (
		'class' => 'glyphicon glyphicon-search' 
) ) . CHtml::closeTag ( 'i' ), $this->controller->createUrl ( '/gong/post/file/details/', array (
		'id' => $file->hash 
) ), array (
		'onclick' => '$(".ui-dialog-titlebar-close").click();',
		'class' => 'nohash',
		'data-href' => $this->controller->createUrl ( '/gong/post/file/details/', array (
				'id' => $file->hash 
		) ) 
) );
echo CHtml::closeTag ( 'td' );
$videoFile = array (
		'title:"' . $file->filename . '",',
		'm4v:"/gong/post/file/downloadM4v/id/' . $file->hash . '",' 
);
if ($post->coverImageId) {
	$videoFile [] = 'poster:"/gong/post/file/downloadImage/id/' . PseudoCrypt::hash ( $post->coverImage->id ) . '/type/s"';
} else {
	$videoFile [] = 'poster:"/themes/base/images/post/postCoverDefault.png"';
}

if ($file->processed) {
	echo CHtml::tag ( 'td', array (), CHtml::link ( 'Play', "", array (
			'class' => "nohijack playButton",
			'onclick' => "$('html, body').animate({ scrollTop: 0 }, 'slow'); $('.ui-dialog-titlebar-close').click();$('.jp-volume, .jp-controls, .jp-progress, .jp-playlist').css({display:'inline-block'}); $.alm.player.add({" . implode ( "\n", $videoFile ) . "}, true); $.alm.player.play();" 
	) ) );
	echo CHtml::tag ( 'td', array (), CHtml::link ( 'Queue', "", array (
			'class' => 'nohijack queueButton',
			'onclick' => "$('.jp-volume, .jp-controls, .jp-progress, .jp-playlist').css({display:'inline-block'}); $.alm.player.add({" . implode ( "\n", $videoFile ) . "});" 
	) ) );
} else
	echo CHtml::tag ( 'td', array (
			"colspan" => 2 
	), CHtml::tag ( 'span', array (
			"class" => "alert-info" 
	), "Queued for processing." ) );
?>
