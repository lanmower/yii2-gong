<?php
class GSiteDomController extends GModelController {
	private $childClassname;
	private $msg;
	public function accessRules() {
		$rules = parent::accessRules ();
		self::addRule ( $rules, array (
				'allow',
				'actions' => array (
						'import' 
				),
				'users' => array (
						'*' 
				) 
		) );
		self::addRule ( $rules, array (
				'allow',
				'actions' => array (
						'batchExport',
						'batchImport' 
				),
				'users' => array (
						'*' 
				) 
		) );
		return $rules;
	}
	public function import($model, &$dom) {
		$domChildren = $dom ['children'];
		unset ( $dom ['children'] );
		foreach ( $domChildren as $domKey => $domChild ) {
			unset ( $domChild ['id'] );
			$domChild ['parentId'] = $model->id;
		}
		
		$newChildren = array ();
		$updatedChildren = array ();
		$childClassname = $this->childClassname;
		foreach ( $model->children as $modelKey => $modelChild ) {
			foreach ( $domChildren as $domKey => $domChild ) {
				if ($modelChild->name == $domChild ['name']) {
					$modelChild->attributes = $domChild;
					if ($modelChild->save ()) {
						$updatedChildren [] = $modelChild;
						unset ( $domChildren [$domKey] );
					}
				}
			}
		}
		foreach ( $domChildren as $domKey => $domChild ) {
			$child = new $childClassname ();
			$domChild ['parentId'] = PseudoCrypt::hash ( $model->id );
			$child->attributes = $domChild;
			if ($child->save ()) {
				$newChildren [] = $child;
				unset ( $domChildren [$domKey] );
			}
		}
		
		if (sizeof ( $domChildren ))
			$this->msg .= CHtml::tag ( 'div', array (), sizeof ( $domChildren ) . 'Children unprocessed '/* .CVarDumper::dumpAsString($domChildren, 3, true) */);
		if (sizeof ( $updatedChildren ))
			$this->msg .= CHtml::tag ( 'div', array (), sizeof ( $updatedChildren ) . 'Children updated '/* .CVarDumper::dumpAsString($updatedChildren, 3, true) */);
		if (sizeof ( $newChildren ))
			$this->msg .= CHtml::tag ( 'div', array (), sizeof ( $newChildren ) . 'New children saved '/* .CVarDumper::dumpAsString($newChildren, 3, true) */);
		return $dom;
	}
	public function actionImport($type, $id) {
		$modelClassName = $this->modelClassname = 'GSite' . ucfirst ( $type );
		$this->childClassname = 'GSite' . ucfirst ( $type ) . 'Element';
		if (isset ( $_POST ['dom'] )) {
			$v = CJSON::decode ( $_POST ['dom'] );
			$model = $modelClassName::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
			unset ( $v ['id'] );
			unset ( $v ['parentId'] );
			unset ( $v ['name'] );
			$model->attributes = $v;
			$model->save ();
			$this->import ( $model, $v );
			// $this->msg .= CHtml::tag('div', array(), 'Parent saved'/*.CVarDumper::dumpAsString($model, 2, true)*/);
			echo $this->msg;
			G::setFlash ( 'alert-info', $this->msg );
			$this->redirect ( $this->createUrl ( $type . '/view', array (
					'id' => $id 
			) ) );
		}
	}
	public function actionBatchImport($type, $id = null, $module = null, $controller = null, $name = null) {
		$modelClassName = $this->modelClassname = 'GSite' . ucfirst ( $type );
		$this->childClassname = 'GSite' . ucfirst ( $type ) . 'Element';
		
		if (isset ( $_POST ['dom'] )) {
			$children = CJSON::decode ( $_POST ['dom'], true );
			foreach ( $children as $v ) {
				$module = isset ( $module ) ? $module : $v ['module'];
				$controller = isset ( $controller ) ? $controller : $v ['controller'];
				$name = isset ( $name ) ? $name : $v ['name'];
				$model = $modelClassName::model ()->find ( 'module = :module AND controller = :controller AND name = :name', array (
						'module' => $module,
						':controller' => $controller,
						':name' => $name 
				) );
				if (! $model) {
					if (isset ( $id ))
						$model == $modelClassName::model ()->findByPk ( PseudoCrypt::unhash ( $id ) );
					else
						$model = new $modelClassName ();
				} else {
					unset ( $v ['name'] );
				}
				unset ( $v ['id'] );
				unset ( $v ['parentId'] );
				unset ( $v ['controller'] );
				unset ( $v ['module'] );
				unset ( $v ['name'] );
				$model->attributes = $v;
				$model->save ();
				$this->import ( $model, $v );
			}
		}
		G::setFlash ( 'alert-info', $this->msg );
		$this->redirect ( $this->createUrl ( $type . '/list' ) );
	}
	public function getAttributesAndChildren($model) {
		$ret = $model->attributes;
		unset ( $ret ['id'] );
		unset ( $ret ['parentId'] );
		if (isset ( $model->children )) {
			foreach ( $model->children as $child ) {
				if (! isset ( $ret ['children'] ))
					$ret ['children'] = array ();
				$ret ['children'] [] = $this->getAttributesAndChildren ( $child );
			}
		}
		return $ret;
	}
	public function actionBatchExport($type = 'view', $id = null, $module = null, $controller = null, $name = null) {
		$modelClassName = $this->modelClassname = 'GSite' . ucfirst ( $type );
		if (isset ( $id )) {
			$output = array (
					$this->getAttributesAndChildren ( $modelClassName::model ()->findByPk ( PseudoCrypt::unhash ( $id ) ) ) 
			);
		} else if (isset ( $module ) && isset ( $controller ) && isset ( $name )) {
			$output = array (
					$this->getAttributesAndChildren ( $modelClassName::select ( $module, $controller, $name ) ) 
			);
		} else if (isset ( $module ) && isset ( $controller )) {
			$views = $modelClassName::model ()->findAll ( 'module = :module AND controller = :controller', array (
					':module' => $module,
					':controller' => $controller 
			) );
			$output = array ();
			foreach ( $views as $view ) {
				$output [] = $this->getAttributesAndChildren ( $view );
			}
		} else if (isset ( $module )) {
			$views = $modelClassName::model ()->findAll ( 'module = :module', array (
					':module' => $module 
			) );
			$output = array ();
			foreach ( $views as $view ) {
				$output [] = $this->getAttributesAndChildren ( $view );
			}
		}
		// header('Content-type: application/json');
		if (isset ( $output ))
			echo CJSON::encode ( $output );
		foreach ( Yii::app ()->log->routes as $route ) {
			if ($route instanceof CWebLogRoute || $route instanceof YiiDebugToolbarRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		}
		Yii::app ()->end ();
	}
}

?>
