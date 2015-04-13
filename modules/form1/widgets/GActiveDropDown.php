<?php
class GActiveDropDown extends GField {
	public $tableName;
	public $formName;
	public $valueFieldName = 'id';
	public $displayFieldName = 'name';
	public $condition;
	public $select = null;
	public $listOptions = array ();
	public $_items;
	public $criteria = array ();
	public $foreignKey;
	public function getItems() {
		if (! isset ( $this->_items )) {
			
			if (isset ( $this->tableName )) {
				$sqlProvider = new CSqlDataProvider ( 'select ' . $this->valueFieldName . ', ' . $this->displayFieldName . ' from ' . $this->tableName, array (
						'pagination' => array (
								'pageSize' => '999' 
						) 
				) );
				$data = $sqlProvider->getData ();
			} else if (isset ( $this->formName )) {
				$submission = GSubmission::forForm ( $this->formName );
				$activeProvider = new CActiveDataProvider ( $submission, array (
						'pagination' => array (
								'pageSize' => '999' 
						),
						'criteria' => $this->criteria 
				) );
				$data = $activeProvider->getData ();
			} else
				throw new CHttpException ( 500, 'must provide active dropdown with foreign table or form' );
			
			$this->_items = array ();
			foreach ( $data as $item ) {
				$id = $item [$this->valueFieldName];
				$field = $item [$this->displayFieldName];
				$this->_items [$id] = $field;
			}
		}
		return $this->_items;
	}
	public function getRelations() {
		if (! isset ( $this->formName ))
			return array ();
		$ret = array (
				$this->name => array (
						'formName' => $this->formName,
						'type' => CActiveRecord::BELONGS_TO,
						'foreignKey' => $this->foreignKey 
				) 
		);
		return $ret;
	}
	public function run() {
		if (isset ( $_POST [$this->name] ))
			$this->select = $_POST [$this->name];
		if (isset ( $this->submission )) {
			echo CHtml::activeDropDownList ( $this->submission, $this->name, $this->getItems (), array_merge ( array (
					'empty' => 'Please select' 
			), $this->listOptions ) );
		} else {
			echo CHtml::dropDownList ( $this->name, $this->select, $this->getItems (), array_merge ( array (
					'empty' => 'Please select' 
			), $this->listOptions ) );
		}
		parent::run ();
	}
	public function getCell($value) {
		if (isset ( $this->submission )) {
			echo CHtml::form ( array (
					'submission/update',
					'id' => $_GET ['id'],
					'dataId' => PseudoCrypt::hash ( $this->submission->id ) 
			), 'post' );
			echo CHtml::activeDropDownList ( $this->submission, $this->name, $this->getItems (), array_merge ( array (
					'empty' => 'Please select' 
			), array (
					'onchange' => '$(this.form).trigger("submit")' 
			) ) );
			echo CHtml::endForm ();
		} else
			throw new CHttpException ( 500, 'no submission set' );
	}
	public function getGridColumns() {
		return array (
				array (
						'name' => $this->name,
						'class' => 'GDataColumn' 
				) 
		);
	}
}

?>