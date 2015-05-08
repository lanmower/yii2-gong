<?php

namespace almagest\gong\widgets;



use polymer\widgets\PolymerWidget;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * Post card widget
 */
class PostList extends Widget {
	private static $_asset;
	public $tag = 'post-list';
	public $htmlOptions = ['show'=>'all'];
	public $url;
	
	public function init() {
		$this->htmlOptions['url'] = $this->url;
		if(!isset($_assets)) {
			self::$_asset = PostAssets::register ( $this->getView () );
			$this->view->registerLinkTag([
					'rel' => 'import',
					'href' => self::$_asset->baseUrl."/post-list.html",
					], $this->className());
		}
		echo Html::beginTag ( $this->tag, $this->htmlOptions );
		return parent::init ();
	}

}
