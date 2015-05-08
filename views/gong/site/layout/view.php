<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use almagest\gong\widgets\ChildGrid;

/* @var $this yii\web\View */
/* @var $model almagest\gong\models\View */

$this->title = $model->name;
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Layouts',
		'url' => [ 
				'list' 
		] 
];
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="layout-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a ( 'Delete', [ 'delete','id' => $model->id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => 'Are you sure you want to delete this item?','method' => 'post' ] ] )?>
    </p>

    <?=DetailView::widget ( [ 'model' => $model,'attributes' => [ 'id','name' ] ] )?>
    <?php 
    if(isset($model->_conf['behaviors']['children'])) {$className = $model->_conf['behaviors']['children']['className'];
    echo Html::a('Create', [$className.'/create', 'parent'=>$model->id], ['class' => 'btn btn-success']);
    }
	echo ChildGrid::widget ( [ 
			'model' => $model,
			//'searchModel' => new ItemSearch () 
	] );
	?>    

</div>
