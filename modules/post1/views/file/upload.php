<?php
if ($postFile->post->coverImageId != $oldCoverId) {
	// CVarDumper::dump($postFile->post->coverImageId);
	// CVarDumper::dump($oldCoverId);
	$this->renderPartial ( 'gong.modules.post.views.post.setCover', array (
			'model' => $postFile->post 
	) );
}
$this->renderPartial ( '_update', array (
		'post' => $postFile->post 
) );
?>
