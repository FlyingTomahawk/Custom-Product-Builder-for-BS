<?php
/*
  $Id: builder_add_attribute.php, v 1.1.1 2008/12/19 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// THIS FILE IS INCLUDED TO BUILDER_MAIN (TWICE BUT ONLY LOADED ONCE) - DOING IT THIS WAY JUST MAKES MAINTAINING THE SOURCE EASIER
          if (strlen($components_name[$i]) > 0) {
// CHECK IF OPTION EXISTS
            $option_name = tep_db_prepare_input($pccat[$i]);
            $q = "select products_options_id as o_next_id from " . TABLE_PRODUCTS_OPTIONS . " where products_options_name='" . mysql_real_escape_string($option_name) . "'"; 
            $res = tep_db_query($q);                               
            if(tep_db_num_rows($res)) {
                $ar = tep_db_fetch_array($res);
                $next_options_id = (int)$ar['o_next_id'];      
            } else {    
// GET NEXT AVAILABLE OPTIONS & VALUES IDS
                $max_options_id_query = tep_db_query("select max(products_options_id) + 1 as o_next_id from " . TABLE_PRODUCTS_OPTIONS);
                $max_options_id_values = tep_db_fetch_array($max_options_id_query);
                $next_options_id = $max_options_id_values['o_next_id'];
// ADD OPTION
                $products_options_id = tep_db_prepare_input($next_options_id);
                tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, products_options_name, language_id) values ('" . (int)$products_options_id . "', '" . tep_db_input($option_name) . "', '" . (int)$languages_id . "')");
            }
                                                           
            $option_id = tep_db_prepare_input($next_options_id);
                                                              

                $value_name = strip_tags(addslashes($components_name[$i]));
// INCLUDE COMPONENT ID (osC product id) IN DESCRIPTION - this is purely for HRT - and that's why toggleable
                if ($cpb_build_id_in_description) {
                    $value_name .= ' [#' . $products_count[$i] . '] ';
                }
// INCLUDE PRICE IN DESCRIPTION ONLY IF FIXED PRICING IS ENABLED!
                if (($cpb_build_price_in_description) && ($cpb_build_product_price_fix)) {
                  $value_name .= " (" . $currencies->format($components_price[$i]*$components_quantity[$i],true) . ")"; 
                }
                $value_name = tep_db_prepare_input($value_name); 
                

// CHECK IF OPTIONS VALUE EXISTS
            $q = "select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where catalog_products_id=" . tep_db_prepare_input($products_count[$i]); 
            $res = tep_db_query($q);                               
            if(tep_db_num_rows($res)) {
                $ar = tep_db_fetch_array($res);
                $value_id = $next_values_id = (int)$ar['products_options_values_id'];  
                tep_db_query('update products_options_values set products_options_values_name="' . $value_name .'" where products_options_values_id=' . $value_id);
            } else {                                       
                $max_values_id_query = tep_db_query("select max(products_options_values_id) + 1 as v_next_id from " . TABLE_PRODUCTS_OPTIONS_VALUES);
                $max_values_id_values = tep_db_fetch_array($max_values_id_query);
                $next_values_id = (int)$max_values_id_values['v_next_id'];
                             
    // ADD OPTION VALUE - two new fields added to option_values table (pid & qty), these are used for returning components to stock when deleting builds                          
                $value_id = tep_db_prepare_input($next_values_id);         

                tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name, catalog_products_id, catalog_products_quantity) values ('" . (int)$value_id . "', '" . (int)$languages_id . "', '" . $value_name . "', '" . tep_db_input($products_count[$i]) . "', '" . (int)$components_quantity[$i] . "')");
            }
            
// ADD NEW IDS TO ATTRIBUTE LIST (for direct to cart singles)
            $cpb_attribute_list[$next_options_id]=$next_values_id;
            
            $res = tep_db_query('select * from ' . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . ' where products_options_id=' . $option_id . ' and products_options_values_id=' . $value_id);            if(!tep_db_num_rows($res)) {                                    
                tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$option_id . "', '" . (int)$value_id . "')"); 
            }        

// ADD ATTRIBUTE TO PRODUCT
            $options_id = tep_db_prepare_input($option_id);
            $values_id = tep_db_prepare_input($value_id);
            if ($cpb_build_product_price_fix) {
              $value_price = tep_db_prepare_input('0');
            } else {
              $value_price = tep_db_prepare_input($components_price[$i]*$components_quantity[$i]);
            }
            $price_prefix = tep_db_prepare_input('+');
            tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values (NULL, '" . (int)$products_id . "', '" . (int)$options_id . "', '" . (int)$values_id . "', '" . tep_db_input($value_price) . "', '" . tep_db_input($price_prefix) . "')");
          }
// END OF THIS MODULE
?>
