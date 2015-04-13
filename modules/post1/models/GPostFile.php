<?php
class GPostFile extends GActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return '{{post_file}}';
	}
	public function behaviors() {
		return array (
				'DeleteChildren' => array (
						'class' => 'GDeleteChildrenBehavior',
						'childAttributes' => array (
								'file' 
						) 
				) 
		);
	}
	public function getFileUrl($action = "download", $additionals = array()) {
		return Yii::app ()->getController ()->createUrl ( "/gong/post/file/{$action}", array_merge ( array (
				'id' => $this->file->hash 
		), $additionals ) );
	}
	public function rules() {
		return array (
				array (
						'postId',
						'numerical',
						'integerOnly' => true 
				) 
		);
	}
	public function relations() {
		return array (
				'file' => array (
						self::BELONGS_TO,
						'GFile',
						'fileId',
						'together' => true 
				),
				'post' => array (
						self::BELONGS_TO,
						'GPost',
						'postId' 
				) 
		);
	}
	public function beforeDelete() {
		deleteFile ( $this->file->path );
		return parent::beforeDelete ();
	}
	protected function afterSave() {
		parent::afterSave ();
	}
}