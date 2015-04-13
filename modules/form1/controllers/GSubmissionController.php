<?php
class GSubmissionController extends GController {
	public function accessRules() {
		$rules = parent::accessRules ();
		self::addRule ( $rules, array (
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array (
						'form',
						'index',
						'captcha' 
				),
				'users' => array (
						'@' 
				) 
		) );
		return $rules;
	}
	public function actions() {
		$actions = parent::actions ();
		$actions ['captcha'] = array (
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF 
		);
		return $actions;
	}
	public function actionInlineUpdate($id) {
		$form = GForm::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
		if (! Yii::app ()->user->can ( $form->view ))
			throw new CHttpException ( 403, 'User is not allowed to use this form' );
		$this->setVar ( 'form', $form );
		if (isset ( $_POST ['pk'] )) {
			$model = GSubmission::forForm ( $form->name )->model ()->findByPk ( PseudoCrypt::unhash ( $_POST ['pk'] ) );
			$model->setAttribute ( $_POST ['name'], $_POST ['value'] );
			if (! $model->save ()) {
				foreach ( $model->errors as $error )
					echo "<span class='alert-error'>{$error[0]}</span>";
				echo "<span class='alert-info pointer'>try again</span>";
			} else {
				echo CHtml::value ( $model, $_POST ['name'] );
			}
		}
	}
	public function actionUpdate($id, $dataId) {
		$form = GForm::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
		if (! Yii::app ()->user->can ( $form->view ))
			throw new CHttpException ( 403, 'User is not allowed to use this form' );
		if ($form === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		$this->setVar ( 'form', $form );
		$model = GSubmission::forForm ( $form->name )->model ()->findByPk ( PseudoCrypt::unhash ( $dataId ) );
		if (isset ( $_POST ['GSubmission'] )) {
			// die(CVarDumper::dump($_POST['GSubmission']));
			$model->attributes = $_POST ['GSubmission'];
			if ($model->save ())
				$this->render ( 'updateDone', array (
						'model' => $model 
				) );
		} else {
			$this->render ( 'form', array (
					'model' => $model 
			) );
		}
	}
	public function actionIndex($id) {
		$form = GForm::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
		if (! Yii::app ()->user->can ( $form->view ))
			throw new CHttpException ( 403, 'User is not allowed to view this form' );
		if ($form === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		$this->setVar ( 'form', $form );
		$model = GSubmission::forForm ( $form->name );
		$data = new CActiveDataProvider ( $model );
		$this->render ( 'index', array (
				'dataProvider' => $data,
				'model' => $model 
		) );
	}
	public function actionDelete($id, $dataId) {
		if (isset ( $_GET ['id'] )) {
			$form = GForm::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
			if (! Yii::app ()->user->can ( $form->view ))
				throw new CHttpException ( 403, 'User is not allowed to view this form' );
			if ($form === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
			$this->setVar ( 'form', $form );
			$model = GSubmission::forForm ( $form->name )->findByPk ( PseudoCrypt::unhash ( $dataId ) );
			if (isset ( $model ))
				$model->delete ();
			$this->redirect ( $this->createUrl ( "index", array (
					'id' => $form->hash 
			) ) );
		}
	}
	public function actionCreate($id) {
		$form = GForm::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
		if (! Yii::app ()->user->can ( $form->view ))
			throw new CHttpException ( 403, 'User is not allowed to view this form' );
		$this->setVar ( 'form', $form );
		$data = GSubmission::forForm ( $form->name );
		
		if (isset ( $_POST ['GSubmission'] )) {
			$data->attributes = $_POST ['GSubmission'];
			if ($data->validate ()) {
				if ($data->save ()) {
					$this->redirect ( "/gong/form/submission/index/id/$form->hash" );
				}
			}
		}
		
		$this->render ( 'form', array (
				'model' => $data 
		) );
	}
}

?>
