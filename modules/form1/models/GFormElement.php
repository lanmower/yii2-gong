<?php
Yii::import ( 'gong.modules.site.models.GElement' );
class GFormElement extends GElement {
	public $parentClass = 'GForm';
	private $_data = null;
	public $submission;
	public function getCreateRedirect() {
		return Yii::app ()->controller->createUrl ( '/gong/form/admin/view/', array (
				'id' => $this->parent->hash 
		) );
	}
	public function getDeleteRedirect() {
		return Yii::app ()->controller->createUrl ( '/gong/form/admin/view/', array (
				'id' => $this->parent->hash 
		) );
	}
	public function tableName() {
		return '{{form_element}}';
	}
	public function getDataTable() {
		return $this->parent->table;
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getModelLabel() {
		return 'form element';
	}
	public function rules() {
		return array (
				array (
						'parentId',
						'required' 
				),
				array (
						'name, edit, delete, view',
						'length',
						'max' => 255 
				),
				array (
						'weight, parentId',
						'length',
						'max' => 11 
				),
				array (
						'prefixContent, suffixContent',
						'filter',
						'filter' => array (
								$obj = new CHtmlPurifier (),
								'purify' 
						) 
				),
				array (
						'className, title, description, name, fields',
						'safe' 
				) 
		);
	}
	public function getWidget() {
		$fieldWidget = new $this->className ();
		foreach ( $this->fields as $name => $value )
			$fieldWidget->$name = $value;
		$fieldWidget->model = $this;
		$fieldWidget->submission = $this->submission;
		$fieldWidget->beforeInit ();
		return $fieldWidget;
	}
	public function getValue($value) {
		return $this->widget->getValue ( $value );
	}
	public function getCell($value) {
		return $this->widget->getCell ( $value );
	}
	public function getSql() {
		$fieldWidget = new $this->className ();
		$sql = '';
		foreach ( $this->fields as $name => $value )
			$fieldWidget->$name = $value;
		if (property_exists ( $this->className, 'model' ))
			$fieldWidget->model = $this;
		if (method_exists ( $fieldWidget, 'beforeInit' ))
			$fieldWidget->beforeInit ();
		if (method_exists ( $fieldWidget, 'getSqlString' ))
			$sql = $fieldWidget->sqlString;
		return $sql;
	}
	protected function afterSave() {
		if (! is_array ( $this->fields ))
			$this->fields = array ();
		$fieldSql = $this->sql;
		if (! empty ( $fieldSql )) {
			if ($this->isNewRecord) {
				$sql = 'ALTER TABLE ' . $this->parent->table . " ADD " . $fieldSql;
				$this->dbConnection->createCommand ( $sql )->execute ();
			} else {
				$sql = 'ALTER TABLE ' . $this->parent->table . " MODIFY COLUMN " . $fieldSql;
				$this->dbConnection->createCommand ( $sql )->execute ();
			}
		}
		parent::afterSave ();
	}
	protected function afterDelete() {
		$sql = 'ALTER TABLE ' . $this->parent->table . ' DROP ' . $this->name;
		try {
			$this->dbConnection->createCommand ( $sql )->execute ();
		} catch ( CDbException $e ) {
		}
	}
	public function relations() {
		return array (
				
				// 'children' => array(self::HAS_MANY, 'GFormElement', 'parentId'),
				'parent' => array (
						self::BELONGS_TO,
						'GForm',
						'parentId' 
				) 
		);
	}
}

?>