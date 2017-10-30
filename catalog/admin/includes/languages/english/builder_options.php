<?php
/*
  $Id: builder_options.php,v 1.1.0 2008/10/06 01:48:08 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE',"Options");

define('TEXT_NO_TABLES',"Database Tables not found!! - Click the 'Update' button to Create the DB Tables");
define('TEXT_BUILDER_OPTIONS',"&nbsp;&nbsp;Builder Settings");
define('TEXT_ASSEMBLY_FEE_OPTIONS',"&nbsp;&nbsp;Builder Categories (List of Component Categories)");
define('TEXT_BUILDER_MODE_OPTIONS',"&nbsp;&nbsp;Building Process Controls </b>(NB:Components are normal Osc Products)");
define('TEXT_AFTER_BUILD_OPTIONS',"&nbsp;&nbsp;After-Build Options (Housekeeping - Singles Only)");
define('TEXT_SINGLE_BUILD_OPTIONS',"&nbsp;&nbsp;New Product Details (Singles Mode Only)");
define('TEXT_COMPONENT_OPTIONS',"&nbsp;&nbsp;Builder Component List (Selected/Unselected Components)");
define('TEXT_POPUP_OPTIONS',"&nbsp;&nbsp;Popup Components List (Available Component Choices)");
define('TEXT_DEPENDENCE_OPTIONS',"&nbsp;&nbsp;Dependency (Limiting Component Choices)");

define('TEXT_BUILDER_UPDATE',"&nbsp;&nbsp;Save All Changes");

define('YES',"Yes");
define('NO',"No");
// TEXT LABELS FOR OPTIONS
define('TEXT_USE_DEPENDENCE',"<b>Enable Dependency</b>");
define('TEXT_USE_SOFTWARE',"<b>Enable Builder</b>");
define('TEXT_USE_ASSEMBLY',"<b>Use Assembly Fee</b>");
define('TEXT_ASSEMBLY_ID',"osC Category for Assembly Fees");
define('TEXT_BUILD_OSCCAT',"osC Category for Built Products");
define('TEXT_BUILD_NAME',"<b>Name</b>");
define('TEXT_BUILD_DESCRIPTION',"<b>Description</b>");
define('TEXT_BUILD_IMAGE',"Default Image filename");
define('TEXT_BUILD_URL',"URL, http://");
define('TEXT_BUILD_MODEL',"Model");
define('TEXT_REDUCE_STOCK',"<b>Allow builder to Adjust component Stock</b>");
define('TEXT_BUILD_ONE_PRODUCT',"<b>Assemble Components as a Single Product</b> (No=Bundled)");
define('TEXT_POPUP_HEIGHT',"<b>Window Height</b>");
define('TEXT_POPUP_OFFSET_LEFT',"Left offset (+ or -)");
define('TEXT_POPUP_OFFSET_TOP',"Top offset (+ or -)");
define('TEXT_SHOW_NOSTOCK',"<b>Allow 'no-stock' Products</b>");
define('TEXT_SHOW_DISABLED',"<b>Allow 'disabled' Products</b>");
define('TEXT_IGNORE_SPECIALS',"Ignore osC Specials Pricing for components");
define('TEXT_BUILD_ALLOW_NAME',"<b>Allow visitor to change Name</b>");
define('TEXT_BUILD_ALLOW_DESCRIPTION',"<b>Allow visitor to change Description</b>");
define('TEXT_BUILD_ALLOW_IMAGE',"<b>Allow visitor to change Image</b>");
define('TEXT_BUILD_MODEL_SUFFIX',"Append osC product-id to Model");
define('TEXT_AUTO_DELETE_TIME',"Delete All builds after ## hours (0=Disable)");
define('TEXT_BUILD_ALLOW_NOSTOCK',"<b>Continue building if a component runs out of stock</b>");
define('TEXT_BUILD_ALLOW_DISABLED',"<b>Continue building if a component is disabled</b>");
define('TEXT_BUILD_ALLOW_DISABLE_PRODUCT',"Stock Adjustments: <b>Allow builder to Alter component Status</b>");
define('TEXT_PRODUCT_BUILDER_NAME',"Custom Products Builder Title");
define('TEXT_PRODUCT_BUILDER_IMAGE',"Builder Infobox (frontend) Image filename");
define('TEXT_PRODUCT_BUILDER_IMAGE_TAG',"Page Tag Image filename");
define('TEXT_POPUP_SHOW_PRODUCT_IMAGE',"<b>Display component Image</b>");
define('TEXT_BUILD_SHOW_PRODUCT_IMAGE',"<b>Display component Image</b>");
define('TEXT_BUILD_SHOW_PRODUCT_QUANTITY',"<b>Allow visitor to change Component Quantity</b>");
define('TEXT_BUILD_SHOW_BUILT_BY',"<b>Display Built By name</b>");
define('TEXT_BUILD_PRODUCT_IMAGE_HEIGHT',"Component image Height");
define('TEXT_BUILD_PRODUCT_IMAGE_WIDTH',"Component image Width");
define('TEXT_POPUP_PRODUCT_IMAGE_HEIGHT',"Component image Height");
define('TEXT_POPUP_PRODUCT_IMAGE_WIDTH',"Component image Width");
define('TEXT_PRODUCT_IMAGES_FOLDER',"Product images Location");
define('TEXT_CATEGORY_IMAGES_FOLDER',"Category images Location");
define('TEXT_CATALOG_IMAGES_FOLDER',"osC Catalog images location");
define('TEXT_BUILD_PRODUCT_PRICE_FIX',"Fixed Build Price (No=Use Component Prices)");
define('TEXT_BUILD_ASSEMBLY_IMAGE',"Assembly category Image");
define('TEXT_MATRIX_EDIT_DEFAULT_LINES_PER_PAGE',"Dependences editor: Default lines-per-page");
define('TEXT_MATRIX_EDIT_SHOW_NOSTOCK',"Dependences editor: Display 'no-stock' Products");
define('TEXT_MATRIX_EDIT_SHOW_DISABLED',"Dependences editor: Display 'disabled' Products");
define('TEXT_BUILD_SHORT_DESCRIPTION_LENGTH',"Short description Length");
define('TEXT_BUILD_SHOW_SHORT_DESCRIPTION',"<b>Display Short description</b>");
define('TEXT_POPUP_SHORT_DESCRIPTION_LENGTH',"Short description Length");
define('TEXT_POPUP_SHOW_SHORT_DESCRIPTION',"<b>Display Short description</b>");
define('TEXT_BUILD_AUTO_CLEAR_LIST',"Priority Building: <b>Auto Clear-List below selected component</b>");
define('TEXT_BUILD_AUTO_CLEAR_COUNT',"Apply 'Clear-List' to first ## components (0=All)");
define('TEXT_BUILD_SHOW_URL',"Display URL");
define('TEXT_BUILD_URL_SUFFIX',"Append osC product-id to URL");
define('TEXT_BUILD_PRIORITY',"<b>Enforce 'top-to-bottom' Priority Building</b>");
define('TEXT_BUILD_PRIORITY_COUNT',"Apply Priority on first ## components (0=All)");
define('TEXT_BUILD_MINIMUM_ORDER',"<b>Enforce Minimum Components for build</b>");
define('TEXT_BUILD_MINIMUM_ORDER_COUNT',"Apply 'Minimum Components' to first ## components (0=All)");
define('TEXT_BUILD_PRICE_IN_DESCRIPTION',"Fixed Pricing: Show prices in component descriptions");
define('TEXT_BUILD_IN_REVERSE',"Reverse <i>Build Sequence</i>");
define('TEXT_BUILD_ALLOW_BUILT_BY',"<b>Allow visitor to change Built By name</b>");
define('TEXT_BUILD_PREVIEW_SINGLE',"Singles Mode: <b>Preview build before going to Cart</b>");
define('TEXT_BUILD_COMPONENT_QTY_MAX',"Maximum quantity Per Component");
define('TEXT_BUILD_PRODUCT_STATUS_DEFAULT',"Singles Mode: <b>Hide built products</b>");
define('TEXT_BUILD_PRODUCT_STOCK_DEFAULT',"Default Stock Quantity");
define('TEXT_BUILD_ASSEMBLY_FEE_NAME',"Assembly category Name");
define('TEXT_BUILD_PRODUCT_DETAILS_ONTOP',"<b>Display new product details Above component list</b> (No=below)");
define('TEXT_BUILD_UNSORT_COMPONENTS',"Force components List into <i>Build Sequence</i>");
define('TEXT_POPUP_SORT_BY_PRICE',"Sort components by Price");
define('TEXT_BUILD_BUILT_BY_DEFAULT',"Built By name default, for unlogged visitor");
define('TEXT_BUILD_DISABLE_AFTER_CARTED',"Unhidden Single Build: <b>Disable build after going to Cart</b>");
define('TEXT_AUTO_DISABLE_TIME',"Disable Unclaimed builds after ## hours (0=Disable)");
define('TEXT_BUILD_MANUFACTURER_ID_DEFAULT',"Manufacturer");
define('TEXT_BUILD_NAME_SUFFIX',"Append osC product-id to Name");
define('TEXT_BUILD_CART_RESET',"Bundled Mode: <b>Clear cart Before Carting</b>");
define('TEXT_BUILD_ID_IN_DESCRIPTION',"Include osC product-id in component Descriptions");
define('TEXT_BUILD_SHOW_CATEGORY_IMAGE',"<b>Display category Images instead of Text Labels</b>");
define('TEXT_BUILD_CATEGORY_IMAGE_HEIGHT',"Category image Height");
define('TEXT_BUILD_CATEGORY_IMAGE_WIDTH',"Category image Width");
define('TEXT_BUILD_PRODUCT_TAX_CLASS_DEFAULT',"Default Tax Class");
define('TEXT_IGNORE_TAX',"Ignore Component TAX in Totals calculations");
define('TEXT_BUILD_SHOW_TAX',"Display component prices Including Tax");
define('TEXT_BUILD_ALLOW_IMAGE_UPLOAD',"<b>Allow visitor to Upload Image</b>");
define('TEXT_BUILD_IMAGE_UPLOAD_SIZE',"Maximum Upload Size (bytes)");
define('TEXT_BUILD_IMAGE_UPLOAD_FOLDER',"Uploaded images Location");
?>
