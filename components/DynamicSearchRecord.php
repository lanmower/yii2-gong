<?php

namespace almagest\gong\components;

use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * DynamicSearchRecord
 * dynamic search records
 *
 * @property integer $id
 */
class DynamicSearchRecord extends DynamicRecord {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		if (isset ( $this->_conf ['searchrules'] ))
			return $this->_conf ['searchrules'];
		else
			return parent::rules ();
	}

	public static function getDb() {
		$conf = end(self::$_sconf);
		if(isset($conf['db'])) {
			return \Yii::$app->db;
		}
		return \Yii::$app->local;
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios ();
	}
	
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params        	
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$model = DynamicSearchRecord::forModel ( $this->_conf ['class'] );
		$query = $model::find ();
		
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $query 
		] );
		$this->load ( $params );
		
		if (! $this->validate ()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		$query->andFilterWhere ( [ 
				$this->primaryKey => $this->id 
		] );
		$rules = $this->rules ();
		if (isset ( $rules [0] ) && isset ( $rules [0] [0] )) {
			foreach ( $rules [0] [0] as $rule ) {
				$query->andFilterWhere ( [ 
						'like',
						$rule,
						$this->$rule 
				] );
			}
		}
		/*
		 * $query->andFilterWhere ( [
		 * 'like',
		 * 'name',
		 * $this->name
		 * ] );
		 */
		
		return $dataProvider;
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
		DynamicRecord::done ();
		return self::forTable ( $model['table'], $settings );
	}
	public static function forTable($tableName, $config = []) {
		$config ['_conf'] ['table'] = $tableName;
		$ret = new DynamicSearchRecord ( $config );
		return $ret;
	}
}
