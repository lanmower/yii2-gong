<?php

namespace almagest\gong\controllers;

use yii\base\Behavior;
use almagest\gong\components\DynamicRecord;
use almagest\gong\components\DynamicSearchRecord;
use yii\helpers\VarDumper;
use almagest\gong\models\UploadForm;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\web\HttpException;
use almagest\gong\components\DownloadHelper;
use yii\helpers\Url;
use FFMpeg\FFProbe;
use FFMpeg\FFMpeg;
use FFMpeg\Exception\RuntimeException;
use yii\helpers\Html;
use yii\image\drivers\Image;
use FFMpeg\FFProbe\DataMapping\Format;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Video\Ogg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\FrameRate;
use FFMpeg\Filters\Video\ResizeFilter;

class JsonController extends Behavior {
	public $modelClassname;
	public $parent = 'parent';
	
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
		$model = DynamicSearchRecord::forModel ( $className );
		
		if (($model = $model::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}

	public function actionJsonList() {
		$className = $this->modelClassname;
		$dataProvider = DynamicSearchRecord::forModel ( $className )->search(''); 
		\Yii::$app->response->format = 'json';
		$ret = [];
		foreach ($dataProvider->getModels() as $model) {
			$data = $model->attributes;
			$data['files'] = ['audio'=>[],'video'=>[],'image'=>[]];
			$data['html'] = $model->settings;
			foreach($model->children as $child) {
				$attributes = $child->attributes;
				if($child->type == 'audio') $data['files']['audio'][] = $attributes;
				if($child->type == 'video') $data['files']['video'][] = $attributes;
				if($child->type == 'image') $data['files']['image'][] = $attributes;
				if($child->type == 'data') $data['files']['data'][] = $attributes;
			}
			$ret[] = $data;
		}
		return $ret;
	}
}

?>
