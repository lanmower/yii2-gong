<?php
class GForm extends GActiveRecord {
	public $childClass = 'GFormElement';
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getCreateRedirect() {
		return Yii::app ()->controller->createUrl ( '/gong/form/admin/list' );
	}
	public function getDeleteRedirect() {
		return Yii::app ()->controller->createUrl ( '/gong/form/admin/list' );
	}
	public function getChildModel() {
		$childClass = $this->childClass;
		return $childClass::model ();
	}
	public function tableName() {
		return '{{form}}';
	}
	public function getModelLabel() {
		return lcfirst ( str_replace ( 'G', '', get_class ( $this ) ) );
	}
	public function getControllerId() {
		return 'admin';
	}
	public function getCustomUrl() {
		return Yii::app ()->createUrl ( '/gong/form/submission/index/' );
	}
	public function rules() {
		return array (
				array (
						'name, table',
						'safe' 
				) 
		);
	}
	public function getGridColumns() {
		return array (
				array (
						'name' => 'name',
						'class' => 'GEditableColumn' 
				),
				array (
						'name' => 'table',
						'class' => 'GEditableColumn' 
				),
				array (
						'name' => 'view',
						'class' => 'GEditableColumn' 
				),
				array (
						'header' => 'actions',
						'class' => 'GButtonColumn',
						'template' => '{self}{custom}{delete}' 
				) 
		);
	}
	public function behaviors() {
		return array (
				'DeleteChildren' => array (
						'class' => 'GDeleteChildrenBehavior',
						'childAttributes' => array (
								'children' 
						) 
				),
				'Timestamp' => array (
						'class' => 'zii.behaviors.CTimestampBehavior',
						'createAttribute' => 'created',
						'updateAttribute' => 'modified' 
				),
				'Ownership' => array (
						'class' => 'GOwnershipBehavior',
						'attributes' => array (
								'userId' 
						) 
				) 
		);
	}
	protected function afterSave() {
		if ($this->isNewRecord) {
			$sql = "CREATE TABLE $this->table(
                    `id` int(20) NOT NULL AUTO_INCREMENT, `created` DATETIME NOT NULL , `modified` DATETIME NOT NULL , PRIMARY KEY (`id`))";
			$this->dbConnection->createCommand ( $sql )->execute ();
		}
		parent::afterSave ();
	}
	public function getModelRules() {
		$rules = array ();
		foreach ( $this->children as $field ) {
			if (method_exists ( $field->className, 'getRules' )) {
				$fieldWidget = $field->widget;
				$fieldRules = $fieldWidget->getRules ();
				$fieldWidget->beforeInit ();
				foreach ( $fieldRules as $fieldRule ) {
					if (is_array ( $fieldRule )) {
						$rules [] = array_merge ( array (
								$field->name 
						), $fieldRule );
					} else
						$rules [] = array (
								$field->name,
								$fieldRule 
						);
				}
			}
		}
		return $rules;
	}
	public function getModelRelations() {
		$relations = array ();
		foreach ( $this->children as $field ) {
			if (method_exists ( $field->className, 'getRelations' )) {
				$fieldWidget = $field->widget;
				$fieldRelations = $fieldWidget->getRelations ();
				if (is_array ( $fieldRelations ))
					foreach ( $fieldRelations as $fieldKey => $fieldRelation ) {
						$relations [$fieldKey] = $fieldRelation;
					}
			}
		}
		return $relations;
	}
	public function getModelBehaviors() {
		$behaviors = array ();
		foreach ( $this->children as $field ) {
			if (method_exists ( $field->className, 'getBehaviors' )) {
				$fieldWidget = $field->widget;
				$fieldBehaviors = $fieldWidget->getBehaviors ();
				foreach ( $fieldBehaviors as $fieldKey => $fieldBehavior ) {
					$behaviors [$field->name . '-' . $fieldKey] = $fieldBehavior;
				}
			}
		}
		return $behaviors;
	}
	public function getModelGridColumns() {
		$gridColumns = array ();
		foreach ( $this->children as $field ) {
			if (method_exists ( $field->className, 'getGridColumns' )) {
				$fieldWidget = $field->widget;
				$fieldGridColumns = $fieldWidget->getGridColumns ();
				foreach ( $fieldGridColumns as $fieldGridColumn ) {
					$gridColumns [] = $fieldGridColumn;
				}
			}
		}
		$gridColumns [] = array (
				'header' => 'actions',
				'class' => 'GSubmissionButtonColumn',
				'template' => '{update}{delete}' 
		);
		return $gridColumns;
	}
	protected function afterDelete() {
		$sql = 'DROP TABLE ' . $this->table;
		try {
			$this->dbConnection->createCommand ( $sql )->execute ();
		} catch ( CDbException $e ) {
		}
	}
	public function relations() {
		return array (
				'children' => array (
						self::HAS_MANY,
						'GFormElement',
						'parentId' 
				) 
		);
		// 'parent' => array(self::BELONGS_TO, 'GForm', 'parentId'),
		
	}
	public static function select($name) {
		$model = self::model ()->find ( "name = '$name'" );
		if ($model)
			return $model;
		else
			return false;
	}
}

?>
