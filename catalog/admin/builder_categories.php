<?php
/*
  $Id: builder_categories.php, v 1.1.0 2008/09/30 22:50:51 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');

$action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
if (tep_not_null($action)) {
  switch ($action) {

// update builder settings
    case 'update':

// create tables if they dont exist ---------------------------
      if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE '" . TABLE_BUILDER_OPTIONS . "'"))==1) {

// update categories
        $pcount=0;
        $pbcomp_query = tep_db_query("select * from " . TABLE_BUILDER_CATEGORIES . " ORDER BY cpb_category_id");
        while ($pbcomp = tep_db_fetch_array($pbcomp_query)){
          $temp = $pbcomp['cpb_category_name'];
          $temp1 = $_POST{editid.$pcount};
          $temp2 = $_POST{editoscat.$pcount};
          $temp3 = $_POST{editimage.$pcount};
          $temp4 = $_POST{newdepcat.$pcount};
          if ($temp1 != $pbcomp['cpb_category_id']) {
            $did_update = 1; tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET cpb_category_id ='".$temp1."' WHERE cpb_category_name ='".$temp."'");
          }
          if ($temp2 != $pbcomp['osc_category_id']) {
            $did_update = 1; tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET osc_category_id ='".$temp2."' WHERE cpb_category_name ='".$temp."'");
          }
          if ($temp3 != $pbcomp['cpb_category_image']) {
            $did_update = 1; tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET cpb_category_image ='".$temp3."' WHERE cpb_category_name ='".$temp."'");
          }
          if ($temp4 != $pbcomp['cpb_depends_category_id']) {
            $did_update = 1; tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET cpb_depends_category_id ='".$temp4."' WHERE cpb_category_name ='".$temp."'");
          }
          if ($did_update == 1) {
            $did_update = ""; $messageStack->add_session("Category $temp updated successfully", 'success');
          }
          $pcount++;
        }

// Add new row - if the category does not already exist
        $newrow = $_POST{newrow};
        $neworder = $_POST{neworder};
        $newimage = $_POST{newimage};
        $newoscat = $_POST{newoscat};
        
        if( $newrow != "") {
          $result1_query = tep_db_query("select cpb_category_id FROM " . TABLE_BUILDER_CATEGORIES . " WHERE cpb_category_name = '".$newrow."'");
          $result1 = tep_db_num_rows($result1_query);
          if ($result1 != 1) {
            $result1 = tep_db_query("INSERT INTO " . TABLE_BUILDER_CATEGORIES . " (`cpb_category_id` , `cpb_depends_category_id`, `cpb_category_name` , `cpb_category_image` , `osc_category_id`) VALUES ('".$neworder."' , '0', '".$newrow."' , '$newimage' , '$newoscat');");
            if ($result1 == 1) {
              $messageStack->add_session("New Builder category '$newrow' added successfully", 'success');
            } else {
              $messageStack->add_session("New Builder category '$newrow' Not added! Database Error", 'error');
            }
          } else {
            $messageStack->add_session("Builder category '$newrow' already exists!", 'error');
          }
          $result1 = "";
          $newrow = "";
        }

// Remove row - including dependences and dependents - orphaned dependent builder categories reset to zero
        $delrow = $_POST{delrow};
        
        if ( $delrow != "") {
          $result1_query = tep_db_query("select cpb_category_id FROM " . TABLE_BUILDER_CATEGORIES . " WHERE cpb_category_name = '".$delrow."'");
          $result1 = tep_db_num_rows($result1_query);
          if ($result1 > 0) {
            $osc_cat_query_raw = "select osc_category_id, cpb_depends_category_id, cpb_category_id FROM " . TABLE_BUILDER_CATEGORIES . "  where cpb_category_name = '".$delrow."'";
            $osc_cat_query = tep_db_query($osc_cat_query_raw);
            $builder_category = tep_db_fetch_array($osc_cat_query);
            $list_of_categories[] = $builder_category['osc_category_id'];
            $where_str="(categories_id = '". $builder_category['osc_category_id'] . "'";
            foreach($list_of_categories as $temp) {
              $where_str .= " or categories_id = '" . $temp . "'";
              $subcategories_array = array();
              tep_get_subcategories($subcategories_array, $temp);
              for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
                $where_str .= " or categories_id = '" . (int)$subcategories_array[$i] . "'";
              }
              unset($subcategories_array);
            }
            $where_str .= ")";
            $products_query_raw = "select products_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " where " . $where_str . " ORDER BY products_id";
            $products_query = tep_db_query($products_query_raw);
            $where_str="";
            $x=0;
            while ($products = tep_db_fetch_array($products_query)) {
              if ($x<1) {
                $where_str .= "product1_id = '" . (int)$products['products_id'] . "' or product2_id = '" . (int)$products['products_id'] . "'";
              } else {
                $where_str .= " or product1_id = '" . (int)$products['products_id'] . "' or product2_id = '" . (int)$products['products_id'] . "'";
              }
              $x++;
            }
            $result3 = tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET cpb_depends_category_id = '0' WHERE cpb_depends_category_id ='" . (int)$builder_category['cpb_category_id'] . "'");
            $result1 = tep_db_query("DELETE FROM " . TABLE_BUILDER_CATEGORIES . " WHERE cpb_category_name = '".$delrow."'");
            if (tep_db_num_rows($products_query)) {
              $result2 = tep_db_query("DELETE FROM " . TABLE_BUILDER_DEPENDENCES . " WHERE " . $where_str);
            }
            if ($result1 != 0) {
              $messageStack->add_session("Builder category '$delrow' removed successfully", 'success');
              if ($result2 == 1) {
                $messageStack->add_session("Dependence definitions removed successfully", 'success');
              }
              if ($result3 == 1) {
                $messageStack->add_session("Builder categories dependence updated", 'success');
              }
            } else {
              $messageStack->add_session("Builder category '$delrow' Not removed! Database Error", 'error');
            }
          } else {
            $messageStack->add_session("Builder category '$delrow' does not exist!", 'error');
          }
          $result1 = "";
          $result2 = "";
          $result3 = "";
          $delrow = "";
        }

// Rename row - check if old name exists and that the new one does not
        $fromrow = $_POST{fromrow};
        $torow = $_POST{torow};
        
        if( $fromrow != "" && ( $torow != "" )) {
          $result1_query = tep_db_query("select cpb_category_id FROM " . TABLE_BUILDER_CATEGORIES . " WHERE cpb_category_name = '".$fromrow."'");
          $result1 = tep_db_num_rows($result1_query);
          $result2_query = tep_db_query("select cpb_category_id FROM " . TABLE_BUILDER_CATEGORIES . " WHERE cpb_category_name = '".$torow."'");
          $result2 = tep_db_num_rows($result2_query);
          if ($result1 == 1) {
            if ($result2 != 1){
              $result1 = tep_db_query("UPDATE " . TABLE_BUILDER_CATEGORIES . " SET cpb_category_name ='".$torow."' WHERE cpb_category_name ='".$fromrow."'");
              if ($result1 == 1) {
                $messageStack->add_session("Builder category '$fromrow' renamed to '$torow' successfully", 'success');
              } else {
                $messageStack->add_session("Builder category '$fromrow' NOT renamed to '$torow', Database Error", 'error');
              }
            } else {
              $messageStack->add_session("Builder category '$torow' already exists! ", 'error');
            }
          } else {
            $messageStack->add_session("Builder category '$fromrow' does not exist!! ", 'error');
          }
          $result1 = "";
          $result2 = "";
          $fromrow = "";
          $torow = "";
        }
      }
      tep_redirect(tep_href_link('builder_categories.php'));
    break;
  }
} else {
  if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE '" . TABLE_BUILDER_OPTIONS . "'"))!=1) {
    tep_redirect(tep_href_link('builder_options.php'));
  }

// Get info from OSC categories discription table
  $count=0;
  $c_query = tep_db_query("select categories_name, categories_id from " . TABLE_CATEGORIES_DESCRIPTION . " where language_id ='".(int)$languages_id."' ORDER BY categories_id");
  while ($c_value = tep_db_fetch_array($c_query)){
    $category['name'][$count]=$c_value['categories_name'];
    $category['id'][$count]=$c_value['categories_id'];
    $count++;
  }

// Get info from OSC categories table
  $count=0;
  $c_query = tep_db_query("select categories_id, parent_id from " . TABLE_CATEGORIES . " ORDER BY categories_id");
  while ($c_value = tep_db_fetch_array($c_query)){
    if ($c_value['parent_id'] != "0") {
      $category['name'][$count] = "--".$category['name'][$count];
    }
    $count++;
  }

// be sure the tables already exist
  if(tep_db_num_rows(tep_db_query("SHOW TABLES LIKE '" . TABLE_BUILDER_CATEGORIES. "'"))==1) {

// get options
    $cbcomp_query = tep_db_query("select * from " . TABLE_BUILDER_OPTIONS);
    while ($cbcomp = tep_db_fetch_array($cbcomp_query)) {
      $cpb_product_builder_name= $cbcomp['cpb_product_builder_name'];
      $cpb_product_builder_image= $cbcomp['cpb_product_builder_image'];
      $cpb_category_images_folder= $cbcomp['cpb_category_images_folder'];
    }

// get categories
    $pcount=0;
    $bcomp_query = tep_db_query("select * from " . TABLE_BUILDER_CATEGORIES. " ORDER BY cpb_category_id");
    while ($bcomp = tep_db_fetch_array($bcomp_query)){
      $pcid[$pcount]= $bcomp['cpb_category_id'];
      $pccat[$pcount]= $bcomp['cpb_category_name'];
      $pcimg[$pcount]= $bcomp['cpb_category_image'];
      $osccat[$pcount]= $bcomp['osc_category_id'];
      $pcdepcat[$pcount] = $bcomp['cpb_depends_category_id'];
      $pcount++;
    }
  } else {
      tep_redirect(tep_href_link('builder_options.php'));
  }
}

        require('includes/template_top.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>

    <td width="100%" valign="top"><?php echo tep_draw_form('builder', 'builder_categories.php', tep_get_all_get_params(array('action')) . 'action=update', 'post', '');?><table border="0" width="100%" cellspacing="0" cellpadding="2">

<!-- HEADER CONTENT STARTS HERE -->

      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo $cpb_product_builder_name . '&nbsp;-&nbsp;' . HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image('images/table_background_builder.gif', $cpb_product_builder_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

<!-- FORM CONTENT STARTS HERE -->

      <table width="100%" border="0" cellspacing="0" cellpadding="3">

<!-- BUILDER CATEGORY SETTINGS START HERE -->

        <tr>
          <td colspan="2">
            <table width="100%" bgcolor="#CFDFEF" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" align="center"><?php echo DISPLAY_ORDER; ?></td>
                <td class="smallText" align="left"><?php echo BUILDER_CAT; ?></td>
                <td class="smallText" align="center"><?php echo IMAGE_NAME; ?></td>
                <td class="smallText" align="center"><?php echo PRODUCTS_CATEGORY; ?></td>
                <td class="smallText" align="center"><?php echo BUILDER_DEPENDS_CAT; ?></td>
              </tr>
<?php
$output = $pcount;
for ($i = 0; $i < $output; $i++) {
  echo '<tr>';
  echo '<td><center><input type="text" name="editid'.$i.'" value="'.$pcid[$i].'" size="2"></td>';
  echo '<td class="main"><b><FONT color=#1419FE><nobr>'.$pccat[$i].'</nobr></FONT></b></td>';
  echo '<td><center>';
// get filelist
  $the_files_array = Array();
  $handle = opendir(DIR_FS_CATALOG . 'images/' . $cpb_category_images_folder);
  while (false!== ($file = readdir($handle))) {
    if ($file!= "." && $file!= ".." &&!is_dir($file)) {
	  $namearr = preg_split('/\./',$file);
      if (($namearr[count($namearr)-1] == 'gif') || ($namearr[count($namearr)-1] == 'jpg') || ($namearr[count($namearr)-1] == 'png')) {
	   $the_files_array[] = array( 'text' => $file, 'id' => $file);
      }
    }
  }
  closedir($handle);
  echo tep_draw_pull_down_menu('editimage'.$i , $the_files_array, $pcimg[$i], 'style="width: 15em;"');
  echo '</td>';
  echo '<td class="main" align="center">';
  echo tep_draw_pull_down_menu('editoscat'.$i, tep_get_category_tree(0, '', '0', '', false), $osccat[$i]);
  echo "</td>\n";
    echo '<td class="main" align="center">';
    echo "<select name=\"newdepcat".$i."\">";
    $post.= '<option value="0"';
    if ($pcdepcat[$i]==0) $post.=" selected";
    $post.=">none</option>\n";
// and then add the categories to the options list
    for ($ib=0, $n=$count; $ib<$output; $ib++) {
      $post.= '<option value="'.$pcid[$ib].'"';
      if ($pcdepcat[$i]==$pcid[$ib]) $post.=" selected";
      $post.=">".$pccat[$ib]."</option>\n";
    }
    echo $post;
    echo "</select>\n";
if ($pcdepcat[$i] > 0) {
    echo '&nbsp;<a href="' . tep_href_link( 'builder_dependences.php' , 'cID=' . $pcid[$i] . '') . '">' . tep_image_button('button_depends.gif', IMAGE_BUTTON_DEPENDS) . '</a>';
} else {
    echo '&nbsp;' . tep_image_button('button_no_depends.gif', IMAGE_BUTTON_NO_DEPENDS);
}
    $post=NULL;
    echo "</td>\n";
//  }
  echo "</tr>\n";
}
?>
            </table>
          </td>
        </tr>
        <tr>
          <td width="70%">
            <table bgcolor="#CFDFEF" width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="3" align="left"><?php echo TEXT_BUILDER_MAINTENANCE; ?></td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
              <tr class="main" align="center">
                <td width="30%" rowspan="4"><B><?php echo ADD_NEW_CAT;?></B></td>
                <td width="25%" align="right"><?php echo DISPLAY_ORDER;?></td>
                <td align="left"><input type="text" name="neworder" value="<?php echo ($pcount+1); ?>" size="2"></td>
              </tr>
<?php
$the_files_array = Array();
$handle = opendir(DIR_FS_CATALOG . 'images/' . $cpb_category_images_folder);
while (false!== ($file = readdir($handle))) {
  if ($file!= "." && $file!= ".." &&!is_dir($file)) {
    $namearr = preg_split('/\./',$file);
    if (($namearr[count($namearr)-1] == 'gif') || ($namearr[count($namearr)-1] == 'jpg') || ($namearr[count($namearr)-1] == 'png')) {
      $the_files_array[] = array( 'text' => $file, 'id' => $file);
    }
  }
}
closedir($handle);
?>
              <tr class="main">
                <td align="right"><?php echo IMAGE_NAME;?></td>
                <td align="left"><?php echo tep_draw_pull_down_menu('newimage', $the_files_array, $newimage, 'style="width: 20em;"');?></td>
              </tr>

              <tr class="main">
                <td align="right"><?php echo BUILDER_CAT;?></td>
                <td align="left"><input type="text" name="newrow"></td>
              </tr>
              <tr class="main">
                <td align="right"><?php echo PRODUCTS_CATEGORY;?></td>
                <td align="left"><?php echo tep_draw_pull_down_menu('newoscat', tep_get_category_tree(0, '', '0', '', false)); ?></td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
            </table>
            <table bgcolor="#CFDFEF" width="100%" border="0" cellpadding="3">
              <tr class="main" align="center">
                <td width="30%"><B><?php echo REMOVE_CAT;?></B></td>
                <td width="25%" align="right"><?php echo CAT_NAMED;?></td>
                <td align="left"><input type="text" name="delrow"></td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
            </table>
            <table bgcolor="#CFDFEF" width="100%" border="0" cellpadding="3">
              <tr class="main" align="center">
                <td width="30%" rowspan="2"><B><?php echo RENAME_CAT;?></B></td>
                <td width="25%" align="right"><?php echo CAT_FROM;?></td>
                <td align="left"><input type="text" name="fromrow"></td>
              </tr>
              <tr class="main" align="center" valign="middle">
                <td align="right"><?php echo CAT_TO;?></td>
                <td align="left"><input type="text" name="torow"></td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
            </table>
          </td>
          <td width="30%" valign="top" rowspan="11">
            <table bgcolor="#CFDFEF" width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" align="left"><?php echo TEXT_BUILDER_UPDATE; ?></td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
              <tr>
                <td align="center" class="main">
                  <?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE);?>
                </td>
              </tr>
              <tr class="main">
                <td><?php echo '<br>'; ?></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </table>

<?php
  require('includes/template_bottom.php');
  require('includes/application_bottom.php');
?>
