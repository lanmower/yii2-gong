<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel almagest\gong\modules\view\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="item-list">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget ( [ 'dataProvider' => $dataProvider,'filterModel' => $searchModel,'columns' => [ [ 'class' => 'yii\grid\SerialColumn' ],'id','className','json_settings:ntext','mode','prefix:ntext',
// 'suffix:ntext',
// 'content:ntext',
// 'start:ntext',
// 'end:ntext',
[ 'class' => 'yii\grid\ActionColumn' ] ] ] );?>

</div>
