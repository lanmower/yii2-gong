<?php
use yii\helpers\Html;

/* @var $this yii\web\Layout */
/* @var $model almagest\gong\models\View */

$this->title = 'Update Layout: ' . ' ' . $model->name;
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Layouts',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = [ 
		'label' => $model->name,
		'url' => [ 
				'layout',
				'id' => $model->id 
		] 
];
$this->params ['breadcrumbs'] [] = 'Update';
?>
<div class="layout-update">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
