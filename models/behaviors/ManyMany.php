<?php

namespace almagest\gong\models\behaviors;

use yii\base\Behavior;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use almagest\gong\components\DynamicRecord;

class ManyMany extends Behavior {
	public $name;
	public $className;
	public $pk = 'id';
	public $fk = 'id';
	public $viaPk;
	public $viaFk;
	public $viaTable;
	
    public function hasMethod($name)
    {
        $attribute = strtolower(preg_replace('/^get(.*)/isU', '', $name));
        if($this->name == $attribute) return true;
        return parent::hasMethod($name);
    }

    public function __call($name, $params)
    {
        $attribute = strtolower(preg_replace('/^get(.*)/isU', '', $name));
        if($this->name == $attribute) return $this->getRelation();
        return parent::__call($name, $params);
    }

    public function canGetProperty($name, $checkVars = true)
    {
        $attribute = strtolower(preg_replace('/^get(.*)/isU', '', $name));
        if($this->name == $attribute) return true;
        return parent::canGetProperty($name, $checkVars);
    }

    public function __get($name)
    {
    	$attribute = strtolower(preg_replace('/^get(.*)/isU', '', $name));
    	if($this->name == $attribute) return $this->getRelation();
        return parent::__get($name);
    }
    
    public function getRelation() {
    	$query = DynamicRecord::forModel($this->className)->find();
    	if(!$query) {
    		$class = $this->className;
    		$query = $class::find();
    	}
    	$query->primaryModel = $this->owner;
    	$query->link = [$this->pk => $this->viaPk];
    	$query->multiple = true;
    	$query->viaTable ( $this->viaTable, [ 
				$this->viaFk => $this->fk
		] );
    	return $query;
    }
}