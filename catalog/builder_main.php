<?php
/*
  $Id: builder_main.php, v 1.1.0 2008/11/26 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public Lice<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">nse
*/

require('includes/application_top.php');
//print_r($_GET);
//print_r($_POST);
//print_r($_FILES);
require('includes/languages' . '/' . $language . '/' . 'builder_main.php');
// get info from OSC currency tables
$currency_symb_query = tep_db_query("select symbol_left, symbol_right, decimal_point, thousands_point, decimal_places from " . TABLE_CURRENCIES . " where code='".$currency."'");
$currency_symb = tep_db_fetch_array($currency_symb_query);

// check if the builder tables exist
// if tables exist, get all category options into an array, otherwise bomb with error
if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE '" . TABLE_BUILDER_OPTIONS . "'"))==1) {

// get builder options
  $cbcomp_query = tep_db_query("select * from " . TABLE_BUILDER_OPTIONS);
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $cpb_system_assembly= $cbcomp['cpb_system_assembly'];
    $cpb_assembly_osccat= $cbcomp['cpb_assembly_osccat'];
    $cpb_build_osccat= $cbcomp['cpb_build_osccat'];
    $cpb_use_dependence= $cbcomp['cpb_use_dependence'];
    $cpb_use_software= $cbcomp['cpb_use_software'];
    $cpb_build_name= $cbcomp['cpb_build_name'];
    $cpb_build_description= $cbcomp['cpb_build_description'];
    $cpb_build_image= $cbcomp['cpb_build_image'];
    $cpb_build_url= $cbcomp['cpb_build_url'];
    $cpb_build_model= $cbcomp['cpb_build_model'];
    $cpb_build_model_suffix= $cbcomp['cpb_build_model_suffix'];
    $cpb_build_one_product= $cbcomp['cpb_build_one_product'];
    $cpb_reduce_stock= $cbcomp['cpb_reduce_stock'];
    $cpb_popup_offset_left= $cbcomp['cpb_popup_offset_left'];
    $cpb_popup_offset_top= $cbcomp['cpb_popup_offset_top'];
    $cpb_popup_height= $cbcomp['cpb_popup_height'];
    $cpb_product_builder_name= $cbcomp['cpb_product_builder_name'];
    $cpb_ignore_specials= $cbcomp['cpb_ignore_specials'];
    $cpb_build_allow_nostock= $cbcomp['cpb_build_allow_nostock'];
    $cpb_build_allow_image= $cbcomp['cpb_build_allow_image'];
    $cpb_build_allow_description= $cbcomp['cpb_build_allow_description'];
    $cpb_build_allow_name= $cbcomp['cpb_build_allow_name'];
    $cpb_build_allow_disabled= $cbcomp['cpb_build_allow_disabled'];
    $cpb_build_allow_disable_product= $cbcomp['cpb_build_allow_disable_product'];
    $cpb_build_show_product_image= $cbcomp['cpb_build_show_product_image'];
    $cpb_build_show_product_quantity= $cbcomp['cpb_build_show_product_quantity'];
    $cpb_build_allow_quantity= $cbcomp['cpb_build_allow_quantity'];
    $cpb_build_product_image_height= $cbcomp['cpb_build_product_image_height'];
    $cpb_build_product_image_width= $cbcomp['cpb_build_product_image_width'];
    $cpb_popup_product_image_height= $cbcomp['cpb_popup_product_image_height'];
    $cpb_popup_product_image_width= $cbcomp['cpb_popup_product_image_width'];
    $cpb_category_images_folder= $cbcomp['cpb_category_images_folder'];
    $cpb_product_images_folder= $cbcomp['cpb_product_images_folder'];
    $cpb_build_product_price_fix= $cbcomp['cpb_build_product_price_fix'];
    $cpb_build_assembly_image= $cbcomp['cpb_build_assembly_image'];
    $cpb_build_allow_set_type= $cbcomp['cpb_build_allow_set_type'];
    $cpb_build_show_built_by= $cbcomp['cpb_build_show_built_by'];
    $cpb_build_show_url= $cbcomp['cpb_build_show_url'];
    $cpb_build_url_suffix= $cbcomp['cpb_build_url_suffix'];
    $cpb_build_in_reverse= $cbcomp['cpb_build_in_reverse'];
    $cpb_build_price_in_description= $cbcomp['cpb_build_price_in_description'];
    $cpb_build_assembly_fee_name= $cbcomp['cpb_build_assembly_fee_name'];
    $cpb_build_allow_built_by= $cbcomp['cpb_build_allow_built_by'];
    $cpb_build_built_by_default= $cbcomp['cpb_build_built_by_default'];
    $cpb_build_product_details_ontop= $cbcomp['cpb_build_product_details_ontop'];
    $cpb_build_product_status_default= $cbcomp['cpb_build_product_status_default'];
    $cpb_build_product_stock_default= $cbcomp['cpb_build_product_stock_default'];
    $cpb_build_name_suffix= $cbcomp['cpb_build_name_suffix'];
    $cpb_build_manufacturer_id_default= $cbcomp['cpb_build_manufacturer_id_default'];
    $cpb_build_component_qty_max= $cbcomp['cpb_build_component_qty_max'];
    $cpb_build_preview_single= $cbcomp['cpb_build_preview_single'];
    $cpb_build_cart_reset= $cbcomp['cpb_build_cart_reset'];
    $cpb_build_id_in_description= $cbcomp['cpb_build_id_in_description'];
    $cpb_build_auto_clear_list= $cbcomp['cpb_build_auto_clear_list'];
    $cpb_build_auto_clear_count= $cbcomp['cpb_build_auto_clear_count'];
    $cpb_build_show_category_image= $cbcomp['cpb_build_show_category_image'];
    $cpb_build_category_image_height= $cbcomp['cpb_build_category_image_height'];
    $cpb_build_category_image_width= $cbcomp['cpb_build_category_image_width'];
    $cpb_build_product_tax_class_default= $cbcomp['cpb_build_product_tax_class_default'];
    $cpb_ignore_tax= $cbcomp['cpb_ignore_tax'];
    $cpb_build_show_tax= $cbcomp['cpb_build_show_tax'];
    $cpb_build_priority= $cbcomp['cpb_build_priority'];
    $cpb_build_priority_count= $cbcomp['cpb_build_priority_count'];
    $cpb_build_minimum_order= $cbcomp['cpb_build_minimum_order'];
    $cpb_build_minimum_order_count= $cbcomp['cpb_build_minimum_order_count'];
    $cpb_auto_disable_time= $cbcomp['cpb_auto_disable_time'];
    $cpb_auto_delete_time= $cbcomp['cpb_auto_delete_time'];
    $cpb_build_allow_image_upload= $cbcomp['cpb_build_allow_image_upload'];
    $cpb_build_image_upload_size= $cbcomp['cpb_build_image_upload_size'];
    $cpb_build_image_upload_folder= $cbcomp['cpb_build_image_upload_folder'];
    $cpb_build_disable_after_carted= $cbcomp['cpb_build_disable_after_carted'];
  }

// check if the builder is enabled
  if (!$cpb_use_software) {
    tep_redirect(tep_href_link('index.php', '', 'NONSSL'));
  }

// add path to default product image
$cpb_build_final_image = $cpb_product_images_folder . $cpb_build_image;

// get builder categories - insert them into a perfect sequential array (i.e. 1,2,3,4,etc..)
  $pcount=0;
  $bcomp_query = tep_db_query("select * from " . TABLE_BUILDER_CATEGORIES . " ORDER BY cpb_category_id");
  while ($bcomp = tep_db_fetch_array($bcomp_query)){
    $pcshadowid[$pcount] = $bcomp['cpb_category_id'];
    $pcid[$pcount]= $pcount+1;
    $pccat[$pcount]= $bcomp['cpb_category_name'];
    $pcdcat[$pcount]= $bcomp['cpb_depends_category_id'];
    $pcimg[$pcount]= $bcomp['cpb_category_image'];
    $osccat[$pcount]= $bcomp['osc_category_id'];
    $pcount++;
  }

// builder category count, autoclear and priority counts setup
  $total_builder_categories = $pcount;
  if ($cpb_system_assembly) {
    $total_builder_categories++;
  }
// SETUP AUTO-CLEAR LIST
  if ($cpb_build_auto_clear_list) {
    if ($cpb_build_auto_clear_count < 1) {
      $cpb_build_auto_clear_count = $total_builder_categories;
    }
  } else {
    $cpb_build_auto_clear_count = 0;
  }
// SETUP PRIORITY BUILDING
  if ($cpb_build_priority) {
    if ($cpb_build_priority_count < 1) {
      $cpb_build_priority_count = $total_builder_categories;
    }
  } else {
    $cpb_build_priority_count = 0;
  }
// SETUP MINIMUM COMPONENT COUNT
  if ($cpb_build_minimum_order) {
    if ($cpb_build_minimum_order_count < 1) {
      $cpb_build_minimum_order_count = $total_builder_categories;
    }
  } else {
    $cpb_build_minimum_order_count = 0;
  }

// arrange the dependency ids to match the new (phantom and very sequential) category ids
  foreach($pcid as $new_id) {
    if ($pcdcat[$new_id] < 1) {
      $pcdcat[$new_id] = 0;
    } else {
      $x=0;
      for($x;$x<$pcount;$x++) {
        if ($pcshadowid[$x] == $pcdcat[$new_id]) {
          $pcdcat[$new_id] = $pcid[$x];
        }
      }
    }
  }
  unset($pcshadowid);
} else {
      tep_redirect(tep_href_link('index.php'));
}

// check for action variable if set on reload
switch ($_GET['action'] && $_POST['p_id']) {
  case 'add_products' :
    $InsertProducts=($_POST["p_id"]);
    $InsertQTY=$_POST["p_qty"];
    $InsertProducts=explode("::",$InsertProducts);
    $InsertQTY=explode("::",$InsertQTY);
    foreach ($InsertQTY as $key => $value) {
      $products_qty[$key]=$value;
    }
    foreach ($InsertProducts as $key => $value) {
      $products_count[$key]=$value;
    }

// builder mode (single or bundle)
    if ($cpb_build_one_product) {

// SINGLE MODE ----------------------------------------------------------------
    
      $build_error = 0;
      $stock_error = 0;
      $status_error = 0;
      $upload_error = 0;

// image check - use local image (default or selected)
      if (($_POST['edit_build_image']) && ($cpb_build_allow_image)) {
        $cpb_build_final_image = $cpb_product_images_folder . $_POST['edit_build_image'];
        $cpb_build_image = $_POST['edit_build_image'];
      }

// uploadable image validation (upload has priority over local image selected)
      if (($_FILES['edit_build_image_upload']['name']) && ($cpb_build_allow_image_upload)) {
        if ($_FILES['edit_build_image_upload']['error']!='0') {
          $upload_error = 1;
        } else {
          //require(DIR_WS_CLASSES . 'upload.php'); Already declared in application_top.php (which is required above)
          if (($cpb_build_image_upload_size > $_FILES['edit_build_image_upload']['size']) && ($cpb_build_image_upload = new upload('edit_build_image_upload', 'images/' . $cpb_build_image_upload_folder, '644', array('gif', 'jpg', 'png')))) {
              $cpb_build_final_image = $cpb_build_image_upload_folder . $cpb_build_image_upload->filename;
          } else {
            $upload_error = 1;
          }
        }
      }

// assembly pre-check
      $pccat[$pcount] = $cpb_build_assembly_fee_name;
      $products_price = 0;
      $products_weight = 0;
      for ($i = 0, $n = count($products_count); $i < $n; $i++) {
        $component_note[$i] = '';
        if ($products_count[$i] > 0) {
          $products_query = tep_db_query("select products_status, products_name, products_weight, products_quantity, products_price, products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_id = '".$products_count[$i]."' and pd.products_id = p.products_id");
          $products = tep_db_fetch_array($products_query);
          $components_name[$i] = strip_tags(addslashes($products['products_name']));
          $components_quantity[$i] = $products_qty[$i];
// check for special prices
          $special_price = tep_get_products_special_price($products_count[$i]);
          if ($special_price && !$cpb_ignore_specials) {
            $temp_price = $special_price;
          } else {
            $temp_price = $products['products_price'];
          }
// rounding - so simple - seems a bit dodgy at 4 decimal places
          if ($currency_symb['decimal_places'] >0 && tep_not_null($currency_symbol['decimal_point'])){
            $temp_price = round($temp_price, $currency_symb['decimal_places']);
          }

// tax - if osC isnt showing prices with tax then the builder cannot have the privelage of displaying with tax (makes sense?)
          if ((DISPLAY_PRICE_WITH_TAX) && (!$cpb_ignore_tax)) {
            $components_price[$i] = tep_add_tax($temp_price,tep_get_tax_rate($products['products_tax_class_id']));
          } else {
            $components_price[$i] = $temp_price;
          }
          if ($cpb_build_product_price_fix) {
            $products_price = $products_price + ($components_price[$i] * $components_quantity[$i]);
          } else {
            $products_price = '0';
          }
          $products_weight = $products_weight + ($products['products_weight'] * $components_quantity[$i]);

// product status
          if (($products['products_status'] != '1') && (!$cpb_build_allow_disabled)) {
            $status_error = 1;
            $component_note[$i] = 'error';
          }

// stock adjustment
          if ($cpb_reduce_stock) {
            $stock_left = $products['products_quantity'] - $products_qty[$i];
            tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . $products_count[$i] . "'");
          } else {
            $stock_left = $products['products_quantity'];
          }

// if builder draws component out of stock then disable the product
          if (($stock_left <= 0) && ($cpb_reduce_stock)) {
            if ($cpb_build_allow_disable_product) {
              tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . $products_count[$i] . "'");
            }
          }

// check if building is allowed to continue if no stock
          if (($stock_left < 0) && (!$cpb_build_allow_nostock)) {
            $stock_error = 1;
            $component_note[$i] = 'error';
          }

        }
      }

      $build_error = $stock_error + $status_error + $upload_error;
      if (!$build_error){

// if weve gotten to this point then the pre-check went well, it is safe to go to the trouble of creating the new product
        if (($_POST['edit_build_name']) && ($cpb_build_allow_name)) {
          $cpb_build_name = $_POST['edit_build_name'];
          $cpb_build_name = strip_tags(addslashes($cpb_build_name));
        }
        if (($_POST['edit_build_description']) && ($cpb_build_allow_description)) {
          $cpb_build_description = $_POST['edit_build_description'];
          $cpb_build_description = strip_tags(addslashes($cpb_build_description));
        }
        if ($_POST['edit_build_built_by']) {
          $cpb_build_built_by = $_POST['edit_build_built_by'];
          $cpb_build_built_by = strip_tags(addslashes($cpb_build_built_by));
        }
        $products_quantity = $cpb_build_product_stock_default;
        $products_date_available = 'null';
        $products_status = $cpb_build_product_status_default;
        $products_tax_class_id = $cpb_build_product_tax_class_default;
        $manufacturers_id = $cpb_build_manufacturer_id_default;
        $products_date_added =  'now()';
        $sql_data_array = array('products_quantity' => tep_db_prepare_input($products_quantity),
                                'products_model' => tep_db_prepare_input($cpb_build_model),
                                'products_price' => tep_db_prepare_input($products_price),
                                'products_date_available' => tep_db_prepare_input($products_date_available),
                                'products_weight' => tep_db_prepare_input($products_weight),
                                'products_status' => tep_db_prepare_input($products_status),
                                'products_tax_class_id' => tep_db_prepare_input($products_tax_class_id),
                                'manufacturers_id' => tep_db_prepare_input($manufacturers_id),
                                'products_image' => tep_db_prepare_input($cpb_build_final_image),
                                'builder_product_flag' => tep_db_prepare_input('1'),
                                'products_date_added' => tep_db_prepare_input($products_date_added));
        tep_db_perform(TABLE_PRODUCTS, $sql_data_array);

// recover PID and use it in the P2C insert
        $products_id = tep_db_insert_id();
        tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$cpb_build_osccat . "')");

// for suffixes, apply the appends as admin wants them
        if ($cpb_build_model_suffix) {
          tep_db_query("update " . TABLE_PRODUCTS . " set products_model = '" . $cpb_build_model . '-' . $products_id . "' where products_id = '" . $products_id . "'");
        }

// description, url and others
        if ($cpb_build_url_suffix) {
          $cpb_build_url .= TEXT_URL_SUFFIX . $products_id;
        }
        if ($cpb_build_name_suffix) {
          $cpb_build_name .= '&nbsp;(#' . $products_id . ')';
        }

// ADD BUILT BY TO END OF DESCRIPTION
// (OPTIONAL: IF ENABLED BY ADMIN) - uncomment the following two lines to append built-by to description only if the 'show built_by' flag is set
//        if ($cpb_build_show_built_by) {
          $cpb_build_description .= '&nbsp;&nbsp;<br>[' . HEADING_BUILD_BUILT_BY . '&nbsp;' . $cpb_build_built_by . ']';
//        }
        $sql_data_array = array('products_name' => tep_db_prepare_input(stripslashes($cpb_build_name)),
                                'products_description' => stripslashes($cpb_build_description),
                                'products_url' => tep_db_prepare_input($cpb_build_url),
                                'products_id' => tep_db_prepare_input($products_id),
                                'language_id' => tep_db_prepare_input($languages_id));
        tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);

// NOW INSERT EACH OF THE COMPONENTS AS ATTRIBUTES - A SPECIAL TWIST INCLUDED - REVERSE BUILDING IS ALLOWED - DUNNO WHY BUT SOMEONE....etc
// OSCOMMERCE ATTRIBUTES HANDLING IS TO SORT BY NAME - POINTLESS REALLY - SO THE BUILDER INTRODUCES SOMETHING NOW THAT WONT EVEN BE NOTICED
// THE 'must appear in build-order' FORCES OSC TO NOT SORT THE ATTRIBUTES LIST, SO THAT THEY APPEAR THE WAY THE BUILDER PUT THEM
// OR ACTUALLY THE ORDER IN WHICH THE PRODUCT OPTIONS (BUILDER CATEGORIES) WERE WRITTEN TO THE DBT - UNSORTED... PERFECT!

// if build-in-reverse has been specified by admin
        if ($cpb_build_in_reverse) {
          for ($i = count($products_count), $n = 0; $i >= $n; $i--) {
            include('includes/modules/builder_add_attribute.php');
          }
        } else {

// otherwise assemble the components in the order that the builder categories have been defined (as they appear in the builder frontend)
          for ($i = 0, $n = count($products_count); $i < $n; $i++) {
            include('includes/modules/builder_add_attribute.php');
          }
        }

// BUILD COMPLETE - SUCCESSFUL - READY FOR CART!!! - this should show a preview of the built product or straight to cart depending on admin sets
        if ($cpb_build_preview_single) {
          tep_redirect(tep_href_link('builder_product_info.php', 'products_id=' . $products_id));
        } else {
          if (!$cpb_build_product_status_default) {
            tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '1' where products_id = '" . $products_id . "' and products_status = '0'");
          }
          $cart->add_cart($products_id, $products_quantity, $cpb_attribute_list);
          if ($cpb_build_disable_after_carted || !$cpb_build_product_status_default) {
            tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . $products_id . "' and products_status = '1'");
          }
          tep_redirect(tep_href_link($goto));
        }
      } else {

// pre-check fail - undo the precheck process (ie. return component stock - reenable those that were disabled)
        for ($i = count($products_count), $n = 0; $i >= $n; $i--) {
          $products_query = tep_db_query("select products_quantity, products_status from " . TABLE_PRODUCTS . " where products_id = '" . $products_count[$i] . "'");
          $products = tep_db_fetch_array($products_query);
          if (($products['products_status'] != '1') && (!$cpb_build_allow_disabled) && ($cpb_build_allow_disable_product)) {
            tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '1' where products_id = '" . $products_count[$i] . "'");
          }
          $stock_left = $products['products_quantity'] + $products_qty[$i];
          tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . $products_count[$i] . "'");
        }

      } 
    } else {

// bundle mode -----------------------------------------------------------------------
// send each component to the cart, osC will deduct stock on checkout

// clear cart before dumping bundles?
      if ($cpb_build_cart_reset) {
        $cart->reset();
      }
      for ($i = 0, $n = count($products_count); $i < $n; $i++) {
        $cart->add_cart($products_count[$i], $cart->get_quantity(tep_get_uprid($products_count[$i], $_POST['id']))+$products_qty[$i], $_POST['id']);
      }
      tep_redirect(tep_href_link($goto));
    }
  break;
}

if ($build_error){
  $reload_form=1;
  if ($upload_error) {
    $messageStack->add('builder', sprintf(TEXT_BUILD_FAILED_UPLOAD,round($cpb_build_image_upload_size/1000,0)));
  }
  if ($stock_error && $status_error) {
    $messageStack->add('builder', TEXT_BUILD_FAILED_BOTH);
  } else {
    if ($stock_error) {
      $messageStack->add('builder', TEXT_BUILD_FAILED_NOSTOCK);
    }
    if ($status_error) {
      $messageStack->add('builder', TEXT_BUILD_FAILED_DISABLED);
    }
  }
  $messageStack->add('builder', TEXT_BUILD_FAILED);
}

global $assemb_id;
$assemb_id=$pcount;
$breadcrumb->add(NAVBAR_TITLE, tep_href_link('builder_main.php', '', 'NONSSL'));

require('includes/template_top.php');

?>

    <?php echo tep_draw_form('mainform', tep_href_link('builder_main.php', tep_get_all_get_params(array('action')) . 'action=add_products'), 'post', 'enctype="multipart/form-data"');?><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" align="left"><?php echo $cpb_product_builder_name; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image('images/table_background_builder.gif' , $cpb_product_builder_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php //echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
if ($messageStack->size('builder') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('builder'); ?></td>
      </tr>
      <tr>
        <td><?php // echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td align="left" class="main"><?php if ($cpb_build_one_product) {echo TEXT_TITLE_SINGLE;} else {echo TEXT_TITLE_MULTIPLE;} ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo TEXT_TITLE_WARNING; ?></td>
      </tr>
      <tr>
        <td><?php // echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
// New Product Details - only if in Single Mode
if (($cpb_build_one_product) && ($cpb_build_product_details_ontop)) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr height="35">
            <td class="builder_heading" align="left"><?php echo '&nbsp;&nbsp;' . TEXT_BUILD_DETAILS; ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  include('includes/modules/builder_singles_header.php');
}
// single build mode ends here
?>
      <tr>
        <td>
<?php
require('includes/modules/builder_main.php');
?>

<div style="OVERFLOW: auto; display: none; position: absolute; border: solid 2; background-color: White; z-index: auto;" id=oFrame></div>
<div align=center>
  <span id=loadstr><br><br><?php echo TEXT_LOADING_PLEASE_WAIT; ?><img src="<?php echo 'images/';?>pbar.gif" width="71" height="11" alt="" border="0"></span>

  <table width="100%">
    <tr>
      <td width="100%" class="main" align="center">

<script language="JavaScript">
var tlines= "<?php echo $total_builder_categories;?>";
var currency = "<?php echo $currency;?>";
var currency_left="<?php echo $currency_symb['symbol_left'];?>";
var currency_right="<?php echo $currency_symb['symbol_right'];?>";
var thousands_point="<?php echo $currency_symb['thousands_point'];?>";
var decimal_point="<?php echo $currency_symb['decimal_point'];?>";
var decimal_places="<?php echo $currency_symb['decimal_places'];?>";

// THIS HAS SOMETHING TO DO WITH ASSEMBLY FEES I THINK
l = new Array(tlines);
for (i=0;i<tlines;i++){
  l[i] = new Array(100);
}

// FUNCTION ---------- Add Component To The Build List ------------------------
function add_product(ipid,ipimage,ipname,ipinfo,iprice,irecid,row){
  iprice2 = iprice;
  iprice = decimal_substitution(iprice,'calc');
  row++;
  var enable=false;
  if (ipid=='error'){
    var c_error = "<font color='red' size='1'><?php echo TEXT_BUILD_COMPONENT_ERROR;?></font>";
    ipid="";
  } else {
    var c_error = "";
    if (ipid=='-1') {
      enable=true;
      ipid="";
    }
  }
  ipname = ipname.replace(/:inc:/gi, '"');
  ipname = ipname.replace(/:tag:/gi, '\'');
  var prods_row = document.getElementById("prod_table").rows[row];
  var title_cell=prods_row.cells[1].childNodes[0].childNodes[0].childNodes[0].cells[0];
  var price_cell=prods_row.cells[2];
// IF NO NAME THEN ASSUME REMOVE FROM LIST - DESELECT
  if (!ipname) {
    title_cell.innerHTML=default_line;
    price_cell.innerHTML="";
    price[row] = "";
    product[row] = "";
    description[row] = "";
    image[row] = "";
    pid[row] = "";
    recid[row] = "";
  } else {
<?php if ($cpb_build_show_product_image) { ?>
    title_cell.innerHTML="<img align='left' height='"+"<?php echo $cpb_build_product_image_height;?>"+"' width='"+"<?php echo $cpb_build_product_image_width;?>"+"' hspace='5' src='"+"<?php echo 'images/';?>"+ipimage+"'>"+"<u><font color='blue' size='2'>"+ipname+"</font></u>"+c_error+"<br><font size='1'>"+ipinfo+"</font>";
<?php } else { ?>
    title_cell.innerHTML="<u><font color='blue' size='2'>"+ipname+"</font></u><br><font size='1'>"+ipinfo+"</font>";
<?php } ?>
    price_cell.innerHTML=iprice2+"&nbsp;&nbsp;";
    price[row]=iprice;
    product[row]=ipname;
    description[row]=ipinfo;
    image[row]=ipimage;
    pid[row]=ipid;
    recid[row]=irecid;
  }
  if (!enable) document.getElementById("oFrame").style.display="none";
  calc_total_tmp(document.mainform);
}

// FUNCTION -------------- Format Floating Number (after decimal point) ------------
function formatnumber(num,num_after_dot){
  if (decimal_point.length<1 || decimal_places<1) {
    num=Math.round(num);
    var snum = (String) (num);
  } else {
    var shaker = Math.pow(10,decimal_places);
    num=Math.round(num*shaker)/shaker;
    if (!num_after_dot) num_after_dot=decimal_places;
    if (num<0.0001) num=0;
    var snum = (String) (num);
    var is_dot_ok=snum.indexOf('.');
    if (!(is_dot_ok==-1)) {
      snum = snum.substr(0,is_dot_ok+num_after_dot+1);
// padding after decimal point if necessary
      for (i=snum.length-is_dot_ok;i<=decimal_places;i++) {
        snum=snum+"0";
      }
    } else {
// no decimal point, so add it and pad with zeros (number of decimal places)
      if (decimal_places>0 && decimal_point.length>0){
        snum=snum+".";
        for (i=1;i<=decimal_places;i++) {
          snum=snum+"0";
        }
      }
    }
  }
  return decimal_substitution(snum,'display');
}

// FUNCTION ----------- Convert numerical signs for displaying and calculating -----------
function decimal_substitution(num,direction){
  switch (direction){
    case 'calc':
      num = num.replace(currency_left,"");
      num = num.replace(currency_right,"");
      var newnum = "";
      var snum = num.substr(num.length-decimal_places-decimal_point.length,decimal_places+decimal_point.length);
      num = num.substr(0,num.length-decimal_places-decimal_point.length);
      for (i=0;i<=num.length;i++) {
        if (num.substr(i,1)!=thousands_point){
          newnum = newnum+num.substr(i,1);
        }
      }
      num = newnum+snum;
      if (decimal_point.length>0 && decimal_places>0){
        num = num.replace(decimal_point,".");
      }
    break;
    case 'display':
      if (decimal_point.length>0 && decimal_places>0){
        var is_dot_ok=num.indexOf('.');
        if (is_dot_ok){
          var snum = num.substr(is_dot_ok,decimal_places+1);
          num = num.substr(0,is_dot_ok);
        } else {
          var snum = "";
        }
      }
      if (num.length>3) {
        var newnum="";
        while (num.length > 3) {
          newnum = thousands_point+num.substr(num.length-3,3)+newnum;
          num = num.substr(0,num.length-3);
        }   
        num = num+newnum;
      }
      if (decimal_point.length>0 && decimal_places>0){
        num = num+snum.substr(0,decimal_places+1);
        num = num.replace(".",decimal_point);
      }
    break;
  }
  return num;
}
</script>
          <table border='0' cellspacing='0' cellpadding='0' width='100%' style='border-collapse: collapse' bordercolor='#628AC5'>
            <tr width="100%" height="35">
              <td class="builder_heading" align="center" width='23%'><?php echo TEXT_PART_TYPE; ?></td>
              <td class="builder_heading" align="center" width='54%'><?php echo TEXT_PART_NAME; ?></td>
              <td class="builder_heading" align="center" width='15%'><?php echo TEXT_PART_PRICE; ?></td>
              <td class="builder_heading" align="center" width='8%'><?php echo TEXT_PART_QUANTITY; ?></td>
            </tr>
          </table>
          <table id='prod_table' name='prod_table' border='0' cellspacing='0' cellpadding='0' width='100%' bordercolor='#999999'>
            <tr width="100%" height="0">
              <td width='23%'></td>
              <td width='54%'></td>
              <td width='18%'></td>
              <td width='5%'></td>
            </tr>

<script language="JavaScript">
var text_please_wait="<?php echo TEXT_LOADING_PLEASE_WAIT; ?>";
var text_no_items="<?php echo TEXT_NO_ITEMS; ?>";
var text_deselect_items="<?php echo TEXT_DESELECT_ITEM; ?>";
document.getElementById("loadstr").innerHTML="";

<?php
$c_java = 0;
$output = $pcount;
for ($ib = 0; $ib < $output; $ib++) {
  $cat = $pccat[$ib];
  $picname = $pcimg[$ib];
?>
  print_field('<?php echo $cat;?>','<?php echo $c_java;?>','<?php echo $ib;?>','<?php echo $picname;?>',<?php echo $assemb_id;?>);
<?php
  $c_java++;
}

// ASSEMBLY FEE CHECK - this code will change in future to allow an optional flat assembly fee to be applied with every build (admin selectable)
if ($cpb_system_assembly != "0") {
?>
  print_field('<?php echo $cpb_build_assembly_fee_name; ?>','<?php echo $c_java;?>','<?php echo $ib;?>','<?php echo $cpb_build_assembly_image;?>',<?php echo $assemb_id;?>);
<?php
} else {
  $c_java--;
}
?>
</script>
            </td>
          </tr>
        </table>
        <table height="35" width="100%" id='prod_table' name='prod_table' border='0' callpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#628AC5'>
          <input type="hidden" name="select1" onchange="calc_subtotal(mainform);calc_total(mainform);" size="4" multiple style="width=330">
          <tr onClick="oFrame.style.display='none'">
            <td width="50%" class="builder_heading" align="left"><?php if (($cpb_build_one_product) && (!$cpb_build_product_details_ontop)) {echo '&nbsp;&nbsp;' . TEXT_BUILD_DETAILS;} ?></td>
            <td width='30%' class='builder_footing' align='right'><?php echo TEXT_TOTAL_PRICE . "&nbsp;:&nbsp;" . $currency_symb['symbol_left'] . "&nbsp;"; ?></td>
            <td width='20%' class='builder_footing' align='left'><input type=text size=13 name="totsum" readonly style="font: bold 10pt;"><?php echo "&nbsp;" . $currency_symb['symbol_right']; ?></td>
          </tr>
        </table>
      </td>
<?php
// New Product Details - if in Single Mode
if (($cpb_build_one_product) && (!$cpb_build_product_details_ontop)) {
  include('includes/modules/builder_singles_header.php');
}
?>
      <tr>
        <td><?php // echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="3">
              <td width="10"><?php // echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <tr>
                  <td width="10"><?php // echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  <td align="left"><input type="button" value="<?php echo TEXT_FORM_RESET; ?>" onClick="mainform_onsubmit(mainform,3,<?php echo $c_java;?>);" class="button">
                  <td align="center"><input type="button" value="<?php echo TEXT_PRINT_PREVIEW; ?>" onClick="mainform_onsubmit(mainform,1,<?php echo $c_java;?>);" class="button">
                  <td align="right"><input type="button" value="<?php if (($cpb_build_one_product) && ($cpb_build_preview_single)) { echo TEXT_BUILD_ORDER; } else { echo TEXT_MAKE_ORDER; }?>" onClick="mainform_onsubmit(mainform,2,<?php echo $c_java;?>);" class="button">
                  <td width="10"><?php // echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                </tr>
              <td width="10"><?php // echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php // echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php // echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      </tr>
    </table>
    <input type=hidden name="sum">
    <input type=hidden name="totprint">
    <input type=hidden name="price">
    <input type=hidden name="product">
    <input type=hidden name="description">
    <input type=hidden name="image">
    <input type=hidden name="p_id">
    <input type=hidden name="p_qty">
    </form>
</div>
</tr></tr></tr>
    </table>
<?php
// RELOAD FORM DATA (component selections) IF REQUIRED - USUALLY AFTER AN ERROR OR FOR FUTURE RELOADS
if ($reload_form) {
  $InsertProducts=$_POST['p_id'];
  $InsertQuantity=$_POST['p_qty'];
  $InsertPrice=$_POST['price'];
  $InsertImage=$_POST['image'];
  $InsertDescription=$_POST['description'];
  $InsertName=$_POST['product'];
// explode the explodables
  $InsertProducts=explode("::",$InsertProducts);
  $InsertQuantity=explode("::",$InsertQuantity);
  $InsertPrice=explode("::",$InsertPrice);
  $InsertImage=explode("::",$InsertImage);
  $InsertDescription=explode("::",$InsertDescription);
  $InsertName=explode("::",$InsertName);
// and dump them all into the javascript engine
  foreach ($InsertProducts as $key => $value) {
    if ($InsertProducts[$key]){
   //   $iprice = str_replace(chr(160),'',$InsertPrice[$key]);
      $iprice = $currencies->format(str_replace(chr(160),'',$InsertPrice[$key]),false);
      $qty = $InsertQuantity[$key];
?>
<script language="JavaScript">
      mainform.elements["qty["+<?php echo $key;?>+"]"].selectedIndex = '<?php echo $qty-1;?>';
      add_product('<?php echo $component_note[$key];?>','<?php echo $InsertImage[$key];?>','<?php echo $InsertName[$key];?>','<?php echo $InsertDescription[$key];?>','<?php echo $iprice;?>','<?php echo $InsertProducts[$key];?>',<?php echo $key;?>);
</script>
<?php
    }
  }
}
// END OF RELOAD FORM (component selections)
?>
<?php
  require('includes/template_bottom.php');
  require('includes/application_bottom.php');
?>
