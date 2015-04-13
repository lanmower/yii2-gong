<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\Item */

$this->title = 'Update Item: ' . ' ' . $model->id;
$this->params ['breadcrumbs'] [] = [
		'label' => 'Layout',
		'url' => [
				'gong/site/layout/view',
				'id'=>$model->parent_id
		]
];

$this->params ['breadcrumbs'] [] = 'Update';
?>
<div class="item-update">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
