<?php

namespace almagest\gong\components;

use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\helpers\VarDumper;
use almagest\gong\models\Model;

/**
 * Record
 * Gong records are dynamic active records
 *
 * @property integer $id
 */
class DynamicRecord extends ActiveRecord {
	public $form;
	public static $_sconf = [];
	public $_conf;
	public $settings;
	public static $JSON_SETTINGS = [ 
			'_conf' => [ 
					'behaviors' => [ 
							'JSONField' => [ 
									'class' => 'almagest\gong\models\behaviors\JSONField',
									'field' => 'json_settings',
									'output' => 'settings' 
							] 
					] 
			] 
	];
	
	public static function getDb() {
		$conf = end(self::$_sconf);
		if(isset($conf['db'])) {
			return \Yii::$app->db;
		}
		return \Yii::$app->local;
			}
		
	public function __construct($config = []) {
		if (isset ( $config ['_conf'] )) {
			self::$_sconf[] = $config ['_conf'];
		}
		$this->_conf = end(self::$_sconf);
		$ret = parent::__construct ( $config );
		// if(empty($this->_attributes)) die(VarDumper::dump(self::$_sconf));
		return $ret;
	}
	
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		$sconf = end(self::$_sconf);
		return $sconf['table'];
	}
	
	
	public static function done() {
		array_pop(self::$_sconf);
	}
	
	public function formName() {
		return basename($this->_conf['class']);
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		if (isset ( $this->_conf ['behaviors'] ))
			return $this->_conf ['behaviors'];
		else
			return parent::behaviors ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		if (isset ( $this->_conf ['rules'] ))
			return $this->_conf ['rules'];
		else
			return parent::rules ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		if (isset ( $this->_conf ['scenarios'] ))
			return $this->_conf ['scenarios'];
		else
			return parent::scenarios ();
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		if (isset ( $this->_attributeLabels ))
			return $this->_attributeLabels;
		else
			return parent::attributeLabels ();
	}
	public static function forForm($formName, $config = []) {
		$form = Form::model ()->find ( 'name = :name', array (
				':name' => $formName 
		) );
		if (! isset ( $form ))
			throw new CHttpException ( 500, 'Form ' . $formName . ' could not be found for submission. ' );
		
		return self::forTable ( $form->tableName, $config );
	}
	
	public static function forModel($name, $config = [], $controller = null) {
		$model = \Yii::$app->params['model'][$name];
		
		if (! isset ( $model ))
			return false;
			// the behavior will have converted json settings to a settings array
		$settings = $model['settings'];
		
		if (! isset ( $modelName )) {
			$modelName = explode ( "/", $name );
			$modelName = end ( $modelName );
		}
		if (! isset ( $controller )) {
			$controller = $modelName;
		}
		$settings ['_conf'] ['name'] = $modelName;
		$settings ['_conf'] ['class'] = $name;
		$settings ['_conf'] ['controller'] = $name;
		DynamicRecord::done();
		return self::forTable ( $model['table'], $settings );
	}
	public static function forTable($tableName, $config = []) {
		$config ['_conf'] ['table'] = $tableName;
		$ret = new DynamicRecord ( $config );
		return $ret;
	}
}
