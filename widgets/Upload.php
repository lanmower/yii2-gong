<?php

namespace almagest\gong\widgets;

use yii\helpers\VarDumper;
use yii\helpers\Html;
use yii\helpers\Url;
class Upload extends \yii\base\Widget {
	public $url = 'upload';
    public $label = 'Upload';
    public $model;
	public $htmlOptions = ['class'=>'btn btn-primary'];
	public function run() {
		//die(Url::to($this->url));
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['multiple'] = true;
		$this->htmlOptions['onclick'] = 'window.uploader.fileupload( "option", "url", "'.Url::to($this->url).'");';
		echo Html::fileInput($this->model->formName().'[file]', 'Upload', $this->htmlOptions);
		 $this->view->registerJs("
		$('#$this->id').bind('change', function (e) {
			window.uploader.fileupload('add', {
				files: e.target.files || [{name: this.value}],
				fileInput: $(this)
			});
		 	$('#showUploads').addClass('in');
		});
		");
	}
}
