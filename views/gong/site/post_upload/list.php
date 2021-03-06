<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel almagest\gong\modules\view\models\ViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploads';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="upload-list">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget ( [ 'dataProvider' => $dataProvider,'filterModel' => $searchModel,'columns' => [ [ 'class' => 'yii\grid\SerialColumn' ],'id','filename',[ 'class' => 'yii\grid\ActionColumn' ] ] ] );?>

</div>
