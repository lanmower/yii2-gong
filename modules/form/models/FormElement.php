<?php

namespace almagest\gong\modules\form\models;

use yii\db\ActiveRecord;

/**
 * FormElement
 * @property integer $id
 */
class FormElement extends ActiveRecord {
	private $_widget;
	private $_field;
	
	public static function tableName() {
		return "{{%formElement}}";
	}
	
	public function getWidget() {
		if(isset($this->_widget)) return $this->_widget;
		
		$this->_widget = new $this->className (); 
		foreach ( $this->fields as $name => $value )
			$this->_widget->$name = $value;
		
		if(property_exists($this->className, 'formElement'))
			$this->_widget->formElement = $this;
		
		$this->_widget->beforeInit ();
		return $this->_widget;
	}
}
