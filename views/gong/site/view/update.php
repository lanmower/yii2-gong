<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\View */

$this->title = 'Update View: ' . ' ' . $model->name;
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Views',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = [ 
		'label' => $model->name,
		'url' => [ 
				'view',
				'id' => $model->id 
		] 
];
$this->params ['breadcrumbs'] [] = 'Update';
?>
<div class="view-update">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
