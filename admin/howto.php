<h2>Custom .imagine[attribute] usage</h2>
<p>
	<ul>
        <li>1. To show a gallery on the frontpage add a div tag into your post with class 'imagine'</li>
		<li>2. Use attribute gid='yourgalleryid' to select a gallery.</li>
        <li>3. Use attribute template="template name" to select a template. If not set will use your default template selected in Settings.</li>
        <li>4. Or just use the code generator.</li>
	</ul>
</p>
<h2>Database syntax</h2>
<table class="imagine-table">
	<tbody>
		<h3>Images</h3>
		<tr>
			<th>ID</th>
			<td>$image->imgId;<span class="comment"> -- Used to navigate images !important</span></td>
		</tr>
		<tr>
			<th>Name</th>
			<td>$image->imgName;<span class="comment"> -- Can only be unique !important</span></td>
		</tr>
		<tr>
			<th>Slug</th>
			<td>$image->imgSlug;</td>
		</tr>
		<tr>
			<th>Filename</th>
			<td>$image->imgFilename;</td>
		</tr>
		<tr>
			<th>Size</th>
			<td>$image->imgSize;</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>$image->imgDesc;</td>
		</tr>
		<tr>
			<th>Alt title</th>
			<td>$image->imgAltTitle;</td>
		</tr>
		<tr>
			<th>Author</th>
			<td>$image->imgAuthor;</td>
		</tr>
		<tr>
			<th>Date</th>
			<td>$image->creationDate;</td>
		</tr>
		<tr>
			<th>Time</th>
			<td>$image->creationTime;</td>
		</tr>
		<tr>
			<th>Tags</th>
			<td>$image->imageTags;</td>
		</tr>
	</tbody>
</table>
<table class="imagine-table">
	<tbody>
		<h3>Galleries</h3>
		<tr>
			<th>ID</th>
			<td>$gallery->galleryId;<span class="comment"> -- Used to navigate galleries !important</span></td>
		</tr>
		<tr>
			<th>Name</th>
			<td>$gallery->galleryName;<span class="comment"> -- Can only be unique !important</span></td>
		</tr>
		<tr>
			<th>Slug</th>
			<td>$gallery->gallerySlug;</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>$gallery->galleryDesc;</td>
		</tr>
		<tr>
			<th>Path</th>
			<td>$gallery->galleryPath;</td>
		</tr>
		<tr>
			<th>Author</th>
			<td>$gallery->galleryAuthor;</td>
		</tr>
		<tr>
			<th>Date</th>
			<td>$gallery->creationDate;</td>
		</tr>
		<tr>
			<th>Time</th>
			<td>$gallery->creationTime;</td>
		</tr>
		<tr>
			<th>Preview image</th>
			<td>$gallery->galleryPreviewImg;</td>
		</tr>
	</tbody>
</table>

<hr></hr>

<div class="button" id="viewexample">View example</div>
<div class="template-example">
	
	
	
	
	
	<?php 
	
	$msg = '// This is an example of imagine-gallery-extended.php';
	echo htmlentities($msg) . '<br>';
		$dir = plugin_dir_path(__FILE__); 
		$example = $dir.'../templates/imagine-gallery-extended.php';
		$inside = 0;
		$indent = 0;
		$end = '}';
		$if = 'if';
		$each = 'foreach';
		$lines = file($example);
	    foreach ($lines as $lineNumber => $line) {
	        if (strpos($line, $each) !== false) {
	            echo htmlentities($line) . '<br>';
				$inside += 1;
	        } else if (strpos($line, $if) !== false) {
	        	
	        	if ($inside == 1) {
	            	echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' .htmlentities($line) . '<br>';
				} else {
					echo htmlentities($line) .'<br>';
				}
				$inside += 1;
	        } else if(strpos($line, $end) !== false) {
	        	if ($inside == 1) {
	        		echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.htmlentities($line) . '<br>';
				} else if ($inside = 2) {
					echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.htmlentities($line) . '<br>';		
				} else {
					echo htmlentities($line) . '<br>';	
				}
				$inside -= 1;	
	        } else if ($inside == 1){
			 	echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' . htmlentities($line) . '<br>';
			} else if ($inside == 2){
			 	echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' . htmlentities($line) . '<br>';
			} else {
	        	echo htmlentities($line) . '<br>';
	        }
	    }
	    return -1;
	
	?>
	
</div>

