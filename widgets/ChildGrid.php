<?php

namespace almagest\gong\widgets;

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use almagest\gong\components\DynamicRecord;
use almagest\gong\components\DynamicSearchRecord;

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
		
		$searchModel = DynamicSearchRecord::forModel($model->_conf['behaviors']['children']['className']);
		$provider = $searchModel->search ( \Yii::$app->request->queryParams );
		$provider->setPagination([ 
						'pageSize' => 10 
				] );
		
		if(empty($this->columns)) $this->guessColumns($provider);
		$ret = GridView::widget ( [
				'showOnEmpty'=>true,
				'dataProvider' => $provider,
				'columns' => $this->columns,
				'filterModel' => $searchModel,
		] );
	 
		DynamicRecord::done();
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
