<?php
/*
  $Id: builder_options.php, v 1.1.0 2008/12/02 21:15:11 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
if (tep_not_null($action)) {
  switch ($action) {

// update builder settings
    case 'update':

// create tables if they dont exist ---------------------------
      if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE 'builder_options'"))!=1) {
        tep_db_query("DROP TABLE IF EXISTS builder_categories;");
        tep_db_query("DROP TABLE IF EXISTS builder_dependences;");

// options table
        $result1 = tep_db_query("
          CREATE TABLE builder_options (
  `cpb_system_assembly` tinyint(1) NOT NULL default '0',
  `cpb_assembly_osccat` int(11) NOT NULL default '0',
  `cpb_use_dependence` tinyint(1) NOT NULL default '1',
  `cpb_use_software` int(1) NOT NULL default '0',
  `cpb_build_osccat` int(11) NOT NULL default '0',
  `cpb_build_name` varchar(64) NOT NULL default 'Custom Built Product',
  `cpb_build_description` varchar(255) NOT NULL default 'This product was created using our online Product Builder.',
  `cpb_build_image` varchar(64) NOT NULL default 'product_builder.gif',
  `cpb_build_url` varchar(64) NOT NULL default '',
  `cpb_build_model` varchar(12) NOT NULL default 'custom',
  `cpb_reduce_stock` tinyint(1) NOT NULL default '0',
  `cpb_build_one_product` tinyint(1) NOT NULL default '1',
  `cpb_popup_height` int(4) NOT NULL default '300',
  `cpb_popup_offset_left` int(3) NOT NULL default '0',
  `cpb_popup_offset_top` int(3) NOT NULL default '0',
  `cpb_show_nostock` tinyint(1) NOT NULL default '0',
  `cpb_show_disabled` tinyint(1) NOT NULL default '0',
  `cpb_ignore_specials` tinyint(1) NOT NULL default '0',
  `cpb_build_allow_name` tinyint(1) NOT NULL default '1',
  `cpb_build_allow_description` tinyint(1) NOT NULL default '1',
  `cpb_build_allow_image` tinyint(1) NOT NULL default '1',
  `cpb_build_model_suffix` tinyint(1) NOT NULL default '1',
  `cpb_auto_delete_time` int(4) default '72',
  `cpb_build_allow_nostock` tinyint(1) NOT NULL default '0',
  `cpb_build_allow_disabled` tinyint(1) NOT NULL default '0',
  `cpb_build_allow_disable_product` tinyint(1) NOT NULL default '1',
  `cpb_product_builder_name` varchar(32) NOT NULL default 'Product Builder',
  `cpb_product_builder_image` varchar(64) NOT NULL default 'custom_product.gif',
  `cpb_product_builder_image_tag` varchar(64) NOT NULL default 'table_background_builder.gif',
  `cpb_popup_show_product_image` tinyint(1) NOT NULL default '1',
  `cpb_build_show_product_image` tinyint(1) NOT NULL default '1',
  `cpb_build_show_product_quantity` tinyint(1) NOT NULL default '0',
  `cpb_build_show_built_by` tinyint(1) NOT NULL default '1',
  `cpb_build_product_image_height` int(3) NOT NULL default '50',
  `cpb_build_product_image_width` int(3) NOT NULL default '50',
  `cpb_popup_product_image_height` int(3) NOT NULL default '50',
  `cpb_popup_product_image_width` int(3) NOT NULL default '50',
  `cpb_product_images_folder` varchar(255) NOT NULL default 'builder/products/',
  `cpb_category_images_folder` varchar(255) NOT NULL default 'builder/',
  `cpb_catalog_images_folder` varchar(255) NOT NULL default 'images/',
  `cpb_build_product_price_fix` tinyint(1) NOT NULL default '0',
  `cpb_build_assembly_image` varchar(64) NOT NULL default 'assembly.gif',
  `cpb_build_allow_set_type` tinyint(1) NOT NULL default '0',
  `cpb_matrix_edit_default_lines_per_page` int(3) NOT NULL default '64',
  `cpb_matrix_edit_show_nostock` tinyint(1) NOT NULL default '1',
  `cpb_matrix_edit_show_disabled` tinyint(1) NOT NULL default '1',
  `cpb_build_short_description_length` int(3) NOT NULL default '50',
  `cpb_build_show_short_description` tinyint(1) NOT NULL default '1',
  `cpb_popup_short_description_length` int(3) NOT NULL default '75',
  `cpb_popup_show_short_description` tinyint(1) NOT NULL default '1',
  `cpb_build_auto_clear_list` tinyint(1) NOT NULL default '1',
  `cpb_build_auto_clear_count` tinyint(1) NOT NULL default '2',
  `cpb_build_show_url` tinyint(1) NOT NULL default '0',
  `cpb_build_url_suffix` tinyint(1) NOT NULL default '1',
  `cpb_build_priority` tinyint(1) NOT NULL default '0',
  `cpb_build_priority_count` int(3) NOT NULL default '5',
  `cpb_build_price_in_description` tinyint(1) NOT NULL default '1',
  `cpb_build_in_reverse` tinyint(1) NOT NULL default '0',
  `cpb_build_priority_depends_only` tinyint(1) NOT NULL default '0',
  `cpb_build_allow_built_by` tinyint(1) NOT NULL default '1',
  `cpb_build_preview_single` tinyint(1) NOT NULL default '1',
  `cpb_build_component_qty_max` int(2) NOT NULL default '4',
  `cpb_build_product_status_default` tinyint(1) NOT NULL default '1',
  `cpb_build_product_stock_default` int(5) NOT NULL default '1',
  `cpb_build_assembly_fee_name` varchar(64) NOT NULL default 'Assembly Fee',
  `cpb_build_product_details_ontop` tinyint(1) NOT NULL default '0',
  `cpb_build_unsort_components` tinyint(1) NOT NULL default '1',
  `cpb_popup_sort_by_price` tinyint(1) NOT NULL default '1',
  `cpb_build_built_by_default` varchar(64) NOT NULL default 'Guest',
  `cpb_build_disable_after_carted` tinyint(1) NOT NULL default '0',
  `cpb_auto_disable_time` int(3) NOT NULL default '12',
  `cpb_build_manufacturer_id_default` int(11) NOT NULL default '0',
  `cpb_build_name_suffix` tinyint(1) NOT NULL default '0',
  `cpb_build_cart_reset` tinyint(1) NOT NULL default '0',
  `cpb_build_id_in_description` tinyint(1) NOT NULL default '0',
  `cpb_build_show_category_image` tinyint(1) NOT NULL default '1',
  `cpb_build_category_image_height` int(3) NOT NULL default '22',
  `cpb_build_category_image_width` int(3) NOT NULL default '166',
  `cpb_build_product_tax_class_default` int(11) NOT NULL default '0',
  `cpb_ignore_tax` tinyint(1) NOT NULL default '0',
  `cpb_build_show_tax` tinyint(1) NOT NULL default '1',
  `cpb_build_minimum_order` tinyint(1) NOT NULL default '0',
  `cpb_build_minimum_order_count` int(3) NOT NULL default '2',
  `cpb_build_allow_image_upload` tinyint(1) NOT NULL default '0',
  `cpb_build_image_upload_size` int(11) NOT NULL default '81920',
  `cpb_build_image_upload_folder` varchar(255) NOT NULL default 'builder/uploads/'
        );");
        $result2 = tep_db_query("
INSERT INTO builder_options
(`cpb_system_assembly`, `cpb_assembly_osccat`, `cpb_use_dependence`, `cpb_use_software`, `cpb_build_osccat`, `cpb_build_name`, `cpb_build_description`, `cpb_build_image`, `cpb_build_url`, `cpb_build_model`, `cpb_reduce_stock`, `cpb_build_one_product`, `cpb_popup_height`, `cpb_popup_offset_left`, `cpb_popup_offset_top`, `cpb_show_nostock`, `cpb_show_disabled`, `cpb_ignore_specials`, `cpb_build_allow_name`, `cpb_build_allow_description`, `cpb_build_allow_image`, `cpb_build_model_suffix`, `cpb_auto_delete_time`, `cpb_build_allow_nostock`, `cpb_build_allow_disabled`, `cpb_build_allow_disable_product`, `cpb_product_builder_name`, `cpb_product_builder_image`, `cpb_product_builder_image_tag`, `cpb_popup_show_product_image`, `cpb_build_show_product_image`, `cpb_build_show_product_quantity`, `cpb_build_show_built_by`, `cpb_build_product_image_height`, `cpb_build_product_image_width`, `cpb_popup_product_image_height`, `cpb_popup_product_image_width`, `cpb_product_images_folder`, `cpb_category_images_folder`, `cpb_catalog_images_folder`, `cpb_build_product_price_fix`, `cpb_build_assembly_image`, `cpb_build_allow_set_type`, `cpb_matrix_edit_default_lines_per_page`, `cpb_matrix_edit_show_nostock`, `cpb_matrix_edit_show_disabled`, `cpb_build_short_description_length`, `cpb_build_show_short_description`, `cpb_popup_short_description_length`, `cpb_popup_show_short_description`, `cpb_build_auto_clear_list`, `cpb_build_auto_clear_count`, `cpb_build_show_url`, `cpb_build_url_suffix`, `cpb_build_priority`, `cpb_build_priority_count`, `cpb_build_price_in_description`, `cpb_build_in_reverse`, `cpb_build_priority_depends_only`, `cpb_build_allow_built_by`, `cpb_build_preview_single`, `cpb_build_component_qty_max`, `cpb_build_product_status_default`, `cpb_build_product_stock_default`, `cpb_build_assembly_fee_name`, `cpb_build_product_details_ontop`, `cpb_build_unsort_components`, `cpb_popup_sort_by_price`, `cpb_build_built_by_default`, `cpb_build_disable_after_carted`, `cpb_auto_disable_time`, `cpb_build_manufacturer_id_default`, `cpb_build_name_suffix`, `cpb_build_cart_reset`, `cpb_build_id_in_description`, `cpb_build_show_category_image`, `cpb_build_category_image_height`, `cpb_build_category_image_width`, `cpb_build_product_tax_class_default`, `cpb_ignore_tax`, `cpb_build_show_tax`, `cpb_build_minimum_order`, `cpb_build_minimum_order_count`, `cpb_build_allow_image_upload`, `cpb_build_image_upload_size`, `cpb_build_image_upload_folder`) VALUES (1, 21, 0, 0, 22, 'Custom Product', 'This product was assembled online using a custom product builder.', 'custom_product.gif', '', 'custom', 0, 1, 300, 100, 0, 0, 0, 1, 1, 1, 1, 1, 2, 0, 0, 1, 'Custom Product Builder', 'custom_product_builder.gif', 'table_background_builder.gif', 1, 1, 1, 0, 28, 28, 28, 28, 'builder/products/', 'builder/', 'images/', 1, 'componenta.gif', 0, 70, 0, 0, 20, 1, 30, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 10, 1, 1, 'Assembly Fee', 1, 1, 1, 'Guest', 0, 1, 6, 1, 1, 1, 1, 22, 166, 1, 1, 1, 0, 0, 1, 81920, 'builder/uploads/');
        ");

// categories table
        $result3 = tep_db_query("CREATE TABLE builder_categories (
          `cpb_category_id` INT( 11 ) NOT NULL ,
          `cpb_depends_category_id` INT( 11 ) NOT NULL ,
          `cpb_category_name` VARCHAR( 32 ) NOT NULL ,
          `cpb_category_image` VARCHAR( 32 ) NOT NULL ,
          `osc_category_id` INT( 11 ) NOT NULL
        );");

// dependences table
        $result3_1 = tep_db_query("CREATE TABLE builder_dependences (
          `product1_id` INT( 11 ) NOT NULL ,
          `product2_id` INT( 11 ) NOT NULL
        );");

// populate categories with some examples
        $result4 = tep_db_query("INSERT INTO builder_categories (
          `cpb_category_id` , `cpb_depends_category_id`,  `cpb_category_name` ,`cpb_category_image`, `osc_category_id`)
          VALUES ( '10' , '0' , 'Component 1' , 'component1.gif' , '0'
        );");
        $result5 = tep_db_query("INSERT INTO builder_categories (
          `cpb_category_id` , `cpb_depends_category_id`,  `cpb_category_name` ,`cpb_category_image`, `osc_category_id`)
          VALUES ( '20' , '10' , 'Component 2' , 'component2.gif' , '0'
        );");
        $result6 = tep_db_query("INSERT INTO builder_categories (
          `cpb_category_id` , `cpb_depends_category_id`,  `cpb_category_name` ,`cpb_category_image`, `osc_category_id`)
          VALUES ( '30' , '20' , 'Component 3' , 'component3.gif' , '0'
        );");

        if (($result1 == 1)&($result2 == 1)&($result3 == 1)&($result4 == 1)&($result5 == 1)&($result6 == 1)) {
          $messageStack->add_session("Database Tables Created successfully", 'success');

// before modifying the products and attributes file check if the new fields already exist - add those that arent
          $result4 = "builder_product_flag";
          $result1 = false;
          $result2 = tep_db_query("show columns from products");
          while($result3 = tep_db_fetch_array($result2)){
            if($result3['Field'] == $result4){
              $result1 = true;
              break;
            }
          }
          if(!$result1){
            tep_db_query("ALTER TABLE products ADD COLUMN `builder_product_flag` tinyint(1) NOT NULL default '0'");
          }
          $result4 = "catalog_products_id";
          $result1 = false;
          $result2 = tep_db_query("show columns from products_options_values");
          while($result3 = tep_db_fetch_array($result2)){
            if($result3['Field'] == $result4){
              $result1 = true;
              break;
            }
          }
          if(!$result1){
            tep_db_query("ALTER TABLE products_options_values ADD COLUMN `catalog_products_id` int(11) DEFAULT NULL");
          }
          $result4 = "catalog_products_quantity";
          $result1 = false;
          $result2 = tep_db_query("show columns from products_options_values");
          while($result3 = tep_db_fetch_array($result2)){
            if($result3['Field'] == $result4){
              $result1 = true;
              break;
            }
          }
          if(!$result1){
            tep_db_query("ALTER TABLE products_options_values ADD COLUMN `catalog_products_quantity` int(2) NULL default '1'");
          }

        } else {
          $messageStack->add_session("The Database Tables could not be created!", 'error');
        }
        $result1 =""; $result2 =""; $result3 =""; $result4 =""; $result5 =""; $result6 ="";
      } else {

// otherwise, update the tables if they already exist ----------------------------

// get posted variables (for rc2a compliancy)

      $cpb_system_assembly = $_POST['cpb_system_assembly'];
      $cpb_assembly_osccat = $_POST['cpb_assembly_osccat'];
      $cpb_use_dependence = $_POST['cpb_use_dependence'];
      $cpb_use_software = $_POST['cpb_use_software'];
      $cpb_build_osccat = $_POST['cpb_build_osccat'];
      $cpb_build_name = $_POST['cpb_build_name'];
      $cpb_build_description = $_POST['cpb_build_description'];
      $cpb_build_image = $_POST['cpb_build_image'];
      $cpb_build_url = $_POST['cpb_build_url'];
      $cpb_build_model = $_POST['cpb_build_model'];
      $cpb_reduce_stock = $_POST['cpb_reduce_stock'];
      $cpb_build_one_product = $_POST['cpb_build_one_product'];
      $cpb_popup_height = $_POST['cpb_popup_height'];
      $cpb_popup_offset_left = $_POST['cpb_popup_offset_left'];
      $cpb_popup_offset_top = $_POST['cpb_popup_offset_top'];
      $cpb_show_nostock = $_POST['cpb_show_nostock'];
      $cpb_show_disabled = $_POST['cpb_show_disabled'];
      $cpb_ignore_specials = $_POST['cpb_ignore_specials'];
      $cpb_build_allow_name = $_POST['cpb_build_allow_name'];
      $cpb_build_allow_description = $_POST['cpb_build_allow_description'];
      $cpb_build_allow_image = $_POST['cpb_build_allow_image'];
      $cpb_build_model_suffix = $_POST['cpb_build_model_suffix'];
      $cpb_auto_delete_time = $_POST['cpb_auto_delete_time'];
      $cpb_build_allow_nostock = $_POST['cpb_build_allow_nostock'];
      $cpb_build_allow_disabled = $_POST['cpb_build_allow_disabled'];
      $cpb_build_allow_disable_product = $_POST['cpb_build_allow_disable_product'];
      $cpb_product_builder_name = $_POST['cpb_product_builder_name'];
      $cpb_product_builder_image = $_POST['cpb_product_builder_image'];
      $cpb_popup_show_product_image = $_POST['cpb_popup_show_product_image'];
      $cpb_build_show_product_image = $_POST['cpb_build_show_product_image'];
      $cpb_build_show_product_quantity = $_POST['cpb_build_show_product_quantity'];
      $cpb_build_show_built_by = $_POST['cpb_build_show_built_by'];
      $cpb_build_product_image_height = $_POST['cpb_build_product_image_height'];
      $cpb_build_product_image_width = $_POST['cpb_build_product_image_width'];
      $cpb_popup_product_image_height = $_POST['cpb_popup_product_image_height'];
      $cpb_popup_product_image_width = $_POST['cpb_popup_product_image_width'];
      $cpb_category_images_folder = $_POST['cpb_category_images_folder'];
      $cpb_product_images_folder = $_POST['cpb_product_images_folder'];
      $cpb_build_assembly_image = $_POST['cpb_build_assembly_image'];
      $cpb_build_allow_set_type = $_POST['cpb_build_allow_set_type'];
      $cpb_matrix_edit_default_lines_per_page = $_POST['cpb_matrix_edit_default_lines_per_page'];
      $cpb_matrix_edit_show_nostock = $_POST['cpb_matrix_edit_show_nostock'];
      $cpb_matrix_edit_show_disabled = $_POST['cpb_matrix_edit_show_disabled'];
      $cpb_build_short_description_length = $_POST['cpb_build_short_description_length'];
      $cpb_build_show_short_description = $_POST['cpb_build_show_short_description'];
      $cpb_popup_short_description_length = $_POST['cpb_popup_short_description_length'];
      $cpb_popup_show_short_description = $_POST['cpb_popup_show_short_description'];
      $cpb_build_auto_clear_list = $_POST['cpb_build_auto_clear_list'];
      $cpb_build_auto_clear_count = $_POST['cpb_build_auto_clear_count'];
      $cpb_build_show_url = $_POST['cpb_build_show_url'];
      $cpb_build_url_suffix = $_POST['cpb_build_url_suffix'];
      $cpb_build_priority = $_POST['cpb_build_priority'];
      $cpb_build_priority_count = $_POST['cpb_build_priority_count'];
      $cpb_build_price_in_description = $_POST['cpb_build_price_in_description'];
      $cpb_build_in_reverse = $_POST['cpb_build_in_reverse'];
      $cpb_build_priority_depends_only = $_POST['cpb_build_priority_depends_only'];
      $cpb_build_allow_built_by = $_POST['cpb_build_allow_built_by'];
      $cpb_build_preview_single = $_POST['cpb_build_preview_single'];
      $cpb_build_component_qty_max = $_POST['cpb_build_component_qty_max'];
      $cpb_build_product_status_default = $_POST['cpb_build_product_status_default'];
      $cpb_build_product_stock_default = $_POST['cpb_build_product_stock_default'];
      $cpb_build_assembly_fee_name = $_POST['cpb_build_assembly_fee_name'];
      $cpb_build_product_details_ontop = $_POST['cpb_build_product_details_ontop'];
      $cpb_build_unsort_components = $_POST['cpb_build_unsort_components'];
      $cpb_popup_sort_by_price = $_POST['cpb_popup_sort_by_price'];
      $cpb_build_built_by_default = $_POST['cpb_build_built_by_default'];
      $cpb_build_disable_after_carted = $_POST['cpb_build_disable_after_carted'];
      $cpb_auto_disable_time = $_POST['cpb_auto_disable_time'];
      $cpb_build_manufacturer_id_default = $_POST['cpb_build_manufacturer_id_default'];
      $cpb_build_name_suffix = $_POST['cpb_build_name_suffix'];
      $cpb_build_cart_reset = $_POST['cpb_build_cart_reset'];
      $cpb_build_id_in_description = $_POST['cpb_build_id_in_description'];
      $cpb_build_show_category_image = $_POST['cpb_build_show_category_image'];
      $cpb_build_category_image_height = $_POST['cpb_build_category_image_height'];
      $cpb_build_category_image_width = $_POST['cpb_build_category_image_width'];
      $cpb_build_product_tax_class_default = $_POST['cpb_build_product_tax_class_default'];
      $cpb_ignore_tax = $_POST['cpb_ignore_tax'];
      $cpb_build_show_tax = $_POST['cpb_build_show_tax'];
      $cpb_build_minimum_order = $_POST['cpb_build_minimum_order'];
      $cpb_build_minimum_order_count = $_POST['cpb_build_minimum_order_count'];
      $cpb_build_allow_image_upload = $_POST['cpb_build_allow_image_upload'];
      $cpb_build_image_upload_size = $_POST['cpb_build_image_upload_size'];
      $cpb_build_image_upload_folder = $_POST['cpb_build_image_upload_folder'];

// update options

        $cbcomp_query = tep_db_query("select * from builder_options");
        while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
          if (($cpb_system_assembly != "")&($cpb_system_assembly != $cbcomp['cpb_system_assembly'])) {
            tep_db_query("UPDATE builder_options SET cpb_system_assembly ='".$cpb_system_assembly."' WHERE cpb_system_assembly ='".$cbcomp['cpb_system_assembly']."'");
          }
          if (($cpb_assembly_osccat != "")&($cpb_assembly_osccat != $cbcomp['cpb_assembly_osccat'])) {
            tep_db_query("UPDATE builder_options SET cpb_assembly_osccat ='".$cpb_assembly_osccat."' WHERE cpb_assembly_osccat ='".$cbcomp['cpb_assembly_osccat']."'");
          }
          if (($cpb_use_dependence != "")&($cpb_use_dependence != $cbcomp['cpb_use_dependence'])) {
            tep_db_query("UPDATE builder_options SET cpb_use_dependence ='".$cpb_use_dependence."' WHERE cpb_use_dependence ='".$cbcomp['cpb_use_dependence']."'");
          }
          if (($cpb_use_software != "")&($cpb_use_software != $cbcomp['cpb_use_software'])) {
            tep_db_query("UPDATE builder_options SET cpb_use_software ='".$cpb_use_software."' WHERE cpb_use_software ='".$cbcomp['cpb_use_software']."'");
          }
          if (($cpb_build_osccat != "")&($cpb_build_osccat != $cbcomp['cpb_build_osccat'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_osccat ='".$cpb_build_osccat."' WHERE cpb_build_osccat ='".$cbcomp['cpb_build_osccat']."'");
          }
          if (($cpb_build_name != "")&($cpb_build_name != $cbcomp['cpb_build_name'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_name ='".$cpb_build_name."' WHERE cpb_build_name ='".$cbcomp['cpb_build_name']."'");
          }
          if (($cpb_build_description != "")&($cpb_build_description != $cbcomp['cpb_build_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_description ='".$cpb_build_description."' WHERE cpb_build_description ='".$cbcomp['cpb_build_description']."'");
          }
          if (($cpb_build_image != "")&($cpb_build_image != $cbcomp['cpb_build_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_image ='".$cpb_build_image."' WHERE cpb_build_image ='".$cbcomp['cpb_build_image']."'");
          }
          if (($cpb_build_url != $cbcomp['cpb_build_url'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_url ='".$cpb_build_url."' WHERE cpb_build_url ='".$cbcomp['cpb_build_url']."'");
          }
          if (($cpb_build_model != "")&($cpb_build_model != $cbcomp['cpb_build_model'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_model ='".$cpb_build_model."' WHERE cpb_build_model ='".$cbcomp['cpb_build_model']."'");
          }
          if (($cpb_reduce_stock != "")&($cpb_reduce_stock != $cbcomp['cpb_reduce_stock'])) {
            tep_db_query("UPDATE builder_options SET cpb_reduce_stock ='".$cpb_reduce_stock."' WHERE cpb_reduce_stock ='".$cbcomp['cpb_reduce_stock']."'");
          }
          if (($cpb_build_one_product != "")&($cpb_build_one_product != $cbcomp['cpb_build_one_product'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_one_product ='".$cpb_build_one_product."' WHERE cpb_build_one_product ='".$cbcomp['cpb_build_one_product']."'");
          }
          if (($cpb_popup_height != "")&($cpb_popup_height != $cbcomp['cpb_popup_height'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_height ='".$cpb_popup_height."' WHERE cpb_popup_height ='".$cbcomp['cpb_popup_height']."'");
          }
          if (($cpb_popup_offset_left != "")&($cpb_popup_offset_left != $cbcomp['cpb_popup_offset_left'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_offset_left ='".$cpb_popup_offset_left."' WHERE cpb_popup_offset_left ='".$cbcomp['cpb_popup_offset_left']."'");
          }
          if (($cpb_popup_offset_top != "")&($cpb_popup_offset_top != $cbcomp['cpb_popup_offset_top'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_offset_top ='".$cpb_popup_offset_top."' WHERE cpb_popup_offset_top ='".$cbcomp['cpb_popup_offset_top']."'");
          }
          if (($cpb_show_nostock != "")&($cpb_show_nostock != $cbcomp['cpb_show_nostock'])) {
            tep_db_query("UPDATE builder_options SET cpb_show_nostock ='".$cpb_show_nostock."' WHERE cpb_show_nostock ='".$cbcomp['cpb_show_nostock']."'");
          }
          if (($cpb_show_disabled != "")&($cpb_show_disabled != $cbcomp['cpb_show_disabled'])) {
            tep_db_query("UPDATE builder_options SET cpb_show_disabled ='".$cpb_show_disabled."' WHERE cpb_show_disabled ='".$cbcomp['cpb_show_disabled']."'");
          }
          if (($cpb_ignore_specials != "")&($cpb_ignore_specials != $cbcomp['cpb_ignore_specials'])) {
            tep_db_query("UPDATE builder_options SET cpb_ignore_specials ='".$cpb_ignore_specials."' WHERE cpb_ignore_specials ='".$cbcomp['cpb_ignore_specials']."'");
          }
          if (($cpb_build_allow_name != "")&($cpb_build_allow_name != $cbcomp['cpb_build_allow_name'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_name ='".$cpb_build_allow_name."' WHERE cpb_build_allow_name ='".$cbcomp['cpb_build_allow_name']."'");
          }
          if (($cpb_build_allow_description != "")&($cpb_build_allow_description != $cbcomp['cpb_build_allow_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_description ='".$cpb_build_allow_description."' WHERE cpb_build_allow_description ='".$cbcomp['cpb_build_allow_description']."'");
          }
          if (($cpb_build_allow_image != "")&($cpb_build_allow_image != $cbcomp['cpb_build_allow_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_image ='".$cpb_build_allow_image."' WHERE cpb_build_allow_image ='".$cbcomp['cpb_build_allow_image']."'");
          }
          if (($cpb_build_model_suffix != "")&($cpb_build_model_suffix != $cbcomp['cpb_build_model_suffix'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_model_suffix ='".$cpb_build_model_suffix."' WHERE cpb_build_model_suffix ='".$cbcomp['cpb_build_model_suffix']."'");
          }
          if (($cpb_auto_delete_time != "")&($cpb_auto_delete_time != $cbcomp['cpb_auto_delete_time'])) {
            tep_db_query("UPDATE builder_options SET cpb_auto_delete_time ='".$cpb_auto_delete_time."' WHERE cpb_auto_delete_time ='".$cbcomp['cpb_auto_delete_time']."'");
          }
          if (($cpb_build_allow_nostock != "")&($cpb_build_allow_nostock != $cbcomp['cpb_build_allow_nostock'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_nostock ='".$cpb_build_allow_nostock."' WHERE cpb_build_allow_nostock ='".$cbcomp['cpb_build_allow_nostock']."'");
          }
          if (($cpb_build_allow_disabled != "")&($cpb_build_allow_disabled != $cbcomp['cpb_build_allow_disabled'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_disabled ='".$cpb_build_allow_disabled."' WHERE cpb_build_allow_disabled ='".$cbcomp['cpb_build_allow_disabled']."'");
          }
          if (($cpb_build_allow_disable_product != "")&($cpb_build_allow_disable_product != $cbcomp['cpb_build_allow_disable_product'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_disable_product ='".$cpb_build_allow_disable_product."' WHERE cpb_build_allow_disable_product ='".$cbcomp['cpb_build_allow_disable_product']."'");
          }
          if (($cpb_product_builder_name != "")&($cpb_product_builder_name != $cbcomp['cpb_product_builder_name'])) {
            tep_db_query("UPDATE builder_options SET cpb_product_builder_name ='".$cpb_product_builder_name."' WHERE cpb_product_builder_name ='".$cbcomp['cpb_product_builder_name']."'");
          }
          if (($cpb_product_builder_image != "")&($cpb_product_builder_image != $cbcomp['cpb_product_builder_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_product_builder_image ='".$cpb_product_builder_image."' WHERE cpb_product_builder_image ='".$cbcomp['cpb_product_builder_image']."'");
          }
          if (($cpb_popup_show_product_image != "")&($cpb_popup_show_product_image != $cbcomp['cpb_popup_show_product_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_show_product_image ='".$cpb_popup_show_product_image."' WHERE cpb_popup_show_product_image ='".$cbcomp['cpb_popup_show_product_image']."'");
          }
          if (($cpb_build_show_product_image != "")&($cpb_build_show_product_image != $cbcomp['cpb_build_show_product_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_product_image ='".$cpb_build_show_product_image."' WHERE cpb_build_show_product_image ='".$cbcomp['cpb_build_show_product_image']."'");
          }
          if (($cpb_build_show_product_quantity != "")&($cpb_build_show_product_quantity != $cbcomp['cpb_build_show_product_quantity'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_product_quantity ='".$cpb_build_show_product_quantity."' WHERE cpb_build_show_product_quantity ='".$cbcomp['cpb_build_show_product_quantity']."'");
          }
          if (($cpb_build_show_built_by != "")&($cpb_build_show_built_by != $cbcomp['cpb_build_show_built_by'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_built_by ='".$cpb_build_show_built_by."' WHERE cpb_build_show_built_by ='".$cbcomp['cpb_build_show_built_by']."'");
          }
          if (($cpb_build_product_image_height != "")&($cpb_build_product_image_height != $cbcomp['cpb_build_product_image_height'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_image_height ='".$cpb_build_product_image_height."' WHERE cpb_build_product_image_height ='".$cbcomp['cpb_build_product_image_height']."'");
          }
          if (($cpb_build_product_image_width != "")&($cpb_build_product_image_width != $cbcomp['cpb_build_product_image_width'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_image_width ='".$cpb_build_product_image_width."' WHERE cpb_build_product_image_width ='".$cbcomp['cpb_build_product_image_width']."'");
          }
          if (($cpb_popup_product_image_height != "")&($cpb_popup_product_image_height != $cbcomp['cpb_popup_product_image_height'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_product_image_height ='".$cpb_popup_product_image_height."' WHERE cpb_popup_product_image_height ='".$cbcomp['cpb_popup_product_image_height']."'");
          }
          if (($cpb_popup_product_image_width != "")&($cpb_popup_product_image_width != $cbcomp['cpb_popup_product_image_width'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_product_image_width ='".$cpb_popup_product_image_width."' WHERE cpb_popup_product_image_width ='".$cbcomp['cpb_popup_product_image_width']."'");
          }
          if (($cpb_category_images_folder != "")&($cpb_category_images_folder != $cbcomp['cpb_category_images_folder'])) {
            tep_db_query("UPDATE builder_options SET cpb_category_images_folder ='".$cpb_category_images_folder."' WHERE cpb_category_images_folder ='".$cbcomp['cpb_category_images_folder']."'");
          }
          if (($cpb_product_images_folder != "")&($cpb_product_images_folder != $cbcomp['cpb_product_images_folder'])) {
            tep_db_query("UPDATE builder_options SET cpb_product_images_folder ='".$cpb_product_images_folder."' WHERE cpb_product_images_folder ='".$cbcomp['cpb_product_images_folder']."'");
          }
          if (($cpb_build_product_price_fix != "")&($cpb_build_product_price_fix != $cbcomp['cpb_build_product_price_fix'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_price_fix ='".$cpb_build_product_price_fix."' WHERE cpb_build_product_price_fix ='".$cbcomp['cpb_build_product_price_fix']."'");
          }
          if (($cpb_build_assembly_image != "")&($cpb_build_assembly_image != $cbcomp['cpb_build_assembly_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_assembly_image ='".$cpb_build_assembly_image."' WHERE cpb_build_assembly_image ='".$cbcomp['cpb_build_assembly_image']."'");
          }
          if (($cpb_build_allow_set_type != "")&($cpb_build_allow_set_type != $cbcomp['cpb_build_allow_set_type'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_set_type ='".$cpb_build_allow_set_type."' WHERE cpb_build_allow_set_type ='".$cbcomp['cpb_build_allow_set_type']."'");
          }
          if (($cpb_matrix_edit_default_lines_per_page != "")&($cpb_matrix_edit_default_lines_per_page != $cbcomp['cpb_matrix_edit_default_lines_per_page'])) {
            tep_db_query("UPDATE builder_options SET cpb_matrix_edit_default_lines_per_page ='".$cpb_matrix_edit_default_lines_per_page."' WHERE cpb_matrix_edit_default_lines_per_page ='".$cbcomp['cpb_matrix_edit_default_lines_per_page']."'");
          }
          if (($cpb_matrix_edit_show_nostock != "")&($cpb_matrix_edit_show_nostock != $cbcomp['cpb_matrix_edit_show_nostock'])) {
            tep_db_query("UPDATE builder_options SET cpb_matrix_edit_show_nostock ='".$cpb_matrix_edit_show_nostock."' WHERE cpb_matrix_edit_show_nostock ='".$cbcomp['cpb_matrix_edit_show_nostock']."'");
          }
          if (($cpb_matrix_edit_show_disabled != "")&($cpb_matrix_edit_show_disabled != $cbcomp['cpb_matrix_edit_show_disabled'])) {
            tep_db_query("UPDATE builder_options SET cpb_matrix_edit_show_disabled ='".$cpb_matrix_edit_show_disabled."' WHERE cpb_matrix_edit_show_disabled ='".$cbcomp['cpb_matrix_edit_show_disabled']."'");
          }
          if (($cpb_build_short_description_length != "")&($cpb_build_short_description_length != $cbcomp['cpb_build_short_description_length'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_short_description_length ='".$cpb_build_short_description_length."' WHERE cpb_build_short_description_length ='".$cbcomp['cpb_build_short_description_length']."'");
          }
          if (($cpb_build_show_short_description != "")&($cpb_build_show_short_description != $cbcomp['cpb_build_show_short_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_short_description ='".$cpb_build_show_short_description."' WHERE cpb_build_show_short_description ='".$cbcomp['cpb_build_show_short_description']."'");
          }
          if (($cpb_popup_short_description_length != "")&($cpb_popup_short_description_length != $cbcomp['cpb_popup_short_description_length'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_short_description_length ='".$cpb_popup_short_description_length."' WHERE cpb_popup_short_description_length ='".$cbcomp['cpb_popup_short_description_length']."'");
          }
          if (($cpb_popup_show_short_description != "")&($cpb_popup_show_short_description != $cbcomp['cpb_popup_show_short_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_show_short_description ='".$cpb_popup_show_short_description."' WHERE cpb_popup_show_short_description ='".$cbcomp['cpb_popup_show_short_description']."'");
          }
          if (($cpb_build_auto_clear_list != "")&($cpb_build_auto_clear_list != $cbcomp['cpb_build_auto_clear_list'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_auto_clear_list ='".$cpb_build_auto_clear_list."' WHERE cpb_build_auto_clear_list ='".$cbcomp['cpb_build_auto_clear_list']."'");
          }
          if (($cpb_build_auto_clear_count != "")&($cpb_build_auto_clear_count != $cbcomp['cpb_build_auto_clear_count'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_auto_clear_count ='".$cpb_build_auto_clear_count."' WHERE cpb_build_auto_clear_count ='".$cbcomp['cpb_build_auto_clear_count']."'");
          }
          if (($cpb_build_show_url != "")&($cpb_build_show_url != $cbcomp['cpb_build_show_url'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_url ='".$cpb_build_show_url."' WHERE cpb_build_show_url ='".$cbcomp['cpb_build_show_url']."'");
          }
          if (($cpb_build_url_suffix != "")&($cpb_build_url_suffix != $cbcomp['cpb_build_url_suffix'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_url_suffix ='".$cpb_build_url_suffix."' WHERE cpb_build_url_suffix ='".$cbcomp['cpb_build_url_suffix']."'");
          }
          if (($cpb_build_priority != "")&($cpb_build_priority != $cbcomp['cpb_build_priority'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_priority ='".$cpb_build_priority."' WHERE cpb_build_priority ='".$cbcomp['cpb_build_priority']."'");
          }
          if (($cpb_build_priority_count != "")&($cpb_build_priority_count != $cbcomp['cpb_build_priority_count'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_priority_count ='".$cpb_build_priority_count."' WHERE cpb_build_priority_count ='".$cbcomp['cpb_build_priority_count']."'");
          }
          if (($cpb_build_price_in_description != "")&($cpb_build_price_in_description != $cbcomp['cpb_build_price_in_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_price_in_description ='".$cpb_build_price_in_description."' WHERE cpb_build_price_in_description ='".$cbcomp['cpb_build_price_in_description']."'");
          }
          if (($cpb_build_in_reverse != "")&($cpb_build_in_reverse != $cbcomp['cpb_build_in_reverse'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_in_reverse ='".$cpb_build_in_reverse."' WHERE cpb_build_in_reverse ='".$cbcomp['cpb_build_in_reverse']."'");
          }
          if (($cpb_build_priority_depends_only != "")&($cpb_build_priority_depends_only != $cbcomp['cpb_build_priority_depends_only'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_priority_depends_only ='".$cpb_build_priority_depends_only."' WHERE cpb_build_priority_depends_only ='".$cbcomp['cpb_build_priority_depends_only']."'");
          }
          if (($cpb_build_allow_built_by != "")&($cpb_build_allow_built_by != $cbcomp['cpb_build_allow_built_by'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_built_by ='".$cpb_build_allow_built_by."' WHERE cpb_build_allow_built_by ='".$cbcomp['cpb_build_allow_built_by']."'");
          }
          if (($cpb_build_preview_single != "")&($cpb_build_preview_single != $cbcomp['cpb_build_preview_single'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_preview_single ='".$cpb_build_preview_single."' WHERE cpb_build_preview_single ='".$cbcomp['cpb_build_preview_single']."'");
          }
          if (($cpb_build_component_qty_max != "")&($cpb_build_component_qty_max != $cbcomp['cpb_build_component_qty_max'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_component_qty_max ='".$cpb_build_component_qty_max."' WHERE cpb_build_component_qty_max ='".$cbcomp['cpb_build_component_qty_max']."'");
          }
          if (($cpb_build_product_status_default != "")&($cpb_build_product_status_default != $cbcomp['cpb_build_product_status_default'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_status_default ='".$cpb_build_product_status_default."' WHERE cpb_build_product_status_default ='".$cbcomp['cpb_build_product_status_default']."'");
          }
          if (($cpb_build_product_stock_default != "")&($cpb_build_product_stock_default != $cbcomp['cpb_build_product_stock_default'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_stock_default ='".$cpb_build_product_stock_default."' WHERE cpb_build_product_stock_default ='".$cbcomp['cpb_build_product_stock_default']."'");
          }
          if (($cpb_build_assembly_fee_name != "")&($cpb_build_assembly_fee_name != $cbcomp['cpb_build_assembly_fee_name'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_assembly_fee_name ='".$cpb_build_assembly_fee_name."' WHERE cpb_build_assembly_fee_name ='".$cbcomp['cpb_build_assembly_fee_name']."'");
          }
          if (($cpb_build_product_details_ontop != "")&($cpb_build_product_details_ontop != $cbcomp['cpb_build_product_details_ontop'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_details_ontop ='".$cpb_build_product_details_ontop."' WHERE cpb_build_product_details_ontop ='".$cbcomp['cpb_build_product_details_ontop']."'");
          }
          if (($cpb_build_unsort_components != "")&($cpb_build_unsort_components != $cbcomp['cpb_build_unsort_components'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_unsort_components ='".$cpb_build_unsort_components."' WHERE cpb_build_unsort_components ='".$cbcomp['cpb_build_unsort_components']."'");
          }
          if (($cpb_popup_sort_by_price != "")&($cpb_popup_sort_by_price != $cbcomp['cpb_popup_sort_by_price'])) {
            tep_db_query("UPDATE builder_options SET cpb_popup_sort_by_price ='".$cpb_popup_sort_by_price."' WHERE cpb_popup_sort_by_price ='".$cbcomp['cpb_popup_sort_by_price']."'");
          }
          if (($cpb_build_built_by_default != "")&($cpb_build_built_by_default != $cbcomp['cpb_build_built_by_default'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_built_by_default ='".$cpb_build_built_by_default."' WHERE cpb_build_built_by_default ='".$cbcomp['cpb_build_built_by_default']."'");
          }
          if (($cpb_build_disable_after_carted != "")&($cpb_build_disable_after_carted != $cbcomp['cpb_build_disable_after_carted'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_disable_after_carted ='".$cpb_build_disable_after_carted."' WHERE cpb_build_disable_after_carted ='".$cbcomp['cpb_build_disable_after_carted']."'");
          }
          if (($cpb_auto_disable_time != "")&($cpb_auto_disable_time != $cbcomp['cpb_auto_disable_time'])) {
            tep_db_query("UPDATE builder_options SET cpb_auto_disable_time ='".$cpb_auto_disable_time."' WHERE cpb_auto_disable_time ='".$cbcomp['cpb_auto_disable_time']."'");
          }
          if (($cpb_build_manufacturer_id_default != "")&($cpb_build_manufacturer_id_default != $cbcomp['cpb_build_manufacturer_id_default'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_manufacturer_id_default ='".$cpb_build_manufacturer_id_default."' WHERE cpb_build_manufacturer_id_default ='".$cbcomp['cpb_build_manufacturer_id_default']."'");
          }
          if (($cpb_build_name_suffix != "")&($cpb_build_name_suffix != $cbcomp['cpb_build_name_suffix'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_name_suffix ='".$cpb_build_name_suffix."' WHERE cpb_build_name_suffix ='".$cbcomp['cpb_build_name_suffix']."'");
          }
          if (($cpb_build_cart_reset != "")&($cpb_build_cart_reset != $cbcomp['cpb_build_cart_reset'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_cart_reset ='".$cpb_build_cart_reset."' WHERE cpb_build_cart_reset ='".$cbcomp['cpb_build_cart_reset']."'");
          }
          if (($cpb_build_id_in_description != "")&($cpb_build_id_in_description != $cbcomp['cpb_build_id_in_description'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_id_in_description ='".$cpb_build_id_in_description."' WHERE cpb_build_id_in_description ='".$cbcomp['cpb_build_id_in_description']."'");
          }
          if (($cpb_build_show_category_image != "")&($cpb_build_show_category_image != $cbcomp['cpb_build_show_category_image'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_category_image ='".$cpb_build_show_category_image."' WHERE cpb_build_show_category_image ='".$cbcomp['cpb_build_show_category_image']."'");
          }
          if (($cpb_build_category_image_height != "")&($cpb_build_category_image_height != $cbcomp['cpb_build_category_image_height'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_category_image_height ='".$cpb_build_category_image_height."' WHERE cpb_build_category_image_height ='".$cbcomp['cpb_build_category_image_height']."'");
          }
          if (($cpb_build_category_image_width != "")&($cpb_build_category_image_width != $cbcomp['cpb_build_category_image_width'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_category_image_width ='".$cpb_build_category_image_width."' WHERE cpb_build_category_image_width ='".$cbcomp['cpb_build_category_image_width']."'");
          }
          if (($cpb_build_product_tax_class_default != "")&($cpb_build_product_tax_class_default != $cbcomp['cpb_build_product_tax_class_default'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_product_tax_class_default ='".$cpb_build_product_tax_class_default."' WHERE cpb_build_product_tax_class_default ='".$cbcomp['cpb_build_product_tax_class_default']."'");
          }
          if (($cpb_ignore_tax != "")&($cpb_ignore_tax != $cbcomp['cpb_ignore_tax'])) {
            tep_db_query("UPDATE builder_options SET cpb_ignore_tax ='".$cpb_ignore_tax."' WHERE cpb_ignore_tax ='".$cbcomp['cpb_ignore_tax']."'");
          }
          if (($cpb_build_show_tax != "")&($cpb_build_show_tax != $cbcomp['cpb_build_show_tax'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_show_tax ='".$cpb_build_show_tax."' WHERE cpb_build_show_tax ='".$cbcomp['cpb_build_show_tax']."'");
          }
          if (($cpb_build_minimum_order != "")&($cpb_build_minimum_order != $cbcomp['cpb_build_minimum_order'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_minimum_order ='".$cpb_build_minimum_order."' WHERE cpb_build_minimum_order ='".$cbcomp['cpb_build_minimum_order']."'");
          }
          if (($cpb_build_minimum_order_count != "")&($cpb_build_minimum_order_count != $cbcomp['cpb_build_minimum_order_count'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_minimum_order_count ='".$cpb_build_minimum_order_count."' WHERE cpb_build_minimum_order_count ='".$cbcomp['cpb_build_minimum_order_count']."'");
          }
          if (($cpb_build_allow_image_upload != "")&($cpb_build_allow_image_upload != $cbcomp['cpb_build_allow_image_upload'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_allow_image_upload ='".$cpb_build_allow_image_upload."' WHERE cpb_build_allow_image_upload ='".$cbcomp['cpb_build_allow_image_upload']."'");
          }
          if (($cpb_build_image_upload_size != "")&($cpb_build_image_upload_size != $cbcomp['cpb_build_image_upload_size'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_image_upload_size ='".$cpb_build_image_upload_size."' WHERE cpb_build_image_upload_size ='".$cbcomp['cpb_build_image_upload_size']."'");
          }
          if (($cpb_build_image_upload_folder != "")&($cpb_build_image_upload_folder != $cbcomp['cpb_build_image_upload_folder'])) {
            tep_db_query("UPDATE builder_options SET cpb_build_image_upload_folder ='".$cpb_build_image_upload_folder."' WHERE cpb_build_image_upload_folder ='".$cbcomp['cpb_build_image_upload_folder']."'");
          }

        }
      }
      tep_redirect(tep_href_link('builder_options.php'));
    break;
  }

} else { // no action

// be sure the tables already exist
  if(tep_db_num_rows(tep_db_query("SHOW TABLES LIKE 'builder_options'"))==1) {

// get options
    $cbcomp_query = tep_db_query("select * from builder_options");
    while ($cbcomp = tep_db_fetch_array($cbcomp_query)) {
      $cpb_system_assembly= $cbcomp['cpb_system_assembly'];
      $cpb_assembly_osccat= $cbcomp['cpb_assembly_osccat'];
      $cpb_use_dependence= $cbcomp['cpb_use_dependence'];
      $cpb_use_software= $cbcomp['cpb_use_software'];
      $cpb_build_osccat= $cbcomp['cpb_build_osccat'];
      $cpb_build_name= $cbcomp['cpb_build_name'];
      $cpb_build_description= $cbcomp['cpb_build_description'];
      $cpb_build_image= $cbcomp['cpb_build_image'];
      $cpb_build_url= $cbcomp['cpb_build_url'];
      $cpb_build_model= $cbcomp['cpb_build_model'];
      $cpb_reduce_stock= $cbcomp['cpb_reduce_stock'];
      $cpb_build_one_product= $cbcomp['cpb_build_one_product'];
      $cpb_popup_height= $cbcomp['cpb_popup_height'];
      $cpb_popup_offset_left= $cbcomp['cpb_popup_offset_left'];
      $cpb_popup_offset_top= $cbcomp['cpb_popup_offset_top'];
      $cpb_show_nostock= $cbcomp['cpb_show_nostock'];
      $cpb_show_disabled= $cbcomp['cpb_show_disabled'];
      $cpb_ignore_specials= $cbcomp['cpb_ignore_specials'];
      $cpb_build_allow_name= $cbcomp['cpb_build_allow_name'];
      $cpb_build_allow_description= $cbcomp['cpb_build_allow_description'];
      $cpb_build_allow_image= $cbcomp['cpb_build_allow_image'];
      $cpb_build_model_suffix= $cbcomp['cpb_build_model_suffix'];
      $cpb_auto_delete_time= $cbcomp['cpb_auto_delete_time'];
      $cpb_build_allow_nostock= $cbcomp['cpb_build_allow_nostock'];
      $cpb_build_allow_disabled= $cbcomp['cpb_build_allow_disabled'];
      $cpb_build_allow_disable_product= $cbcomp['cpb_build_allow_disable_product'];
      $cpb_product_builder_name= $cbcomp['cpb_product_builder_name'];
      $cpb_product_builder_image= $cbcomp['cpb_product_builder_image'];
      $cpb_popup_show_product_image= $cbcomp['cpb_popup_show_product_image'];
      $cpb_build_show_product_image= $cbcomp['cpb_build_show_product_image'];
      $cpb_build_show_product_quantity= $cbcomp['cpb_build_show_product_quantity'];
      $cpb_build_show_built_by= $cbcomp['cpb_build_show_built_by'];
      $cpb_build_product_image_height= $cbcomp['cpb_build_product_image_height'];
      $cpb_build_product_image_width= $cbcomp['cpb_build_product_image_width'];
      $cpb_popup_product_image_height= $cbcomp['cpb_popup_product_image_height'];
      $cpb_popup_product_image_width= $cbcomp['cpb_popup_product_image_width'];
      $cpb_category_images_folder= $cbcomp['cpb_category_images_folder'];
      $cpb_product_images_folder= $cbcomp['cpb_product_images_folder'];
      $cpb_build_product_price_fix= $cbcomp['cpb_build_product_price_fix'];
      $cpb_build_assembly_image= $cbcomp['cpb_build_assembly_image'];
      $cpb_build_allow_set_type= $cbcomp['cpb_build_allow_set_type'];
      $cpb_matrix_edit_default_lines_per_page= $cbcomp['cpb_matrix_edit_default_lines_per_page'];
      $cpb_matrix_edit_show_nostock= $cbcomp['cpb_matrix_edit_show_nostock'];
      $cpb_matrix_edit_show_disabled= $cbcomp['cpb_matrix_edit_show_disabled'];
      $cpb_build_short_description_length= $cbcomp['cpb_build_short_description_length'];
      $cpb_build_show_short_description= $cbcomp['cpb_build_show_short_description'];
      $cpb_popup_short_description_length= $cbcomp['cpb_popup_short_description_length'];
      $cpb_popup_show_short_description= $cbcomp['cpb_popup_show_short_description'];
      $cpb_build_auto_clear_list= $cbcomp['cpb_build_auto_clear_list'];
      $cpb_build_auto_clear_count= $cbcomp['cpb_build_auto_clear_count'];
      $cpb_build_show_url= $cbcomp['cpb_build_show_url'];
      $cpb_build_url_suffix= $cbcomp['cpb_build_url_suffix'];
      $cpb_build_priority= $cbcomp['cpb_build_priority'];
      $cpb_build_priority_count= $cbcomp['cpb_build_priority_count'];
      $cpb_build_price_in_description= $cbcomp['cpb_build_price_in_description'];
      $cpb_build_in_reverse= $cbcomp['cpb_build_in_reverse'];
      $cpb_build_priority_depends_only= $cbcomp['cpb_build_priority_depends_only'];
      $cpb_build_allow_built_by= $cbcomp['cpb_build_allow_built_by'];
      $cpb_build_preview_single= $cbcomp['cpb_build_preview_single'];
      $cpb_build_component_qty_max= $cbcomp['cpb_build_component_qty_max'];
      $cpb_build_product_status_default= $cbcomp['cpb_build_product_status_default'];
      $cpb_build_product_stock_default= $cbcomp['cpb_build_product_stock_default'];
      $cpb_build_assembly_fee_name= $cbcomp['cpb_build_assembly_fee_name'];
      $cpb_build_product_details_ontop= $cbcomp['cpb_build_product_details_ontop'];
      $cpb_build_unsort_components= $cbcomp['cpb_build_unsort_components'];
      $cpb_popup_sort_by_price= $cbcomp['cpb_popup_sort_by_price'];
      $cpb_build_built_by_default= $cbcomp['cpb_build_built_by_default'];
      $cpb_build_disable_after_carted= $cbcomp['cpb_build_disable_after_carted'];
      $cpb_auto_disable_time= $cbcomp['cpb_auto_disable_time'];
      $cpb_build_manufacturer_id_default= $cbcomp['cpb_build_manufacturer_id_default'];
      $cpb_build_name_suffix= $cbcomp['cpb_build_name_suffix'];
      $cpb_build_cart_reset= $cbcomp['cpb_build_cart_reset'];
      $cpb_build_id_in_description= $cbcomp['cpb_build_id_in_description'];
      $cpb_build_show_category_image= $cbcomp['cpb_build_show_category_image'];
      $cpb_build_category_image_height= $cbcomp['cpb_build_category_image_height'];
      $cpb_build_category_image_width= $cbcomp['cpb_build_category_image_width'];
      $cpb_build_product_tax_class_default= $cbcomp['cpb_build_product_tax_class_default'];
      $cpb_ignore_tax= $cbcomp['cpb_ignore_tax'];
      $cpb_build_show_tax= $cbcomp['cpb_build_show_tax'];
      $cpb_build_minimum_order= $cbcomp['cpb_build_minimum_order'];
      $cpb_build_minimum_order_count= $cbcomp['cpb_build_minimum_order_count'];
      $cpb_build_allow_image_upload= $cbcomp['cpb_build_allow_image_upload'];
      $cpb_build_image_upload_size= $cbcomp['cpb_build_image_upload_size'];
      $cpb_build_image_upload_folder= $cbcomp['cpb_build_image_upload_folder'];
    }
  }
}

        require('includes/template_top.php');
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><?php echo tep_draw_form('builder', 'builder_options.php', tep_get_all_get_params(array('action')) . 'action=update', 'post', '');?><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo $cpb_product_builder_name . '&nbsp;-&nbsp;' . HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image( 'images/table_background_builder.gif', $cpb_product_builder_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

<!-- FORM CONTENT STARTS HERE -->

      <table width="100%" border="0" cellspacing="0" cellpadding="3">

<!-- BUILDER CONFIGURATIONS START HERE -->

        <tr>

<?php
if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE 'builder_options'"))!=1) {
?>
          <td valign="top" colspan="2">
            <table bgcolor="red" width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr class="main">
                <td><?php echo "<font color='yellow'><b>here" . TEXT_NO_TABLES . "</b></font>";?></td>
              </tr>
            </table>
          </td>

<?php
} else {
?>

          <td colspan="2">
            <table width="100%" bgcolor="#CFDFEF" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_BUILDER_OPTIONS; ?></b></td>
              </tr>
              <tr class="main">

                <td class="smallText" align="right" width="50%">
                  <?php echo TEXT_USE_SOFTWARE; ?>
                </td>
                <td class="smallText" align="left" width="50%">
                  <input type="radio" name="cpb_use_software" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_use_software" value="1" <?php if ($cpb_use_software==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_USE_DEPENDENCE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_use_dependence" value="0" checked="checked" class="inputbox"  /><?php echo NO;?>
                  <input type="radio" name="cpb_use_dependence" value="1" <?php if ($cpb_use_dependence==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_IGNORE_SPECIALS; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_ignore_specials" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_ignore_specials" value="1" <?php if ($cpb_ignore_specials==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_IGNORE_TAX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_ignore_tax" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_ignore_tax" value="1" <?php if ($cpb_ignore_tax==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_TAX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_tax" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_tax" value="1" <?php if ($cpb_build_show_tax==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ONE_PRODUCT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_one_product" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_one_product" value="1" <?php if ($cpb_build_one_product==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_CART_RESET; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_cart_reset" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_cart_reset" value="1" <?php if ($cpb_build_cart_reset==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PREVIEW_SINGLE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_preview_single" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_preview_single" value="1" <?php if ($cpb_build_preview_single==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_STATUS_DEFAULT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_product_status_default" value="1" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_product_status_default" value="0" <?php if ($cpb_build_product_status_default==0)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_DISABLE_AFTER_CARTED; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_disable_after_carted" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_disable_after_carted" value="1" <?php if ($cpb_build_disable_after_carted==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_PRODUCT_BUILDER_NAME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_product_builder_name" value='<?php echo $cpb_product_builder_name; ?>' size="35">
                </td>

              </tr>

<?php
$the_files_array = Array();
$handle = opendir(DIR_FS_CATALOG . 'images/');
while (false!== ($file = readdir($handle))) {
  if ($file!= "." && $file!= ".." &&!is_dir($file)) {
    $namearr = preg_split('/\./',$file);
    if (($namearr[count($namearr)-1] == 'gif') || ($namearr[count($namearr)-1] == 'jpg') || ($namearr[count($namearr)-1] == 'png')) {
      $the_files_array[] = array( 'text' => $file, 'id' => $file);
    }
  }
}
      natsort($the_files_array);
closedir($handle);
?>

              <tr class="main">
                <td class="smallText" align="right">
                  <?php echo TEXT_PRODUCT_BUILDER_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_product_builder_image', $the_files_array, $cpb_product_builder_image, 'style="width: 20em;"');?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_MATRIX_EDIT_SHOW_NOSTOCK; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_matrix_edit_show_nostock" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_matrix_edit_show_nostock" value="1" <?php if ($cpb_matrix_edit_show_nostock==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_MATRIX_EDIT_SHOW_DISABLED; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_matrix_edit_show_disabled" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_matrix_edit_show_disabled" value="1" <?php if ($cpb_matrix_edit_show_disabled==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_MATRIX_EDIT_DEFAULT_LINES_PER_PAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_matrix_edit_default_lines_per_page" value='<?php echo $cpb_matrix_edit_default_lines_per_page; ?>' size="4">
                </td>

              </tr>

              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_ASSEMBLY_FEE_OPTIONS; ?></b></td>
              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_CATEGORY_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_category_image" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_category_image" value="1" <?php if ($cpb_build_show_category_image==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_CATEGORY_IMAGES_FOLDER; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_category_images_folder" value='<?php echo $cpb_category_images_folder; ?>' size="30">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_CATEGORY_IMAGE_WIDTH; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_category_image_width" value='<?php echo $cpb_build_category_image_width; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_CATEGORY_IMAGE_HEIGHT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_category_image_height" value='<?php echo $cpb_build_category_image_height; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_USE_ASSEMBLY; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_system_assembly" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_system_assembly" value="1" <?php if ($cpb_system_assembly==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_ASSEMBLY_ID; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_assembly_osccat', tep_get_category_tree(0, '', '0', '', false), $cpb_assembly_osccat);?>
                </td>

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
      natsort($the_files_array);
closedir($handle);
?>
              <tr class="main">
                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ASSEMBLY_FEE_NAME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_assembly_fee_name" value='<?php echo $cpb_build_assembly_fee_name; ?>' size="25">
                </td>
              </tr>

              <tr class="main">
                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ASSEMBLY_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_build_assembly_image', $the_files_array, $cpb_build_assembly_image, 'style="width: 20em;"');?>
                </td>
              </tr>

              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_COMPONENT_OPTIONS; ?></b></td>
              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_PRODUCT_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_product_image" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_product_image" value="1" <?php if ($cpb_build_show_product_image==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_IMAGE_WIDTH; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_product_image_width" value='<?php echo $cpb_build_product_image_width; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_IMAGE_HEIGHT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_product_image_height" value='<?php echo $cpb_build_product_image_height; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_SHORT_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_short_description" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_short_description" value="1" <?php if ($cpb_build_show_short_description==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHORT_DESCRIPTION_LENGTH; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_short_description_length" value='<?php echo $cpb_build_short_description_length; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_PRODUCT_QUANTITY; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_product_quantity" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_product_quantity" value="1" <?php if ($cpb_build_show_product_quantity==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_COMPONENT_QTY_MAX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_component_qty_max" value='<?php echo $cpb_build_component_qty_max; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRIORITY; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_priority" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_priority" value="1" <?php if ($cpb_build_priority==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>
              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRIORITY_COUNT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_priority_count" value='<?php echo $cpb_build_priority_count; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_AUTO_CLEAR_LIST; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_auto_clear_list" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_auto_clear_list" value="1" <?php if ($cpb_build_auto_clear_list==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_AUTO_CLEAR_COUNT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_auto_clear_count" value='<?php echo $cpb_build_auto_clear_count; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_MINIMUM_ORDER; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_minimum_order" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_minimum_order" value="1" <?php if ($cpb_build_minimum_order==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>
              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_MINIMUM_ORDER_COUNT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_minimum_order_count" value='<?php echo $cpb_build_minimum_order_count; ?>' size="4">
                </td>

              </tr>


              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_POPUP_OPTIONS; ?></b></td>
              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_HEIGHT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_height" value='<?php echo $cpb_popup_height; ?>' size="6">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_OFFSET_LEFT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_offset_left" value='<?php echo $cpb_popup_offset_left; ?>' size="6">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_OFFSET_TOP; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_offset_top" value='<?php echo $cpb_popup_offset_top; ?>' size="6">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_SHOW_NOSTOCK; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_show_nostock" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_show_nostock" value="1" <?php if ($cpb_show_nostock==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_SHOW_DISABLED; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_show_disabled" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_show_disabled" value="1" <?php if ($cpb_show_disabled==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_SHOW_PRODUCT_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_popup_show_product_image" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_popup_show_product_image" value="1" <?php if ($cpb_popup_show_product_image==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_PRODUCT_IMAGE_WIDTH; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_product_image_width" value='<?php echo $cpb_popup_product_image_width; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_PRODUCT_IMAGE_HEIGHT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_product_image_height" value='<?php echo $cpb_popup_product_image_height; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_SHOW_SHORT_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_popup_show_short_description" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_popup_show_short_description" value="1" <?php if ($cpb_popup_show_short_description==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_SHORT_DESCRIPTION_LENGTH; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_popup_short_description_length" value='<?php echo $cpb_popup_short_description_length; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_POPUP_SORT_BY_PRICE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_popup_sort_by_price" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_popup_sort_by_price" value="1" <?php if ($cpb_popup_sort_by_price==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>

              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_BUILDER_MODE_OPTIONS; ?></b></td>
              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_REDUCE_STOCK; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_reduce_stock" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_reduce_stock" value="1" <?php if ($cpb_reduce_stock==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_DISABLE_PRODUCT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_disable_product" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_disable_product" value="1" <?php if ($cpb_build_allow_disable_product==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_NOSTOCK; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_nostock" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_nostock" value="1" <?php if ($cpb_build_allow_nostock==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_DISABLED; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_disabled" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_disabled" value="1" <?php if ($cpb_build_allow_disabled==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_UNSORT_COMPONENTS; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_unsort_components" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_unsort_components" value="1" <?php if ($cpb_build_unsort_components==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_IN_REVERSE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_in_reverse" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_in_reverse" value="1" <?php if ($cpb_build_in_reverse==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ID_IN_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_id_in_description" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_id_in_description" value="1" <?php if ($cpb_build_id_in_description==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_PRICE_FIX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_product_price_fix" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_product_price_fix" value="1" <?php if ($cpb_build_product_price_fix==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRICE_IN_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_price_in_description" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_price_in_description" value="1" <?php if ($cpb_build_price_in_description==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_OSCCAT; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_build_osccat', tep_get_category_tree(0, '', '0', '', false), $cpb_build_osccat);?>
                </td>
              </tr>

              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_SINGLE_BUILD_OPTIONS; ?></b></td>
              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_DETAILS_ONTOP; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_product_details_ontop" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_product_details_ontop" value="1" <?php if ($cpb_build_product_details_ontop==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_NAME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_name" value='<?php echo $cpb_build_name; ?>' size="20">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_NAME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_name" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_name" value="1" <?php if ($cpb_build_allow_name==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_NAME_SUFFIX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_name_suffix" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_name_suffix" value="1" <?php if ($cpb_build_name_suffix==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right" valign="top">
                  <?php echo TEXT_BUILD_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_textarea_field('cpb_build_description', 'soft', '35', '5', $cpb_build_description); ?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_DESCRIPTION; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_description" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_description" value="1" <?php if ($cpb_build_allow_description==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_MANUFACTURER_ID_DEFAULT; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_build_manufacturer_id_default', tep_get_manufacturers(), $cpb_build_manufacturer_id_default, 'style="width:15em;"');?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_MODEL; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_model" value='<?php echo $cpb_build_model; ?>' size="6">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_MODEL_SUFFIX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_model_suffix" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_model_suffix" value="1" <?php if ($cpb_build_model_suffix==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_image" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_image" value="1" <?php if ($cpb_build_allow_image==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_PRODUCT_IMAGES_FOLDER; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_product_images_folder" value='<?php echo $cpb_product_images_folder; ?>' size="30">
                </td>

              </tr>

<?php
$the_files_array = Array();
$handle = opendir(DIR_FS_CATALOG . 'images/' . $cpb_product_images_folder);
while (false!== ($file = readdir($handle))) {
  if ($file!= "." && $file!= ".." &&!is_dir($file)) {
    $namearr = preg_split('/\./',$file);
    if (($namearr[count($namearr)-1] == 'gif') || ($namearr[count($namearr)-1] == 'jpg') || ($namearr[count($namearr)-1] == 'png')) {
      $the_files_array[] = array( 'text' => $file, 'id' => $file);
    }
  }
}
      natsort($the_files_array);
closedir($handle);
?>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_IMAGE; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_build_image', $the_files_array, $cpb_build_image, 'style="width: 20em;"');?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_IMAGE_UPLOAD; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_image_upload" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_image_upload" value="1" <?php if ($cpb_build_allow_image_upload==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_IMAGE_UPLOAD_SIZE; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_image_upload_size" value='<?php echo $cpb_build_image_upload_size; ?>' size="8">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_IMAGE_UPLOAD_FOLDER; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_image_upload_folder" value='<?php echo $cpb_build_image_upload_folder; ?>' size="30">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_URL; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_url" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_url" value="1" <?php if ($cpb_build_show_url==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_URL; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_url" value='<?php echo $cpb_build_url; ?>' size="40">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_URL_SUFFIX; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_url_suffix" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_url_suffix" value="1" <?php if ($cpb_build_url_suffix==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_SHOW_BUILT_BY; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_show_built_by" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_show_built_by" value="1" <?php if ($cpb_build_show_built_by==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_BUILT_BY_DEFAULT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_built_by_default" value='<?php echo $cpb_build_built_by_default; ?>' size="15">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_ALLOW_BUILT_BY; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="radio" name="cpb_build_allow_built_by" value="0" checked="checked" class="inputbox" /><?php echo NO;?>
                  <input type="radio" name="cpb_build_allow_built_by" value="1" <?php if ($cpb_build_allow_built_by==1)echo 'checked="checked"';?> class="inputbox" selected /><?php echo YES;?>
                </td>

              </tr>

<?php
$tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
$tax_class_query = tep_db_query("select tax_class_id, tax_class_title from tax_class order by tax_class_title");
while ($tax_class = tep_db_fetch_array($tax_class_query)) {
  $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                             'text' => $tax_class['tax_class_title']);
}
?>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_TAX_CLASS_DEFAULT; ?>
                </td>
                <td class="smallText" align="left">
                  <?php echo tep_draw_pull_down_menu('cpb_build_product_tax_class_default', $tax_class_array, $cpb_build_product_tax_class_default, 'style="width: 15em;"');?>
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_BUILD_PRODUCT_STOCK_DEFAULT; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_build_product_stock_default" value='<?php echo $cpb_build_product_stock_default; ?>' size="4">
                </td>

              </tr>

              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><b><?php echo TEXT_AFTER_BUILD_OPTIONS; ?></b></td>
              </tr>

              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_AUTO_DISABLE_TIME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_auto_disable_time" value='<?php echo $cpb_auto_disable_time; ?>' size="4">
                </td>

              </tr>
              <tr class="main">

                <td class="smallText" align="right">
                  <?php echo TEXT_AUTO_DELETE_TIME; ?>
                </td>
                <td class="smallText" align="left">
                  <input type="text" name="cpb_auto_delete_time" value='<?php echo $cpb_auto_delete_time; ?>' size="4">
                </td>

              </tr>
              <tr bgcolor="#95C1FA" class="main">
                <td class="smallText" colspan="8" align="left"><br></td>
              </tr>
            </table>
          </td>
<?php
 }
?>
          <td width="15%" valign="top" >
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