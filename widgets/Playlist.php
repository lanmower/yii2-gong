<?php

namespace almagest\gong\widgets;

use Yii;
use yii\helpers\Json;
use xj\jplayer\JplayerWidget;
use yii\base\Widget;

/**
 * JPlayer Audio Widget
 *
 * @author xjflyttp <xjflyttp@gmail.com>
 * @see http://jplayer.org/latest/demo-01/
 */
class Playlist extends Widget {
	
	/**
	 * Tag Class
	 *
	 * @var string
	 */
	public $tagClass = 'jp-video jp-video-240p';
	/**
	 * render view
	 *
	 * @var string
	 */
	public $tagView = 'playlist';
	public $mediaOptions;
	public $jsOptions = [ ];
	public function run() {
		$this->registerAssets ();
		$this->registerScripts ();
		echo $this->render ( 'playlist', [ 
				'ancestorClass' => $this->id,
				'ancestorStyle' => '',
				'ancestorId' => "{$this->id}-container",
				'jplayerId' => $this->id . '-player' 
		] );
		return parent::run ();
	}
	protected function registerAssets() {
		PlaylistAssets::register ( $this->view );
	}
	protected function registerScripts() {
		$this->mediaOptions = [ 
				'title' => "Big Buck Bunny",
				'mp3' => 'http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3',
				'ogg' => 'http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.ogg' 
		];
		$jplayerSelector = '#' . $this->id . '-player';
		$jsonOptions = Json::encode ( $this->jsOptions );
		$jsonMediaOptions = Json::encode ( [ 
				$this->mediaOptions 
		] );
		$script = <<<EOF
new jPlayerPlaylist({
		jPlayer: "$jplayerSelector",
		cssSelectorAncestor: "#{$this->id}-container"
	},$jsonMediaOptions, $jsonOptions);
EOF;
		$this->view->registerJs ( $script );
	}
}
