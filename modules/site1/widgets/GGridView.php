<?php
class GGridView extends CGridView {
	public $sort = true;
	public $sortUrl = 'reorder';
	public $ajaxUpdate = false;
	public function init() {
		$this->itemsCssClass = G::addClassToString ( $this->itemsCssClass, 'table' );
		if ($this->sort) {
			$this->rowCssClassExpression = '"items[]_{$data->hash}"';
			$this->htmlOptions ['class'] = G::addClassToString ( $this->htmlOptions ['class'], 'reorder' );
			$this->htmlOptions ['data-reorder-url'] = $this->controller->createUrl ( CHtml::normalizeUrl ( $this->sortUrl ) );
		}
		if (is_array ( $this->dataProvider )) {
			$this->dataProvider = new CArrayDataProvider ( $this->dataProvider );
		} else if (! $this->dataProvider)
			$this->dataProvider = new CArrayDataProvider ( array () );
		parent::init ();
	}
}

?>
