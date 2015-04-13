<?php
abstract class GElement extends GActiveRecord {
	private $_data;
	public $defaultOrder = 'weight ASC';
	public $gridColumns = array (
			array (
					'name' => 'mode',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'className',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'name',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'prefixContent',
					'class' => 'GDumpColumn' 
			),
			array (
					'name' => 'suffixContent',
					'class' => 'GDumpColumn' 
			),
			array (
					'name' => 'userAgentExclude',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'userAgentInclude',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'view',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'edit',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'delete',
					'class' => 'GEditableColumn' 
			),
			array (
					'name' => 'weight',
					'class' => 'GEditableColumn' 
			),
			array (
					'header' => 'actions',
					'class' => 'GButtonColumn',
					'template' => '{updateChild}{deleteChild}' 
			) 
	);
	public function behaviors() {
		return array (
				'Data' => array (
						'class' => 'GDataFieldBehavior',
						'attributes' => array (
								'fields' 
						) 
				),
				'Child' => array (
						'class' => 'GChildBehavior',
						'attributes' => array (
								'parentId' 
						) 
				),
				'Timestamp' => array (
						'class' => 'zii.behaviors.CTimestampBehavior',
						'createAttribute' => 'created',
						'updateAttribute' => 'modified' 
				),
				'Ownership' => array (
						'class' => 'GOwnershipBehavior',
						'attributes' => array (
								'userId' 
						) 
				),
				'Permissions' => array (
						'class' => 'GPermissionsBehavior' 
				) 
		);
	}
	public function getJson() {
		return CJavaScript::jsonEncode ( empty ( $this->fields ) ? array (
				"" => "" 
		) : $this->fields );
	}
	public function rules() {
		return array (
				array (
						'name, edit, delete, view',
						'length',
						'max' => 255 
				),
				array (
						'weight, parentId',
						'length',
						'max' => 11 
				),
				array (
						'className, fields, name, mode, suffixContent, prefixContent1',
						'safe' 
				) 
		);
	}
	public function getForm() {
		return Yii::app ()->controller->renderPartial ( '_form', array (
				'action' => 'widget/update',
				'model' => $this 
		), true );
	}
	public function addClass($class) {
		$attr = $this->fields;
		
		$attr ["htmlOptions"] ["class"] = isset ( $attr ["htmlOptions"] ["class"] ) ? $class . ' ' . $attr ["htmlOptions"] ["class"] : $class;
	}
	public function addData($name, $data) {
		$attr = $this->fields;
		$attr ["htmlOptions"] ['data-' . $name] = $data;
	}
	public function getHtml() {
		GElementRenderer::renderElement ( $this );
	}
}