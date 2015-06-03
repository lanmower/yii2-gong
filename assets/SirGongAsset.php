<?php


namespace almagest\gong\assets;

use Yii;
use yii\web\AssetBundle;

class SirGongAsset extends AssetBundle {

    public $language;
    public $sourcePath = '@vendor/almagestfraternite/yii-gong/widgets/assets';
    public $publishOptions = ['forceCopy' => YII_DEBUG];
    
    public $js = [
        "test.js",
    ];
}