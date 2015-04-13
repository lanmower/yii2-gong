<?php
$audio = $file->audio;
$artist = isset ( $audio ) ? $audio->artist : '';
$title = isset ( $audio ) ? $audio->title : '';

if (Yii::app ()->user->can ( $post->edit, $file->userId )) {
	echo CHtml::openTag ( 'td' );
	echo CHtml::link ( '', "/gong/post/file/delete/id/$file->hash", array (
			'class' => 'glyphicon glyphicon-remove prompt nohash' 
	) );
	echo CHtml::closeTag ( 'td' );
}
echo CHtml::tag ( 'td', array (), $artist );
echo CHtml::tag ( 'td', array (), $title );
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
$song = array (
		'title:"' . $title . '",',
		'artist:"' . $artist . '",',
		'mp3:"/gong/post/file/downloadMp3/id/' . $file->hash . '",',
		'oga:"/gong/post/file/downloadOgg/id/' . $file->hash . '",',
		'm4a:"/gong/post/file/downloadM4a/id/' . $file->hash . '",' 
);
if ($post->coverImageId) {
	$song [] = 'poster:"/gong/post/file/downloadImage/id/' . PseudoCrypt::hash ( $post->coverImage->id ) . '/type/l"';
} else {
	$song [] = 'poster:"/themes/base/images/post/postCoverDefault.png"';
}

if ($file->processed) {
	echo CHtml::tag ( 'td', array (), CHtml::link ( '', "", array (
			'class' => "nohijack playButton glyphicon glyphicon-play",
			'onclick' => "$('.jp-volume, .jp-controls, .jp-progress, .jp-playlist').css({display:'inline-block'}); $.alm.player.add({" . implode ( "\n", $song ) . ", playNow: true}); $.alm.player.play();" 
	) ) );
} else
	echo CHtml::tag ( 'td', array (
			"colspan" => 2 
	), CHtml::tag ( 'span', array (
			'alert-info' 
	), "Queued for processing." ) );
?>
