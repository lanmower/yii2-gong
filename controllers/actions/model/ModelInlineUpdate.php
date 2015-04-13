<?php
namespace almagest\gong\controllers\actions\model;

class ModelInlineUpdate extends CAction {
	public function run() {
		if (isset ( $_POST ['pk'] )) {
			$profile = $this->controller->loadModel ( $_POST ['pk'] );
			$profile->setAttribute ( $_POST ['name'], $_POST ['value'] );
			if (! $profile->save ()) {
				foreach ( $profile->errors as $error )
					echo "<span class='alert-error'>{$error[0]}</span>";
				echo "<span class='alert-info pointer'>try again</span>";
			} else {
				echo CHtml::value ( $profile, $_POST ['name'] );
			}
		}
	}
}

?>
