<?php
class GFileAudioController extends GModelController {
	public function accessRules() {
		return array (
				array (
						'allow',
						'actions' => array (
								'inlineUpdate' 
						),
						'expression' => array (
								'GPostController',
								'allowOnlyProducer' 
						) 
				),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
}
?>
