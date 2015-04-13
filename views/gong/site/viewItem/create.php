<?php

use almagest\gong\components\DynamicRecord;
use yii\helpers\VarDumper;

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\Item */

$this->title = 'Create Item';
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Items',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = $this->title;


?>
<div class="item-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
