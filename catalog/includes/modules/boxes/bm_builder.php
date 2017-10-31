<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_builder {
    var $code = 'bm_builder';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_builder() {
      $this->title = MODULE_BOXES_BUILDER_TITLE;
      $this->description = MODULE_BOXES_BUILDER_DESCRIPTION;

      if ( defined('MODULE_BOXES_BUILDER_STATUS') ) {
        $this->sort_order = MODULE_BOXES_BUILDER_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_BUILDER_STATUS == 'True');

        $this->group = ((MODULE_BOXES_BUILDER_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
        global $PHP_SELF, $request_type, $oscTemplate;

        if (substr(basename($PHP_SELF), 0, 12) != 'builder_main') {
            
            if(tep_db_num_rows(tep_db_query("SHOW TABLES LIKE 'builder_options'"))==1) {
                $builder_query_raw="select cpb_auto_disable_time, cpb_auto_delete_time, cpb_reduce_stock, cpb_build_allow_disable_product, cpb_use_software, cpb_build_name, cpb_product_builder_name, cpb_product_builder_image FROM builder_options";
                $builder_query = tep_db_query($builder_query_raw);
                $builder = tep_db_fetch_array($builder_query);

                // PUT BEFORE AUTOCLEARS INCASE YOU WANT TO RETAIN BUILDS BY SWITCHING THE BUILDER OFF - YOU NEVER KNOW!
                if (tep_db_num_rows($builder_query) > 0 && $builder['cpb_use_software'] > 0) {

                    // AUTO (TIMED) DISABLE AND DELETE ACTIONS - still call them even if builder disabled (good for housekeeping)
                    $cpb_auto_disable_time= $builder['cpb_auto_disable_time'];
                    $cpb_auto_delete_time= $builder['cpb_auto_delete_time'];
                    $cpb_reduce_stock= $builder['cpb_reduce_stock'];
                    $cpb_build_allow_disable_product= $builder['cpb_build_allow_disable_product'];
                    require('includes/functions/' . 'builder.php');

                    // first deletes then disables - saves exta sqls if build has expired both periods
                    if ($cpb_auto_delete_time >= 1) {
                      _delete_builds($cpb_auto_delete_time, $cpb_reduce_stock, $cpb_build_allow_disable_product);
                    }
                    if ($cpb_auto_disable_time >= 1) {
                      _disable_builds($cpb_auto_disable_time);
                    }

                    $data = '<div class="ui-widget infoBoxContainer">' .
                            '  <div class="ui-widget-header infoBoxHeading"><a href="' . tep_href_link('builder_main.php') . '">' . MODULE_BOXES_BUILDER_BOX_TITLE . '</a></div>' .
                            '  <div class="ui-widget-content infoBoxContents">' .
                            /*'    ' . tep_draw_form('builder', tep_href_link('builder_main.php', '', $request_type, false), 'get') . */
                            '    <a href="' . tep_href_link('builder_main.php') . '">' . tep_image('images/' . $builder['cpb_product_builder_image'] , $builder[cpb_product_builder_name], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . $builder['cpb_product_builder_name'] . '</a>' .
                            '  </div>' .
                            '</div>';

                    $oscTemplate->addBlock($data, $this->group);
                }
            }
        }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_BUILDER_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'MODULE_BOXES_BUILDER_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_BUILDER_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_BUILDER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_BUILDER_STATUS', 'MODULE_BOXES_BUILDER_CONTENT_PLACEMENT', 'MODULE_BOXES_BUILDER_SORT_ORDER');
    }
  }
?>
