<?php

namespace almagest\gong\modules\view\widgets;

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use almagest\gong\components\DynamicRecord;

/**
 * This is just an example.
 */
class ChildGrid extends \yii\base\Widget {
	public $field = 'children';
	public $model;
	public $searchModel;
	public $columns = [];
	
	public function run() {
		$model = $this->model;
		$field = $this->field;
		$searchModel = $this->searchModel;
		$query = $model->getRelation ( $field );
		$provider = new ActiveDataProvider ( [ 
				'query' => $query,
				'pagination' => [ 
						'pageSize' => 10 
				] 
		] );
		
		if(empty($this->columns)) $this->guessColumns($provider);
		$ret = GridView::widget ( [ 
				'dataProvider' => $provider,
				'columns' => $this->columns 
		] );
		DynamicRecord::done();
		return $ret;
	}
	
	/**
	 * This function tries to guess the columns to show from the given data
	 * if [[columns]] are not explicitly specified.
	 */
	protected function guessColumns(ActiveDataProvider $provider)
	{
		$models = $provider->getModels();
		$model = reset($models);
		if (is_array($model) || is_object($model)) {
			foreach ($model as $name => $value) {
				$this->columns[] = $name;
			}
			$this->columns[] = [ 'class' => 'yii\grid\ActionColumn', 'controller' => $model->_conf['controller'] ];
		}
	}	
}
