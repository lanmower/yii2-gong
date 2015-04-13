<?php
class GFormWidget extends GTag {
	public $createSubmission = null;
	public function init() {
		$this->tag = 'form';
		if (isset ( $this->createModel ) && class_exists ( $this->createModel )) {
			$createSubmission = $this->createSubmission;
			$this->controller->setVar ( 'submission', $createSubmission::model () );
		}
		if (! isset ( $this->htmlOptions ['method'] ))
			$this->htmlOptions ['method'] = 'post';
		if (! isset ( $this->htmlOptions ['action'] ))
			$this->htmlOptions ['action'] = Yii::app ()->request->requestUri;
		$form = $this->controller->getVar ( 'form' );
		parent::init ();
		if (isset ( $form ) && ! empty ( $form->children )) {
			foreach ( $form->children as $child ) {
				echo GElementRenderer::renderElement ( $child );
			}
		}
	}
	public function run() {
		parent::run ();
	}
}

?>
