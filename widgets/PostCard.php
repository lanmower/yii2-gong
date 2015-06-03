<?php

namespace almagest\gong\widgets;



use polymer\widgets\PolymerWidget;
use yii\base\Widget;
use yii\helpers\Html;
/**
 * Post card widget
 */
class PostCard extends Widget {
	private static $_asset;
	public $tag = 'post-card';
	public $htmlOptions = [];
	public $contents;
	
	public function init() {
		if(!isset($_assets)) {
			self::$_asset = PostAssets::register ( $this->getView () );
			$this->view->registerLinkTag([
					'rel' => 'import',
					'href' => self::$_asset->baseUrl."/post-card.html",
					], $this->className());
		}
		$this->htmlOptions['html'] = $this->contents;
		echo Html::beginTag ( $this->tag, $this->htmlOptions );
		return parent::init ();
	}
	
	public function run() {
		echo Html::endTag($this->contents);
	}

}
