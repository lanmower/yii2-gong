<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\Layous */
/* @var $searchModel almagest\gong\modules\layout\models\LayoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Layouts';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="layout-list">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Layout', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?=GridView::widget ( [ 'dataProvider' => $dataProvider,'filterModel' => $searchModel,'columns' => [ [ 'class' => 'yii\grid\SerialColumn' ],'id','name',[ 'class' => 'yii\grid\ActionColumn' ] ] ] );?>

</div>
