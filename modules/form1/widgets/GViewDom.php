<?php
class GViewDom extends GField {
	public $fieldOptions = array ();
	public $required = false;
	public $copyText = 'Copy';
	public $pasteText = 'Paste';
	public $importUrl;
	public $exportUrl;
	public function run() {
		$this->id = get_class ( $this ) . '-' . $this->hash;
		echo CHtml::beginForm ( $this->controller->createUrl ( CHtml::normalizeUrl ( $this->importUrl ) ) );
		echo CHtml::link ( $this->copyText, 'javascript:', array (
				'onclick' => "
            local = $(this);
            var ctrlKey = 17, vKey = 86, cKey = 67;
            $('.Loading').show();
            $.ajax({
                            url: '" . $this->controller->createUrl ( CHtml::normalizeUrl ( $this->exportUrl ) ) . "',
                            success: function(input) {
                                $('.Loading').hide();
                                $('.$this->id-data').text(input);
                                local.next().append().show(600).selectText().bind('copy', function() {
                                    $('.$this->id-data').hide(1000);
                                    return true;
                                });
                            }
                            
                            
                        });" 
		) );
		echo CHtml::tag ( 'div', array (
				'style' => 'display:none;position:absolute;',
				'class' => $this->id . '-data' 
		) );
		echo CHtml::link ( $this->pasteText, 'javascript:', array (
				'onclick' => 'data = $(this).parent().find(".data"); data.attr("value", window.prompt("Paste from clipboard: Ctrl+V, Enter\n")); if(data.attr("value")) $(this).parent().submit();' 
		) );
		echo CHtml::hiddenField ( 'dom', '', array (
				'class' => 'data' 
		) );
		echo CHtml::submitButton ( '', array (
				'style' => 'visibility:hidden;' 
		) );
		echo CHtml::endForm ();
		parent::run ();
	}
}

?>
