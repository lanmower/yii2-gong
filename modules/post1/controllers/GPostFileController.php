<?php
Yii::import ( "gong.modules.file.controllers.GFileController" );
class GPostFileController extends GFileController {
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'delete',
								'upload',
								'inlineUpdate',
								'process' 
						),
						'expression' => array (
								'GPostController',
								'allowOnlyProducer' 
						) 
				),
				array (
						'allow',
						'actions' => array (
								'download',
								'downloadOgg',
								'downloadM4v',
								'downloadM4a',
								'downloadMp3',
								'downloadImage',
								'details',
								'delete',
								'upload',
								'inlineUpdate' 
						),
						'expression' => array (
								'GPostController',
								'canViewPost' 
						) 
				),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	public function loadModel($id) {
		$className = $this->modelClassname;
		$model = $className::model ()->find ( 'fileId = ' . PseudoCrypt::unhash ( $id ) );
		$this->setVar ( 'model', $model );
		if ($model == null)
			throw new CHttpException ( 404, 'The requested item was not found.' );
		return $model;
	}
	public function actionUpload() {
		$oldCoverId = null;
		if (isset ( $_GET ['postId'] )) {
			$post = GPost::model ()->findByPk ( PseudoCrypt::unhash ( $_GET ['postId'] ) );
		}
		if (isset ( $post )) {
			$oldCoverId = $post->coverImageId;
		}
		parent::actionUpload ();
		$this->json ['files'] = array ();
		$this->json ['html'] = '';
		foreach ( $this->uploads as $upload ) {
			$postFile = new GPostFile ();
			$postFile->fileId = $upload->id;
			$postFile->type = $upload->type;
			$postFile->postId = PseudoCrypt::unhash ( $_GET ['postId'] );
			$postFile->save ();
			
			$this->json ['files'] ['filename'] = $upload->filename;
			$this->json ['files'] ['size'] = $upload->size;
			$this->json ['files'] ['type'] = $upload->type;
			$this->json ['html'] .= $this->render ( 'upload', array (
					'postFile' => $postFile,
					'oldCoverId' => $oldCoverId 
			), true );
		}
		if (empty ( $this->uploads )) {
			$this->json ['success'] = false;
		} else {
			$this->json ['success'] = true;
		}
		foreach ( Yii::app ()->log->routes as $route ) {
			$route->enabled = false;
		}
		echo CJavaScript::jsonEncode ( $this->json );
		Yii::app ()->end ();
	}
}

?>
