<?php
class GPostController extends GModelController {
	public $layout = 'gong.modules.post.views.layouts.ajax';
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'fileList' 
						),
						'expression' => array (
								'GPostController',
								'canViewPost' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'search' 
						),
						'expression' => array (
								'GPostController',
								'allowOnlyReporter' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'search',
								'searchUploads',
								'create',
								'delete',
								'update',
								'publish',
								'inlineUpdate',
								'setCover',
								'delete',
								'gallery' 
						),
						'expression' => array (
								'GPostController',
								'allowOnlyProducer' 
						) 
				),
				array (
						'deny',
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public static function canViewPost() {
		return Yii::app ()->user->can ( 'Reporter' ) || Yii::app ()->user->can ( 'Producer' );
	}
	public static function allowOnlyReporter() {
		return Yii::app ()->user->can ( 'Reporter' );
	}
	public static function allowOnlyProducer() {
		return Yii::app ()->user->can ( 'Producer' );
	}
	public function actionDelete($id) {
		$this->layout = 'none';
		$model = $this->loadModel ( $id );
		$model->delete ();
		$this->render ( 'delete', array (
				'model' => $model 
		) );
	}
	public function actionGallery($id) {
		$model = $this->loadModel ( $id );
		$this->renderPartial ( 'gallery', array (
				'model' => $model 
		) );
	}
	public function actionSearch($search = null) {
		$this->layout = 'gong.modules.post.views.layouts.ajax';
		$model = GSitePageElement::model ()->find ( "name = 'postSearch'" );
		$list = GElementRenderer::renderElement ( $model, array (
				'search' => $search,
				'action' => '/gong/post/post/search',
				'searchInput' => false 
		) );
		$this->renderText ( $list );
	}
	public function actionSearchUploads($search = null) {
		$this->layout = 'gong.modules.post.views.layouts.ajax';
		$model = GSitePageElement::model ()->find ( "name = 'search_uploads_list'" );
		$list = GElementRenderer::renderElement ( $model, array (
				'search' => $search,
				'publishedPosts' => false,
				'action' => '/gong/post/post/searchUploads',
				'searchInput' => false 
		) );
		$this->renderText ( $list );
	}
	public function actionSetCover($id, $coverId) {
		$model = $this->loadModel ( $id );
		$model->coverId = PseudoCrypt::unhash ( $coverId );
		$model->save ();
		$this->render ( 'setCover', array (
				'model' => $model 
		) );
	}
	public function actionFileList($id, $type) {
		$this->layout = 'none';
		$model = $this->loadModel ( $id );
		$this->render ( 'fileList', array (
				'model' => $model,
				'type' => $type 
		) );
	}
	public function actionPublish($id, $level) {
		$model = $this->loadModel ( $id );
		$model->view = $level;
		
		if (! $model->save ())
			throw new CHttpException ( 'Cannot save post' . $model->errorSummary (), '400' );
		else
			$this->render ( 'publish', array (
					'model' => $model,
			) );
				
	
	}
}

?>
