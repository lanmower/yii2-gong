<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\Item */

$this->title = $model->id;

$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Items',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = [
		'label' => 'View',
		'url' => [
				'gong/site/view/view',
				'id'=>$model->parent_id
		]
];
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="item-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a ( 'Delete', [ 'delete','id' => $model->id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ] )?>
    </p>

    <?=DetailView::widget ( [ 'model' => $model,'attributes' => [ 'id','className','json_settings:ntext','mode','prefix:ntext','suffix:ntext','content:ntext','start:ntext','end:ntext' ] ] )?>

</div>
