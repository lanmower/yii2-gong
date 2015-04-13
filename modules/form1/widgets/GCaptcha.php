<?php
class GCaptcha extends GTextField {
	public $fieldOptions = array ();
	public function run() {
		if (extension_loaded ( 'gd' )) :
			echo '<div class="Block">';
			echo '<div class="clearfix"></div>';
			echo '<div class="capatcha">';
			echo $this->widget ( 'CCaptcha', array (
					'id' => $this->id . '-captcha',
					'buttonOptions' => array (
							'class' => 'nohijack' 
					) 
			), true );
			echo '<p class="hint">';
			echo Gong::t ( 'Please enter the letters as they are shown in the image above.' );
			echo '<br/>';
			echo Gong::t ( 'Letters are not case-sensitive.' );
			echo '</p>';
			echo '</div>';
			echo '</div>';
		
        endif;
		parent::run ();
	}
}

?>
