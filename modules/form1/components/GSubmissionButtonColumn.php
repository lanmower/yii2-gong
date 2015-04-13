<?php
class GSubmissionButtonColumn extends CButtonColumn {
	public $deleteButtonLabel = '<i class="glyphicon glyphicon-trash"></i>';
	public $updateButtonLabel = '<i class="glyphicon glyphicon-cog"></i>';
	public $updateButtonImageUrl = false;
	public $deleteButtonImageUrl = false;
	public $updateButtonUrl = 'Yii::app()->controller->createUrl("update",array("id"=>$data->form->hash, "dataId"=>Chtml::encode(CHtml::value($data, "hash"))))';
	public $deleteButtonUrl = 'Yii::app()->controller->createUrl("delete",array("id"=>$data->form->hash, "dataId"=>Chtml::encode(CHtml::value($data, "hash"))))';
	public $deleteButtonOptions = array (
			'class' => 'delete prompt',
			'title' => 'Delete' 
	);
	public $template = '{update}{delete}';
	public $buttons = array (
			'viewParent' => array (
					'label' => '<i class="glyphicon glyphicon-arrow-up"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->controllerId."/view",array("id"=>CHtml::value($data, "parent.hash")))',
					'visible' => 'CHtml::value($data, "parent")',
					'options' => array (
							'title' => 'View Parent' 
					),
					'imageUrl' => false 
			),
			'viewChild' => array (
					'label' => '<i class="glyphicon glyphicon-arrow-up"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->controllerId."/view",array("id"=>CHtml::value($data, "hash")))',
					'options' => array (
							'title' => 'View Child' 
					),
					'imageUrl' => false 
			),
			'updateChild' => array (
					'label' => '<i class="glyphicon glyphicon-edit"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->controllerId."/update",array("id"=>CHtml::value($data, "hash")))',
					'options' => array (
							'title' => 'Update Child' 
					),
					'imageUrl' => false 
			),
			'deleteChild' => array (
					'label' => '<i class="glyphicon glyphicon-trash"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->controllerId."/delete",array("id"=>CHtml::value($data, "hash")))',
					'options' => array (
							'title' => 'Delete Child',
							'class' => 'delete prompt' 
					),
					'imageUrl' => false 
			),
			'self' => array (
					'label' => '<i class="glyphicon glyphicon-arrow-up"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->controllerId."/view",array("id"=>CHtml::value($data, "hash")))',
					'options' => array (
							'title' => '' 
					),
					'imageUrl' => false 
			),
			'custom' => array (
					'label' => '<i class="glyphicon glyphicon-cog"></i>',
					'url' => 'Yii::app()->controller->createUrl($data->customUrl,array("id"=>CHtml::value($data, "hash")))',
					'options' => array (
							'title' => '' 
					),
					'imageUrl' => false 
			) 
	);
	public function init() {
		parent::init ();
	}
	protected function registerClientScript() {
	}
}

?>
