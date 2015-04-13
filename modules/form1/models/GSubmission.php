<?php
class GSubmission extends GActiveRecord {
	protected $_tableName;
	public $actions;
	
	/**
	 * Table meta-data.
	 * Must redeclare, as parent::_md is private
	 *
	 * @var CActiveRecordMetaData
	 */
	protected $_md;
	protected $_rules = array ();
	protected $_form;
	protected $_relations;
	public $cacheRelations = true;
	protected static $_relationsCache = array ();
	private static $_tForm = null;
	public static function clearCache() {
		foreach ( GSubmission::$_relationsCache as $key => $item ) {
			unset ( GSubmission::$_relationsCache [$key] );
		}
		GSubmission::$_relationsCache = array ();
	}
	/**
	 * Constructor
	 *
	 * @param string $scenario
	 *        	(defaults to 'insert')
	 * @param string $tableName        	
	 */
	public function __construct($scenario = 'insert', $form = null) {
		if (is_string ( $form )) {
			$this->_form = GForm::model ()->find ( 'name = :name', array (
					':name' => $form 
			) );
		}
		if (is_object ( GSubmission::$_tForm ) && ! is_object ( $form )) {
			$form = $this->_form = GSubmission::$_tForm;
		}
		if (is_object ( $form )) {
			$this->_form = $form;
			
			foreach ( $this->_form->children as $child ) {
				$child->submission = $this;
			}
			$this->_tableName = $this->_form->table;
			$this->_behaviors = $this->_form->modelBehaviors;
			$this->_rules = $this->_form->modelRules;
			foreach ( $this->_form->modelRelations as $attribute => $data ) {
				$this->_relations [$attribute] = $data;
			}
		} else {
			throw new CHttpException ( 500, CVarDumper::dumpAsString ( $this->_form, 3 ) );
		}
		parent::__construct ( $scenario );
	}
	public function __get($name) {
		if (isset ( $this->_relations [$name] )) {
			
			if ($this->_relations [$name] ['type'] == CActiveRecord::BELONGS_TO) {
				if (isset ( $this->_form ) && $this->cacheRelations) {
					if (! isset ( GSubmission::$_relationsCache [$this->_relations [$name] ['formName']] ))
						GSubmission::$_relationsCache [$this->_relations [$name] ['formName']] = array (); // create object data array if not set
					
					if (isset ( GSubmission::$_relationsCache [$this->_relations [$name] ['formName']] [$this->attributes [$name]] ))
						return GSubmission::$_relationsCache [$this->_relations [$name] ['formName']] [$this->attributes [$name]]; // if cached return cache
				}
				$relation = GSubmission::forForm ( $this->_relations [$name] ['formName'] )->findByAttributes ( array (
						'id' => $this->attributes [$name] 
				) );
				if (isset ( $this->_form ) && $this->cacheRelations) {
					GSubmission::$_relationsCache [$this->_relations [$name] ['formName']] [$this->attributes [$name]] = $relation;
				}
			}
			if ($this->_relations [$name] ['type'] == CActiveRecord::HAS_MANY) {
				$relation = GSubmission::forForm ( $this->_relations [$name] ['formName'] )->findAllByAttributes ( array (
						$this->_relations [$name] ['foreignKey'] => $this->primaryKey 
				) );
			}
			
			if ($this->_relations [$name] ['type'] == "HasAllRelation")
				$relation = GSubmission::forForm ( $this->_relations [$name] ['formName'] )->findAll ();
			
			return $relation;
		} else
			return parent::__get ( $name );
	}
	public function behaviors() {
		if (empty ( $this->_behaviors )) {
			$this->attachBehavior ( 'GOwnershipBehavior', array (
					'class' => 'GOwnershipBehavior',
					'attributes' => array (
							'userId' 
					) 
			) );
			$this->attachBehavior ( 'timestamp', array (
					'class' => 'zii.behaviors.CTimestampBehavior',
					'createAttribute' => 'created',
					'updateAttribute' => 'modified' 
			) );
			
			if (isset ( $this->_form )) {
				foreach ( $this->_form->modelBehaviors as $key => $value )
					$this->attachBehavior ( $key, $value );
			}
		}
		return $this->_behaviors;
	}
	public function getGridColumns() {
		return $this->_form->modelGridColumns;
	}
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getAttribute($attributeName) {
		if (isset ( $this->_form )) {
			foreach ( $this->_form->children as $child ) {
				if ($child->name == $attributeName) {
					return $child->getValue ( CHtml::value ( $this, $child->name ) );
				}
			}
		} else
			throw new CHttpException ( 500, 'Form not defined' );
	}
	public function getCell($attributeName) {
		if (isset ( $this->_form )) {
			foreach ( $this->_form->children as $child ) {
				$child->submission = $this;
				if ($child->name == $attributeName) {
					return $child->getCell ( CHtml::value ( $this, $child->name ) );
				}
			}
		} else
			throw new CHttpException ( 500, 'Form not defined' );
	}
	
	/**
	 * Overrides default instantiation logic.
	 * Instantiates AR class by providing table name
	 *
	 * @see CActiveRecord::instantiate()
	 * @return GSubmission
	 */
	protected function instantiate($attributes) {
		return new GSubmission ( null );
	}
	
	/**
	 * Returns meta-data for this DB table
	 *
	 * @see CActiveRecord::getMetaData()
	 * @return CActiveRecordMetaData
	 */
	public function getMetaData() {
		if ($this->_md !== null)
			return $this->_md;
		else
			return $this->_md = new CActiveRecordMetaData ( $this );
	}
	
	/**
	 * Returns table name
	 *
	 * @see CActiveRecord::tableName()
	 * @return string
	 */
	public function tableName() {
		return $this->_tableName;
	}
	public function getForm() {
		return $this->_form;
	}
	
	/**
	 * Returns rules
	 *
	 * @see CActiveRecord::rules()
	 * @return string
	 */
	public function rules() {
		return array_merge ( parent::rules (), $this->_rules );
	}
	public function phoneNumber($attribute) {
		$replace = array (
				' ',
				'-',
				'+',
				'/',
				'(',
				')',
				',',
				'.' 
		);
		if (! preg_match ( '/1?[0-9]{10}((ext|x)[0-9]{1,4})?/i', str_replace ( $replace, '', $this->getAttribute ( $attribute ) ) )) {
			$this->addError ( $attribute, 'Please enter a valid phone number.' );
		}
	}
	public static function forForm($formName, $scenario = 'insert') {
		$form = GForm::model ()->find ( 'name = :name', array (
				':name' => $formName 
		) );
		if (! isset ( $form ) && isset ( $formName ))
			throw new CHttpException ( 500, 'Form ' . $formName . ' could not be found for submission. ' );
		GSubmission::$_tForm = $form;
		$submission = new GSubmission ( $scenario, $form );
		
		return $submission;
	}
}