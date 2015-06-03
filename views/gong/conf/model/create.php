<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\View */

$this->title = 'Create View';
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Models',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="model-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?=$this->render ( '_form', [ 'model' => $model ] )?>

</div>
