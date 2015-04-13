<?php
class GPostFileList extends CWidget {
	public $post;
	public $type;
	public function run() {
		$count = 0;
		if ($this->type == 'audio' && count ( $this->post->audioFiles )) {
			echo CHtml::openTag ( 'div', array (
					'class' => 'GPostAudioFiles' 
			) );
			echo CHtml::tag ( 'i', array (
					'class' => 'glyphicon glyphicon-play glyphicon-2x playAll',
					'onclick' => '$(this).parent().find(".playButton").click(); $(".jp-play").click();' 
			), '<span>All</span>' );
			echo CHtml::openTag ( 'table', array (
					'class' => 'table' 
			) );
			echo CHtml::openTag ( 'tr' );
			echo CHtml::Tag ( 'th', array (), '' );
			echo CHtml::Tag ( 'th', array (), 'Artist' );
			echo CHtml::Tag ( 'th', array (), 'Title' );
			echo CHtml::closeTag ( 'tr' );
			foreach ( $this->post->audioFiles as $file ) {
				$fileId = 'GPostFile-' . $file->hash;
				echo CHtml::openTag ( 'tr', array (
						'class' => $fileId 
				) );
				echo $this->render ( 'gong.modules.post.views.file._audio', array (
						'file' => $file,
						'post' => $this->post 
				), true );
				echo CHtml::closeTag ( 'tr' );
				++ $count;
			}
			echo CHtml::closeTag ( 'table' );
			echo CHtml::closeTag ( 'div' );
		}
		if ($this->type == 'image' && count ( $this->post->imageFiles )) {
			echo CHtml::openTag ( 'ul', array (
					'class' => 'GPostImageFiles' 
			) );
			foreach ( $this->post->imageFiles as $file ) {
				$fileId = 'GPostFile-' . $file->hash;
				echo CHtml::openTag ( 'li', array (
						'class' => $fileId 
				) );
				echo $this->render ( 'gong.modules.post.views.file._image', array (
						'file' => $file,
						'post' => $this->post 
				), true );
				echo CHtml::closeTag ( 'li' );
				++ $count;
			}
			echo CHtml::closeTag ( 'ul' );
		}
		if ($this->type == 'video' && count ( $this->post->videoFiles )) {
			echo CHtml::openTag ( 'table', array (
					'class' => 'GPostVideoFiles table' 
			) );
			echo CHtml::openTag ( 'tr' );
			echo CHtml::Tag ( 'th', array (), 'Title' );
			echo CHtml::closeTag ( 'tr' );
			foreach ( $this->post->videoFiles as $file ) {
				$fileId = 'GPostFile-' . $file->hash;
				echo CHtml::openTag ( 'tr', array (
						'class' => $fileId 
				) );
				echo $this->render ( 'gong.modules.post.views.file._video', array (
						'file' => $file,
						'post' => $this->post 
				), true );
				echo CHtml::closeTag ( 'tr' );
				++ $count;
			}
			echo CHtml::closeTag ( 'table' );
		}
		if ($this->type == 'data' && count ( $this->post->dataFiles )) {
			echo CHtml::openTag ( 'table', array (
					'class' => 'GPostDataFiles table' 
			) );
			foreach ( $this->post->dataFiles as $file ) {
				$fileId = 'GPostFile-' . $file->hash;
				echo CHtml::openTag ( 'tr', array (
						'class' => $fileId 
				) );
				echo $this->render ( 'gong.modules.post.views.file._data', array (
						'file' => $file,
						'post' => $this->post 
				), true );
				echo CHtml::closeTag ( 'tr' );
				++ $count;
			}
			echo CHtml::closeTag ( 'table' );
		}
	}
}

?>
