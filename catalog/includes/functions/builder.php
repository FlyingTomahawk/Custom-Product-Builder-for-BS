<?php
/*
  $Id: builder.php,v 1.1.0 2008/12/06 22:10:10 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

////
// DISABLE EXPIRED BUILDS
  function _disable_builds($timeout) {
    $builds_query = tep_db_query("select products_id from " . TABLE_PRODUCTS . " where builder_product_flag = '1' and products_date_added < DATE_SUB(now(), INTERVAL " . $timeout . " HOUR)");
    if (tep_db_num_rows($builds_query)) {
      while ($builds = tep_db_fetch_array($builds_query)) {
        tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . (int)$builds['products_id'] . "'");
      }
    }
  }

////
// DELETE EXPIRED BUILDS - SLAPPED THIS TOGETHER - OPTIMIZE ME!
  function _delete_builds($timeout, $restock = 0, $renable = 0) {

    $builds_query = tep_db_query("select products_id, products_status, products_quantity from " . TABLE_PRODUCTS . " where builder_product_flag = '1' and products_date_added < DATE_SUB(now(), INTERVAL " . $timeout . " HOUR)");
    if (tep_db_num_rows($builds_query)) {
      while ($builds = tep_db_fetch_array($builds_query)) {

        $attributes_query = tep_db_query("select options_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = " . $builds['products_id']);
        if (tep_db_num_rows($attributes_query)) {
          while ($attributes = tep_db_fetch_array($attributes_query)) {

            $values_id_query = tep_db_query("select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = " . $attributes['options_id']);
            if (tep_db_num_rows($values_id_query)) {
              while ($values_id = tep_db_fetch_array($values_id_query)) {

                $values_query = tep_db_query("select catalog_products_id, catalog_products_quantity from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = " . $values_id['products_options_values_id']);
                if (tep_db_num_rows($values_query)) {
                  while ($values = tep_db_fetch_array($values_query)) {
                    if (($restock == 1) && ($builds['products_quantity'] > 0)) {

                      $products_query = tep_db_query("select products_quantity, products_status from " . TABLE_PRODUCTS . " where products_id = " . $values['catalog_products_id']);
                      if (tep_db_num_rows($products_query)) {
                        $products = tep_db_fetch_array($products_query);
                        $products_new_quantity = $products['products_quantity'] + $values['catalog_products_quantity'];
                        $products_new_status = $products['products_status'];
                        if ($renable == 1) {
                          if (($products['products_status'] == '0') && ($products_new_quantity > 0)) {
                            $products_new_status = '1';
                          }
                        }
                        tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = " . tep_db_input($products_new_quantity) . ", products_status = '" . tep_db_input($products_new_status) . "' where products_id = " . $values['catalog_products_id']);
                      }

                    }
                  }
                  tep_db_query("delete FROM " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = " . $attributes['options_id']);
                  tep_db_query("delete FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = " . $values_id['products_options_values_id']);
                }

              }
              tep_db_query("delete FROM " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = " . $attributes['options_id']);
            }
          }
          tep_db_query("delete FROM " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = " . $builds['products_id']);
        }
        if (tep_db_query("delete FROM " . TABLE_PRODUCTS . " where  builder_product_flag = '1' and products_date_added < DATE_SUB(now(), INTERVAL " . $timeout . " HOUR)")) {
          tep_db_query("delete FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = " . $builds['products_id']);
          tep_db_query("delete FROM " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = " . $builds['products_id']);
        }
      }
    }
  }


?>

