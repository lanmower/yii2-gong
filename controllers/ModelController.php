<?php

namespace almagest\gong\controllers;

use yii\base\Behavior;
use almagest\gong\components\DynamicRecord;
use almagest\gong\components\DynamicSearchRecord;
use yii\helpers\VarDumper;

class ModelController extends Behavior {
	public $modelClassname;
	public $parent = 'parent';
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = DynamicRecord::forModel ( $this->modelClassname );
		if (isset ( $model->_conf ['behaviors'] ['parent'] )) {
			$parentClass = $model->_conf ['behaviors'] ['parent'] ['className'];
			$parent = DynamicRecord::forModel ( $parentClass )->findOne ( $_GET ['parent'] );
			DynamicRecord::done ();
			$model->parent_id = $_GET ['parent'];
			if($model->hasAttribute('user_id')) $model->user_id = \Yii::$app->user->id;
		}
		if ($model->load ( \Yii::$app->request->post () ) && $model->save ()) {
			$owner = $this->owner;
			return $this->owner->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->owner->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionDelete() {
		
		
		$this->findModel ( $_GET ['id'] )->delete ();
		
		
		return $this->owner->redirect ( [ 
				'list' 
		] );
		
	}
	public function actionUpdate() {
		$model = $this->findModel ( $_GET ['id'] );
		
		if ($model->load ( \Yii::$app->request->post () ) && $model->save ()) {
			return $this->owner->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->owner->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Lists all View models.
	 *
	 * @return mixed
	 */
	public function actionList() {
		$searchModel = DynamicSearchRecord::forModel ( $this->modelClassname );
		$dataProvider = $searchModel->search ( \Yii::$app->request->queryParams );
		
		return $this->owner->render ( 'list', [ 
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider 
		] );
	}
	
	/**
	 * Displays a single View model.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionView() {
		return $this->owner->render ( 'view', [ 
				'model' => $this->findModel ( $_GET ['id'] ) 
		] );
	}
	
	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id        	
	 * @return View the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		$className = $this->modelClassname;
		$model = DynamicRecord::forModel ( $className );
		
		if (($model = $model::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}

?>
