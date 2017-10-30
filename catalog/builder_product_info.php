<?php
/*
  $Id: builder_product_info.php v 1.1.0 2008/12/05 11:27:54 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require('includes/languages' . '/' . $language . '/' . 'builder_product_info.php');

// check if tables exist
if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE '" . TABLE_BUILDER_OPTIONS . "'"))==1) {
// get builder options
  $cbcomp_query = tep_db_query("select cpb_build_product_status_default, cpb_build_disable_after_carted, cpb_build_preview_single, cpb_use_software, cpb_build_unsort_components from " . TABLE_BUILDER_OPTIONS);
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $cpb_use_software = $cbcomp['cpb_use_software'];
    $cpb_build_unsort_components= $cbcomp['cpb_build_unsort_components'];
    $cpb_build_disable_after_carted= $cbcomp['cpb_build_disable_after_carted'];
    $cpb_build_product_status_default= $cbcomp['cpb_build_product_status_default'];
  }
// check builder enabled
  if (!$cpb_use_software) {
    tep_redirect(tep_href_link('index.php', '', 'NONSSL'));
  }
}

// if non-builder product then redirect to osC-product_info
  $product_check_query = tep_db_query("select p.builder_product_flag, count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' group by p.products_id");
  $product_check = tep_db_fetch_array($product_check_query);
  if ($product_check['builder_product_flag'] == '0') {
    tep_redirect(tep_href_link('product_info.php?products_id=' . $_GET['products_id']));
  }
?>

<?
  require('includes/template_top.php');
?>

<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

<?php echo tep_draw_form('cart_quantity', tep_href_link('shopping_cart.php?action=add_build')); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ($product_check['total'] < 1) {
?>
      <tr>
        <td><?php new infoBox(array(array('text' => TEXT_PRODUCT_NOT_FOUND))); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link('index.php') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
    } else {
      $products_name = $product_info['products_name'];
    }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" valign="top"><?php echo $products_name; ?></td>
            <td class="pageHeading" align="right" valign="top">
<?php
if ((int)$product_info['products_price'] > 0) {
        echo $products_price;
} else {
        $products_options_name_query = tep_db_query("select distinct sum(options_values_price) from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' group by products_id");
        $products_options_name = tep_db_fetch_array($products_options_name_query);
        echo $currencies->display_price($products_options_name['sum(options_values_price)'],  tep_get_tax_rate($product_info['products_tax_class_id']));
}
?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main">
<?php
    if (tep_not_null($product_info['products_image'])) {
?>
          <table border="0" cellspacing="0" cellpadding="2" align="right">
            <tr>
              <td align="center" class="smallText">
<script language="javascript"><!--
document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link('popup_image.php?pID=' . $product_info['products_id']) . '\\\')">' . tep_image('images/' . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
//--></script>
<noscript>
<?php echo '<a href="' . tep_href_link('images/' . $product_info['products_image']) . '" target="_blank">' . tep_image('images/' . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
</noscript>
              </td>
            </tr>
          </table>
<?php
    }
?>
          <p><?php echo stripslashes($product_info['products_description']); ?></p>
<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>
          <table border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main" colspan="2"><?php echo TEXT_PRODUCT_OPTIONS; ?></td>
            </tr>
<?php
      if ($cpb_build_unsort_components) {
        $products_options_name_query = tep_db_query("select distinct patrib.options_values_price, popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' group by popt.products_options_id");
      } else {
        $products_options_name_query = tep_db_query("select distinct sum(patrib.options_values_price), popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' group by popt.products_options_name");
      }
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();
          $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.catalog_products_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");

        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $component_name = $products_options['products_options_values_name'];
          $component_id = $products_options['products_options_values_id'];
          $componentcat_id = $products_options['catalog_products_id'];

        }
        echo tep_draw_hidden_field('id[' . $products_options_name['products_options_id'] . ']', $component_id);
?>
            <tr>
              <td class="main" align="right"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
              <td class="main"><a href="<?php echo tep_href_link('builder_component_info.php?', 'products_id=' . $componentcat_id, 'NONSSL', true, false); ?>" onclick="javascript:window.open(this.href,'','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=600,screenX=150,screenY=150,top=150,left=150');return(false);"><?php echo $component_name; ?></a></td>
            </tr>
<?php
      }
?>
          </table>
<?php
    }
?>
        </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($product_info['products_date_added'])); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
if ($product_info['products_quantity'] > 0) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td class="main" align="right"><?php echo tep_draw_hidden_field('uncloaked_build', $cpb_build_product_status_default) . tep_draw_hidden_field('disable_build', $cpb_build_disable_after_carted) . tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td>
<?php
  }
?>
        </td>
      </tr>
    </table></form>

<?php
  require('includes/template_bottom.php');
  require('includes/application_bottom.php');
?>