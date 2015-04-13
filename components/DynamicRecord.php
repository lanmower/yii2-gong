<?php

namespace almagest\gong\components;

use yii\db\ActiveRecord;

/**
 * Record
 * Gong records are dynamic active records
 *
 * @property integer $id
 */
class DynamicRecord extends ActiveRecord {
	public $form;
	public $tableName;
	public $behaviors = array();
	public $rules = array();
	public $scenarios = array();
	public $attributeLabels = array();
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return "{{%{$this->tableName}}}";
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		if (!isset ( $this->behaviors ) && isset($this->form))
			$this->behaviors = $form->getModelAttributeGroup('behaviors');
		return $this->behaviors;
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		if (!isset ( $this->rules ) && isset($this->form))
			$this->rules = $form->getModelAttributeGroup('rules');
				return parent::rules ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		if (!isset ( $this->scenarios ) && isset($this->form))
			$this->scenarios = $form->getModelAttributeGroup('scenarios');
		return parent::scenarios ();
	}
	
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		if (!isset ( $this->attributeLabels ) && isset($this->form))
			$this->attributeLabels = $form->getModelAttributeGroup('attributeLabels');
		return parent::attributeLabels ();
	}
	
	public static function forForm($formName) {
		$form = Form::model ()->find ( 'name = :name', array (
				':name' => $formName
		) );
		if (! isset ( $form ))
			throw new CHttpException ( 500, 'Form ' . $formName . ' could not be found for submission. ' );
		
		$record = new Record(['tableName'=>$form->tableName]);
		return $record;
	}

}
