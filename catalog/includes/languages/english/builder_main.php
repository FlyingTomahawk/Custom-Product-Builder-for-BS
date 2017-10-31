<?php
/*
  $Id: builder_main.php, v 1.1.0 2008/12/05 01:48:08 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
define('NAVBAR_TITLE', 'Product Builder');
define('HEADING_TITLE', 'Product Builder');
define('HEADING_PICTURE_TITLE', 'Product Builder');
define('TEXT_TITLE_SINGLE', 'Assemble your product using the component options below. The recommended approach is to start with the first component and then work your way down the list. This product builder uses hierarchical dependency to limit each of the subsequent component options.<br><br>If you decide to change a component in a partially or completed list then subsequent components must be checked again unless the store manager has enabled the auto-clear function which will force you to reselect those components again.<br><br>The builder will create a new product in this online catalog. It will be created with the default name, description, image, etc.. as shown below - and if the store manager has enabled it you can change them to whatever you like.');
define('TEXT_TITLE_MULTIPLE', 'Assemble your order using the component options below. The recommended approach is to start with the first component and then work your way down the list. This product builder uses hierarchical dependency to limit each of the subsequent component options.<br><br>If you decide to change a component in a partially or completed list then subsequent components must be checked again unless the store manager has enabled the auto-clear function which will force you to reselect those components again.');
define('TEXT_TITLE_WARNING', '<i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> Please note that your input and selections will be lost if you refresh this page');
define('TEXT_LOADING_PLEASE_WAIT', '... loading Please wait ...');
define('TEXT_PART_NAME', 'Components selection');
define('TEXT_BUILD_FAILED', 'BUILD FAILED!!');
define('TEXT_BUILD_FAILED_NOSTOCK', 'ERROR: stock shortage on one or more of the components you selected');
define('TEXT_BUILD_FAILED_DISABLED', 'ERROR: component was disabled during build, most likely due to an external influence');
define('TEXT_BUILD_FAILED_BOTH', 'ERROR: component was disabled during build, possibly due to insufficient stock for a duplicated component');
define('TEXT_BUILD_FAILED_UPLOAD', 'ERROR: image upload error - maximum allowable file size is %s Kbytes, and must be of type JPG, GIF or PNG');
define('TEXT_BUILD_COMPONENT_ERROR', '&nbsp;&nbsp;* ERROR *');
define('TEXT_PART_TYPE', 'Component type');
define('TEXT_PART_PRICE', 'Price each');
define('TEXT_PART_QUANTITY', 'Qty');
define('TEXT_BUILD_DETAILS', 'New Product Details');
define('TEXT_PRIORITY_ERROR', ' - selections above first');
define('TEXT_COMPONENT_NOT_SELECTED', '(click here)');
define('TEXT_TOTAL_PRICE', 'Total Price');
define('TEXT_PRINT_PREVIEW', 'Print Preview');
define('TEXT_FORM_RESET', 'Form Reset');
define('TEXT_MAKE_ORDER', 'Add to Cart');
define('TEXT_BUILD_ORDER', 'Build Product');
define('TEXT_DESELECT_ITEM', 'Deselect current item');
define('TEXT_SELECT_SUBCATEGORY', ' options');
define('TEXT_SELECT_ITEM', ' - click to select');
define('TEXT_NO_ITEMS', 'No items available');
define('TEXT_NO_ITEMS_WARNING', 'Please add some components first');
define('TEXT_MINIMUM_ITEMS_WARNING', 'Please select more components');
define('ASSEMBLY','Assembly');
define('TEXT_URL_SUFFIX','?products_id=');
define('TEXT_ADDRESS', 'SUPPLIER');
define('TEXT_EMAIL', 'EMAIL');
define('HEADING_BUILD_NAME','Build Name:');
define('HEADING_BUILD_MODEL','Model:');
define('TEXT_BUILD_MODEL_NOTE','- <font color="#888888" size="1"><i>product id will be appended</i></font>');
define('TEXT_BUILD_URL_NOTE','- <font color="#888888" size="1"><i>product id will be appended</i></font>');
define('TEXT_BUILD_NAME_NOTE','- <font color="#888888" size="1"><i>product id will be appended</i></font>');
define('HEADING_BUILD_BUILT_BY','Built by:');
define('HEADING_BUILD_URL','Webpage URL:');
define('HEADING_UPLOAD_IMAGE','.... or upload a new image:');
define('HEADING_BUILD_IMAGE','Image:');
define('HEADING_BUILD_IMAGE_DESCRIPTION','Product Image');
define('HEADING_BUILD_DESCRIPTION','Description:');
?>
