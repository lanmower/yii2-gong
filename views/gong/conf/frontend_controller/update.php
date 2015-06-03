<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\Item */

$this->title = 'Update Item: ' . ' ' . $model->id;
$this->params ['breadcrumbs'] [] = [
		'label' => 'Models',
		'url' => [
				'gong/conf/model/list',
		]
];

$this->params ['breadcrumbs'] [] = 'Update';
?>
<div class="model-update">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
