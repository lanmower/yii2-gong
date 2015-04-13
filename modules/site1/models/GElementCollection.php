<?php
Yii::import ( "gong.modules.site.models.GElement" );

/**
 * This is the model class for table "template".
 *
 * @property string $id
 * @property string $name
 * @property string $edit
 * @property string $delete
 * @property string $view
 * @property string $created
 * @property string $modified
 * @property string $weight
 */
abstract class GElementCollection extends GActiveRecord {
	public function getLabel() {
		return lcfirst ( str_replace ( 'GSite', '', get_class ( $this ) ) );
	}
	public function getChildModel() {
		$childClass = $this->modelClassName . 'Element';
		return $childClass::model ();
	}
	public function getGridColumns() {
		return array (
				array (
						'name' => 'name',
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
						'template' => '{self}{delete}' 
				) 
		);
	}
	public function behaviors() {
		return array (
				'DeleteChildren' => array (
						'class' => 'GDeleteChildrenBehavior',
						'childAttributes' => array (
								'children' 
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
	public function rules() {
		return array (
				array (
						'name, edit, delete, view',
						'length',
						'max' => 255 
				),
				array (
						'weight',
						'length',
						'max' => 11 
				),
				array (
						'name',
						'safe' 
				) 
		);
	}
}