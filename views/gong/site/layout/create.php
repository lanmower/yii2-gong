<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\View */

$this->title = 'Create Layout';
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Layouts',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="layout-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
