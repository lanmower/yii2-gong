<?php

namespace almagest\gong\widgets;

use Yii;
use yii\web\AssetBundle;

class PlaylistAssets extends AssetBundle {

    public $basePath = '@webroot/assets';
    public $sourcePath = '@vendor/happyworm/jplayer/dist';
    public $publishOptions = ['forceCopy' => YII_DEBUG];
    public $css = ['skin/blue.monday/css/jplayer.blue.monday.min.css'];
    public $depends = ['yii\web\JqueryAsset'];
    public $js = [
        'add-on/jplayer.playlist.min.js',
    	'jplayer/jquery.jplayer.min.js'
    ];

}
