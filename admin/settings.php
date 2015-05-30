<form id="form" method="post" novalidate="novalidate">
	<table class="form-table">
		<thead>
			<h2>Settings:</h2>
		</thead>
		
		<tr>
			<th scope="row"> Thumbnail width: </th>
			<td>
			<input type="text" name="optionImagineThumbnailWidth" class="regular-text" value="<?php echo get_option('optionImagineThumbnailWidth'); ?>"> <p>px</p>
			</td>
		</tr>
		
		<tr>
			<th scope="row"> Default Gallery template: </th>
			<td>
			<select name="optionImagineDefaultGalleryTemplate">
				<?php $option = get_option('optionImagineDefaultGalleryTemplate'); 
					global $wpdb;
					$gtemps = $wpdb->get_results("SELECT * FROM wp_imagine_templates WHERE tempType = 'gallery'");
					foreach($gtemps as $tmp) {
						$tname = $tmp->tempName;
						
                        echo '<option value="'.esc_attr($tname).'"> ' . esc_html($tname) . '</option>';
						
					}
                    
				?>
				
			</select>
                <span class="sMsg"><?php echo 'Current default: ' .$option; ?></span>
			</td>
		</tr>
		
		<tr>
			<th scope="row"> Default Album template: </th>
			<td>
			<select name="optionImagineDefaultAlbumTemplate">
				<?php $option = get_option('optionImagineDefaultAlbumTemplate'); 
					global $wpdb;
					$gtemps = $wpdb->get_results("SELECT * FROM wp_imagine_templates WHERE tempType = 'album'");
					foreach($gtemps as $tmp) {
						$tname = $tmp->tempName;
						
                        echo '<option value="'.esc_attr($tname).'"> ' . esc_html($tname) . '</option>';
						
					}
                    
				?>
				
			</select>
                <span class="sMsg"><?php echo 'Current default: ' .$option; ?></span>
			</td>
		</tr>
		
		<tr>
			<th scope="row"> Default Image template: </th>
			<td>
			<select name="optionImagineDefaultImageTemplate">
				<?php $option = get_option('optionImagineDefaultImageTemplate'); 
					global $wpdb;
					$gtemps = $wpdb->get_results("SELECT * FROM wp_imagine_templates WHERE tempType = 'image'");
					foreach($gtemps as $tmp) {
						$tname = $tmp->tempName;
						
                        echo '<option value="'.esc_attr($tname).'"> ' . esc_html($tname) . '</option>';
						
					}
                    
				?>
				
			</select>
                <span class="sMsg"><?php echo 'Current default: ' .$option; ?></span>
			</td>
		</tr>
		
		
		
		<tr>
			<th scope="row"> Default Layover template: </th>
			<td>
			<select name="optionImagineDefaultLayoverTemplate">
				<?php $option = get_option('optionImagineDefaultLayoverTemplate'); ?>
				<option value="imagine" <?php if ($option == 'imagine') { echo 'selected'; }; ?>>Imagine</option>
			</select>
			</td>
		</tr>
	</table>
	<div id="option-submit" class="button buttom-primary" type="submit" name="option-submit" value="Opslaan">Save</div>
</form>