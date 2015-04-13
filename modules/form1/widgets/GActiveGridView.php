<?php
class GActiveGridView extends GField {
	public $formName;
	public $select = null;
	public $listOptions = array ();
	public $_items;
	public $foreignKey = null;
	public $columns = null;
	public $dataProviderOptions = array();
	
	public function getItems() {
		$name = $this->name;
		return $this->submission->$name;
	}
	
	public function getRelations() {
		if (!isset ( $this->formName )) throw new CHttpException(500, 'No form name set on active grid view widget');
		$ret = array(
				$this->name => array('formName'=>$this->formName, 'type'=>CActiveRecord::HAS_MANY, 'foreignKey'=>$this->foreignKey)
		);
		return $ret;
	}
	
	public function getViewGridColumns() {
	  if(!isset($this->columns)) {
	  	$this->columns = GSubmission::forForm($this->formName)->getGridColumns();
	  }
	  return $this->columns;
	}
	public function getRules() {
		return array();
	}
	
	public function run() {
		if (isset ( $_POST [$this->name] ))
			$this->select = $_POST [$this->name];
		if (isset ( $this->submission )) {
			$dataProvider = new CArrayDataProvider($this->getItems(), $this->dataProviderOptions);
			$this->widget('GGridView', array('dataProvider'=>$dataProvider, 'columns'=>$this->viewGridColumns));
		}
		parent::run ();
	}
	public function getCell($value) {
		if (isset ( $this->submission )) {
			$items = $this->getItems();
			$ret = array();
			foreach($items as $item) {
				$ret[] = $item->number.' '.$item->course;
			}
			return implode('<br/>', $ret);
		} else
			throw new CHttpException ( 500, 'no submission set' );
	}

	public function getSqlString() {
		return "";
	}
	
	public function getGridColumns() {
		return array (
		);
	}
}

?>