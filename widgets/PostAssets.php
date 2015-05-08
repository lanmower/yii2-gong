<?php

namespace almagest\gong\widgets;

use Yii;
use yii\web\AssetBundle;

class PostAssets extends AssetBundle {
    public $sourcePath = '@vendor/almagestfraternite/yii-gong/widgets/assets';
    public $publishOptions = ['forceCopy' => YII_DEBUG];
    public $css = [];
    public $depends = ['polymer\components\PolymerAssets'];
    public $js = [];

}
