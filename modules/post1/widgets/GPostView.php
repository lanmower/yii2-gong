<?php
class GPostView extends GTag {
	public $edit;
	public function init() {
		if (! $this->edit)
			$this->addClass ( 'published' );
		$this->addClass ( 'well' );
		if ($this->model->view == 'F')
			$this->addClass ( 'exclusive' );
		else if ($this->model->view == '*')
			$this->addClass ( 'published' );
		else
			$this->addClass ( 'unpublished' );
		$this->id = "GPostView-" . $this->model->hash;
		$this->addClass ( $this->id );
		parent::init ();
	}
	public static function mediaIcon($type, $icon, $post, $retlink = true) {
		$tmpName = "{$type}Files";
		$style = count ( $post->$tmpName ) ? '' : 'display:none';
		$count = count ( $post->$tmpName ) ? count ( $post->$tmpName ) : '';
		$content = CHtml::tag ( 'span', array (
				'class' => "{$tmpName}Icon $icon glyphicon-2x pull-left glyphicon glyphicon-border",
				'style' => $style 
		), CHtml::tag ( 'span', array (), $count ) );
		if (! $retlink)
			return $content;
		return CHtml::link ( $content, "/gong/post/post/fileList/id/{$post->hash}/type/$type", array (
				'class' => 'nohash' 
		) );
	}
	public static function coverImage($post) {
		$themePath = Yii::app ()->assetManager->publish ( 'themes/' . Yii::app ()->theme->name, false, - 1, YII_DEBUG );
		$coverFile = $post->coverImage;
		if (isset ( $coverFile )) {
			$image = $coverFile->getImage ( 'm' );
			if ($image) {
				echo CHtml::link ( CHtml::image ( '/gong/post/file/downloadImage/id/' . $coverFile->hash . '/type/' . $image->type, '', array (
						'class' => 'PostCover PostCover-' . $post->hash,
						'width' => $image->width,
						'height' => $image->height 
				) ), "/gong/post/post/fileList/id/{$post->hash}/type/image", array (
						'class' => 'nohash' 
				) );
			}
		} else {
			echo CHtml::image ( $themePath . '/images/post/postCoverDefault.png', '', array (
					'class' => 'PostCover PostCover-' . $post->hash 
			) );
		}
	}
	public function run() {
		echo GPostView::coverImage ( $this->model );

		
		$edit = false;
		if (Yii::app ()->user->can ( $this->model->edit ) || ($this->model->edit == "P" && Yii::app ()->user->id == $this->model->userId))
			$edit = true;
		
		if($edit) $this->render ( 'postView', array (
				'model' => $this->model,
				'id' => $this->id,
				'edit' => $edit,
				'published' => ! $this->edit 
		) );
		
		parent::run ();
	}
}

?>
