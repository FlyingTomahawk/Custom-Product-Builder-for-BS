<?php
/*
  $Id: builder_singles_header.php, v 1.1.0 2008/11/28 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
*/
?>
     
<?php
  if ($cpb_build_name_suffix) {
    $build_name_note = TEXT_BUILD_NAME_NOTE;
  }
  
	if ($cpb_build_allow_name) {  
		echo HEADING_BUILD_NAME . '&nbsp;' . tep_draw_input_field('edit_build_name',$cpb_build_name) . '&nbsp;' . $build_name_note; 
	} else {
		echo HEADING_BUILD_NAME . '&nbsp;' . $cpb_build_name . '&nbsp;' . $build_name_note; 
	}
	
	if ($cpb_build_allow_description) {
        echo HEADING_BUILD_DESCRIPTION . '&nbsp;' . tep_draw_input_field('edit_build_description',$cpb_build_description,'size=80'); 
	} else {
		echo HEADING_BUILD_DESCRIPTION . '&nbsp;' . $cpb_build_description; 
	}
	
	if ($cpb_build_allow_image) {
		$the_files_array = Array();
		$handle = opendir('images/' . $cpb_product_images_folder);
		while (false!== ($file = readdir($handle))) {
		  if ($file!= "." && $file!= ".." &&!is_dir($file)) {
			$namearr = split('\.',$file);
			if (($namearr[count($namearr)-1] == 'gif') || ($namearr[count($namearr)-1] == 'jpg') || ($namearr[count($namearr)-1] == 'png')) {
			  $the_files_array[] = array( 'text' => $file, 'id' => $file);
			}
		  }
		}
		natsort($the_files_array);
		closedir($handle);
?>
<script>
var imagesdir="<?php echo 'images/' . $cpb_product_images_folder;?>";
</script>
<?php       
            
		echo HEADING_BUILD_IMAGE; 
		echo '&nbsp;' . tep_draw_pull_down_menu('edit_build_image', $the_files_array, $cpb_build_image, 'onChange="build_image.src=imagesdir+this.value;" style="width: 20em;"');
	} else {
		echo HEADING_BUILD_IMAGE . '&nbsp;' . $cpb_build_image; 
	}
	
	if ($cpb_build_allow_image_upload) {
		echo HEADING_UPLOAD_IMAGE . '&nbsp;' . tep_draw_input_field('edit_build_image_upload',$cpb_build_image_upload,'size=35','file'); 
		if ($upload_error) echo "<font color='red' size='1'><b>" . TEXT_BUILD_COMPONENT_ERROR . "</b></font>";            
	} 
	
	if ($cpb_build_model_suffix) {
		$build_model_note = TEXT_BUILD_MODEL_NOTE;
	}
		echo HEADING_BUILD_MODEL . '&nbsp;[' . $cpb_build_model . '] ' . $build_model_note; 

	if ($cpb_build_show_url) {
		if ($cpb_build_url_suffix) {
		  $build_url_note = TEXT_BUILD_URL_NOTE;
		}
		echo HEADING_BUILD_URL . '&nbsp;' . $cpb_build_url . '&nbsp;' . $build_url_note;
	}

	if ($cpb_build_show_built_by) {
		if (!$cpb_build_built_by) {
		  $cpb_build_built_by = $cpb_build_built_by_default;
		  if (tep_session_is_registered('customer_id')) {
			$cpb_build_built_by = $customer_first_name;
		  }
		}
		if ($cpb_build_allow_built_by) {
			echo HEADING_BUILD_BUILT_BY . '&nbsp;' . tep_draw_input_field('edit_build_built_by',$cpb_build_built_by,'size=15');
		} else {
			echo HEADING_BUILD_BUILT_BY . '&nbsp;' . $cpb_build_built_by . tep_draw_hidden_field('edit_build_built_by',$cpb_build_built_by);
		}
	}
?>
<!-- end of singles module -->