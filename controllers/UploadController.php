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

class UploadController extends Behavior {
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
		$model = DynamicRecord::forModel ( $className );
		
		if (($model = $model::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
	public function actionDownload() {
		$model = $this->findModel ( $_GET ['id'] );
		if ($model) {
			DownloadHelper::download ( $model->file, 'octet/stream', $model->filename );
		} else {
			throw new HttpException ( 404, 'File not found' );
		}
	}
	public function actionProcess() {
		ob_implicit_flush ( true );
		ob_end_flush ();
		$model = DynamicRecord::forModel ( $this->modelClassname )->find ()->where ( [ 
				'processed' => false 
		] )->orderBy ( 'id ASC' )->one ();
		if ($model) {
			VarDumper::dump ( 'Found unprocessed file:' );
			VarDumper::dump ( $model->filename );
			try {
				$type = $this->probe ( $model );
			} catch ( RuntimeException $e ) {
				echo $e->getMessage ();
			}
			if (isset($type))
				$this->handle ( $type, $model );
			else {
				// data file
				VarDumper::dump ( 'data file found<br\>' );
				$model->processed = 1;
				$model->type = 'data';
				$model->save ( 'processed' );
				VarDumper::dump ( 'saved.<br\>' );
			}
		}
		// return $this->owner->render('process');
	}
	public function handleVideo($file, $extension) {
		$ffmpeg = FFMpeg::create ();
		$video = $ffmpeg->open ( $file );
		$format = new WebM ();
		$format->on ( 'progress', function ($video, $format, $percentage) {
			VarDumper::dump ( "$percentage %<br/>" );
		} );
		VarDumper::dump ( "Transcoding webm<br/>" );
		$video->filters()->synchronize();//resize(new Dimension(640, 480), ResizeFilter::RESIZEMODE_INSET, true)->
		$video->save ( $format, $file . '-video.webm' );
		
		$video = $ffmpeg->open ( $file );
		$format = new X264 ();
		$format->setAudioKiloBitrate(256);
		$format->on ( 'progress', function ($video, $format, $percentage) {
			VarDumper::dump ( "$percentage %<br/>" );
		} );
		VarDumper::dump ( "Transcoding mp4<br/>" );
		$video->filters()->synchronize();//resize(new Dimension(640, 480), ResizeFilter::RESIZEMODE_INSET, true)->
		$video->save ( $format, $file . '-video.mp4' );

		$format = new Ogg();
		$format->on ( 'progress', function ($video, $format, $percentage) {
			VarDumper::dump ( "$percentage %<br/>" );
		} );
		VarDumper::dump ( "Transcoding ogv<br/>" );
		$video->filters()->resize(new Dimension(640, 480), ResizeFilter::RESIZEMODE_INSET, true)->synchronize();//
		$video->save ( $format, $file . '-video.ogv' );
	}
	public function handleAudio($file, $extension) {
		$ffmpeg = FFMpeg::create ();
		$audio = $ffmpeg->open ( $file );
		
		VarDumper::dump ( "Transcoding mp3<br/>" );
		$format = new Mp3 ();
		$format->on ( 'progress', function ($video, $format, $percentage) {
			VarDumper::dump ( "$percentage %<br/>" );
		} );
		
		VarDumper::dump ( "Transcoding ogg<br/>" );
		$audio->save ( $format, $file . '-audio.mp3' );
		$format = new Ogg ();
		$format->on ( 'progress', function ($video, $format, $percentage) {
			VarDumper::dump ( "$percentage %<br/>" );
		} );
		$audio->save ( $format, $file . '-audio.ogg' );
	}
	public function handleImage($file, $extension) {
		$sizes = DynamicRecord::forModel ( 'config' )->findOne ( [ 
				'key' => 'image_sizes' 
		] )->settings;
		DynamicRecord::done ();
		$image = \Yii::$app->image->load ( $file );
		$image->save ( "$file-image.$extension" );
		foreach ( $sizes as $sizeName => $size ) {
			$image = \Yii::$app->image->load ( $file );
			if (! isset ( $size ['width'] ) && isset ( $size ['height'] )) {
				$size ['width'] = $size ['height'];
				$master = Image::HEIGHT;
			}
			if (! isset ( $size ['height'] ) && isset ( $size ['width'] )) {
				$size ['height'] = $size ['width'];
				$master = Image::WIDTH;
			}
			if (isset ( $size ['master'] )) {
				if ($size ['master'] == 'height')
					$master = Image::HEIGHT;
				if ($size ['master'] == 'width')
					$master = Image::WIDTH;
				$image->resize ( $size ['width'], $size ['height'], $master );
			} else
				$image->resize ( $size ['width'], $size ['height'] );
			$image->save ( "$file-image-$sizeName.$extension" );
		}
	}
	public function handle($type, $model) {
		VarDumper::dump ( $type . ' found' );
		$model->type = $type;
		$model->processed = 1;
		$function = 'handle' . ucfirst ( $type );
		$this->$function ( $model->file, pathinfo ( $model->filename, PATHINFO_EXTENSION ) );
		$model->save ( [ 
				'type',
				'processed' 
		] );
		VarDumper::dump ( 'saved.<br\>' );
	}
	public function probe(DynamicRecord $model) {
		$ffprobe = FFProbe::create ();
		$streams = $ffprobe->streams ( $model->file );
		VarDumper::dump ( $streams, 10, true );
		$videos = $streams->videos ();
		if ($videos->count () > 0) {
			// visual
			foreach ( $videos as $video ) {
				if ($video->all ()['codec_name'] == 'png')
					$image = true;
				if ($video->all ()['codec_name'] == 'mjpeg')
					$image = true;
				if ($video->all ()['codec_name'] == 'gif')
					$image = true;
				if(!$video->all ()['disposition']['attached_pic']) {
				if (isset ( $image ) ) {
					return 'image';
				}
				return 'video';
				}
			}
		}
		$audios = $streams->audios ();
		if ($audios->count () > 0) {
			foreach ( $audios as $audio ) {
				if ($audio->all ()['codec_type'] == 'audio') {
					return 'audio';
				}
			}
		}
	}
	public function actionUpload() {
		$model = DynamicRecord::forModel ( $this->modelClassname );
		if (isset ( $model->_conf ['behaviors'] ['parent'] )) {
			$parentClass = $model->_conf ['behaviors'] ['parent'] ['className'];
			$parent = DynamicRecord::forModel ( $parentClass )->findOne ( $_GET ['parent'] );
			$file = UploadedFile::getInstance ( $parent, 'file' );
			DynamicRecord::done ();
			if (! $parent)
				throw new HttpException ( 404, 'Not found' );
		}
		
		$upload = new UploadForm ();
		// DynamicRecord::done();
		
		if (\Yii::$app->request->isPost) {
			// die(VarDumper::dump($file, 10, true));
			if ($file) {
				$tmp = $file->tempName;
				$model = DynamicRecord::forModel ( $this->modelClassname );
				$model->parent_id = $_GET ['parent'];
				$model->content_type = $file->type;
				$model->size = $file->size;
				$model->filename = $file->name;
				$dir = \Yii::getAlias('@web/../data/files/post');
				if (! file_exists ( $dir))
					mkdir ( $dir, 0777, true );
				
				if ($model->save ())
					$file->saveAs ( $dir . $model->id );
				$model->file =  $dir . $model->id;
				$model->save ( false, [ 
						'path' 
				] );
				$json = [ 
						"files" => [ 
								[ 
										"url" => Url::to ( [ 
												'download',
												'id' => $model->id 
										] ),
										"size" => $file->size,
										"name" => $file->name,
										'file' => $file 
								] 
						] 
				];
				
				$owner = $this->owner;
				return Json::encode ( $json );
			}
		}
	}
}

?>
