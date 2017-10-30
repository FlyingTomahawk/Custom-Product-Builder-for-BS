<?php
/*
  $Id: builder.php,v 1.1.0 2008/10/01 01:28:23 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_BUILDER,
    'apps' => array(
      array(
        'code' => 'builder_categories.php',
        'title' => BOX_BUILDER_CATEGORIES,
        'link' => tep_href_link('builder_categories.php')
      ),
      array(
        'code' =>  'builder_dependences.php',
        'title' => BOX_BUILDER_DEPENDENCES,
        'link' => tep_href_link( 'builder_dependences.php')
      ),
      array(
        'code' => 'builder_options.php',
        'title' => BOX_BUILDER_OPTIONS,
        'link' => tep_href_link('builder_options.php')
      )
    )
  );
?>