<?php
Yii::import ( "gong.modules.post.models.GPost" );
class GPostSearch extends GTag {
	public $searchInput = true;
	public $publishedPosts = false;
	public $search = '';
	public $partial = false;
	public $searchInputOptions = array ();
	public $searchListOptions = array ();
	public $target;
	public $action;
	public function init() {
		if ($this->partial) {
			$this->registerScripts ();
			echo $this->text;
		} else
			parent::init ();
	}
	public function run() {
		if (! isset ( $this->action )) {
			$action = '/gong/post/post/search';
		} else
			$action = $this->action;
		
		if ($this->searchInput) {
			echo CHtml::openTag ( 'div', array (
					'class' => 'inline GPostSearch-controls' 
			) );
			if (! $this->publishedPosts) {
				echo CHtml::beginForm ( '/gong/post/post/create', 'post', array (
						'class' => 'postCreator',
						'id' => 'PostCreationForm-' . $this->hash 
				) ) . CHtml::hiddenField ( 'GPost[title]', '' ) . BsHtml::submitButton ( "Create", array (
						'class' => 'btn btn-default' 
				) ) . CHtml::endForm ();
			}
			echo BsHtml::searchForm ( $action, 'get', array_merge_recursive ( array (
					'inputOptions' => array (
							'id' => 'searchInput-' . $this->hash,
							'value' => $this->search 
					),
					'id' => 'searchForm-' . $this->hash,
					'class' => 'searchForm targetForm',
					'data-target' => '.GPostSearch-' . $this->hash . ' .searchList' 
			), $this->searchInputOptions ) );
			echo CHtml::closeTag ( 'div' );
		}
		
		echo CHtml::openTag ( 'div', array_merge_recursive ( array (
				'class' => 'searchList',
				'id' => $this->id . '-searchList' 
		), $this->searchListOptions ) );
		$criteria = new CDbCriteria ();
		
		if ($this->publishedPosts) {
			$criteria->mergeWith ( array (
					'condition' => 't.view = "*" OR ' . '(t.view = "F" AND ((friendshipsAccepted.inviterId = :userId OR friendshipsRequested.friendId = :userId) OR t.userId =  :userId ))',
					'params' => array (
							':userId' => Yii::app ()->user->id 
					),
					'with' => array (
							'user',
							'user.friendshipsAccepted',
							'user.friendshipsRequested' 
					) 
			) );
			if (! Yii::app ()->user->can ( 'Reporter' ))
				$criteria->mergeWith ( array (
						'condition' => 't.userId = ' . Yii::app ()->user->id 
				) );
		} else {
			$criteria->addCondition ( array (
					't.view = "P"' 
			), "AND" );
			$criteria->mergeWith ( array (
					'condition' => 't.userId = ' . Yii::app ()->user->id 
			) );
		}
		// echo $this->search;
		
		if (! empty ( $this->search )) {
			if (strpos ( $this->search, '#' ) === 0) {
				$this->search = PseudoCrypt::unhash ( ltrim ( $this->search, '#' ) );
				$criteria->compare ( array (
						't.id' => "$this->search" 
				) );
			} else {
				$criteria->mergeWith ( array (
						'condition' => "MATCH (t.title) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (t.summary) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (t.content) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (files.filename) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.title) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.artist) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.album) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.year) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.comment) AGAINST (:search IN BOOLEAN MODE) OR " . "MATCH (audio.genre) AGAINST (:search IN BOOLEAN MODE)",
						'params' => array (
								':search' => "*$this->search*" 
						),
						'with' => array (
								'files',
								'files.audio' 
						) 
				) );
			}
		}
		$criteria->order = "t.created DESC";
		$criteria->limit = 5;
		if (isset ( $_GET ['offset'] ))
			$criteria->offset = $_GET ['offset'];
		$posts = GPost::model ()->findAll ( $criteria );
		if (isset ( $posts ))
			foreach ( $posts as $post ) {
				echo $this->widget ( 'GPostView', array (
						'model' => $post,
						'edit' => (! $this->publishedPosts) 
				), true );
			}
		echo CHtml::closeTag ( 'div' );
		if (count ( $posts ) == 5) {
			$offset = isset ( $_GET ['offset'] ) ? '/offset/' . ($_GET ['offset'] + 5) : '/offset/5';
			$search = ! empty ( $this->search ) ? '?search=' . $this->search : '';
			echo CHtml::link ( CHtml::openTag ( 'i', array (
					'class' => "glyphicon glyphicon-plus-sign glyphicon-2x" 
			) ) . CHtml::closeTag ( 'i' ), '#' . $this->id . '-searchList', array (
					'class' => "$this->id-more visibleclick nohash targetlink appendToTarget",
					'onclick' => '$(this).remove()',
					'data-href' => $action . $search . $offset 
			) );
		}
		if (! $this->partial)
			parent::run ();
	}
}

?>
