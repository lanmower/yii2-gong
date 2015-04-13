<?php
Yii::import ( "gong.modules.file.models.GFile" );

/**
 * This is the model class for table "page".
 *
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property string $view
 * @property string $created
 * @property string $modified
 * @property string $userId
 */
class GPost extends GActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getBackLink() {
		return '/page/upload';
	}
	public function tableName() {
		return '{{post}}';
	}
	public function behaviors() {
		return array (
				'DeleteChildren' => array (
						'class' => 'GDeleteChildrenBehavior',
						'childAttributes' => array (
								'files' 
						) 
				),
				'Ownership' => array (
						'class' => 'GOwnershipBehavior',
						'attributes' => array (
								'userId' 
						) 
				),
				'Timestamp' => array (
						'class' => 'zii.behaviors.CTimestampBehavior',
						'createAttribute' => 'created',
						'updateAttribute' => 'modified' 
				),
				'Permissions' => array (
						'class' => 'GPermissionsBehavior' 
				) 
		);
	}
	public function rules() {
		return array (
				array (
						'view',
						'length',
						'max' => 255 
				),
				array (
						'title',
						'length',
						'max' => 50 
				),
				array (
						'summary',
						'length',
						'max' => 100 
				),
				array (
						'title, sumnmary, content, view',
						'safe' 
				) 
		);
	}
	public function getCoverImage() {
		if (isset ( $this->coverFile ))
			return $this->coverFile;
		else {
			if (count ( $this->imageFiles ) > 0) {
				return $this->imageFiles [0];
			} else {
				return null;
			}
		}
	}
	public function getCoverImageId() {
		if (isset ( $this->coverImage ))
			return $this->coverImage->id;
		return 0;
	}
	public function relations() {
		return array (
				'files' => array (
						self::MANY_MANY,
						'GFile',
						'{{post_file}}(postId, fileId)',
						'order' => 'files.weight ASC',
						'together' => true 
				),
				'imageFiles' => array (
						self::MANY_MANY,
						'GFile',
						'{{post_file}}(postId, fileId)',
						'on' => "imageFiles.type = 'image'",
						'order' => 'imageFiles.weight ASC' 
				),
				'audioFiles' => array (
						self::MANY_MANY,
						'GFile',
						'{{post_file}}(postId, fileId)',
						'on' => "audioFiles.type = 'audio'",
						'order' => 'audioFiles.weight ASC' 
				),
				'videoFiles' => array (
						self::MANY_MANY,
						'GFile',
						'{{post_file}}(postId, fileId)',
						'on' => "videoFiles.type = 'video'",
						'order' => 'videoFiles.weight ASC' 
				),
				'dataFiles' => array (
						self::MANY_MANY,
						'GFile',
						'{{post_file}}(postId, fileId)',
						'on' => "dataFiles.type = 'data'",
						'order' => 'dataFiles.weight ASC' 
				),
				'coverFile' => array (
						self::BELONGS_TO,
						'GFile',
						'coverId' 
				),
				'user' => array (
						self::BELONGS_TO,
						'GUser',
						'userId' 
				) 
		);
	}
}