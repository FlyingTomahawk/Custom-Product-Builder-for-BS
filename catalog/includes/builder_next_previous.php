<?php
/*
  $Id: builder_next_previous.php, v 1.1.0 2008/12/04 10c $

  adapted from products_next_previous contribution:
  by: Linda McGrath osCommerce@WebMakers.com,
  Nirvana, Yoja, Joachim de Boer, Wheeloftime,
  dAbserver, Skylla
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

			    if (isset($_GET['manufacturers_id'])) { 
                $products_ids = tep_db_query("select p.products_id from products p where p.products_status = '1'  and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
				$category_name_query = tep_db_query("select manufacturers_name from manufacturers where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_MB . '&nbsp;' . ($category_name_row['manufacturers_name']);
				$fPath = 'manufacturers_id=' . (int)$_GET['manufacturers_id'];
                } else {
				if (!$current_category_id) {
					$cPath_query = tep_db_query ("SELECT categories_id FROM products_to_categories WHERE products_id ='" .  (int)$_GET['products_id'] . "'");
					$cPath_row = tep_db_fetch_array($cPath_query);
					$current_category_id = $cPath_row['categories_id'];
				}
				$products_ids = tep_db_query("select p.products_id from products p, products_to_categories ptc where p.products_status = '1'  and p.products_id = ptc.products_id and ptc.categories_id = $current_category_id");
				$category_name_query = tep_db_query("select categories_name from categories_description where categories_id = $current_category_id AND language_id = $languages_id");
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_CAT . '&nbsp;' . ($category_name_row['categories_name']);
				$fPath = 'cPath=' . $cPath;
				}
				while ($product_row = tep_db_fetch_array($products_ids)) {
					$id_array[] = $product_row['products_id'];
				}
				// calculate the previous and next
         		reset ($id_array);
				$counter = 0;
				while (list($key, $value) = each ($id_array)) {
					if ($value == (int)$_GET['products_id']) {
						$position = $counter;
						if ($key == 0)
							$previous = -1; // it was the first to be found
						else
							$previous = $id_array[$key - 1];

						if ($id_array[$key + 1])
							$next_item = $id_array[$key + 1];
						else {
							$next_item = $id_array[0];
						}
					}
					$last = $value;
					$counter++;
				}
				if ($previous == -1)
					$previous = $last;
?>

  <td>  
    <table border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
	    <td width="120" align="right" class="main"><? if (($counter != 1) && ($position != 0)) { echo ('<a href="' . tep_href_link('builder_component_info.php', "$fPath&products_id=$previous") . '">' .  tep_image('images/chevron_previous.gif', PREV_NEXT_ALT_PREVIOUS) . '</a>&nbsp;'); } ?>
		</td>
        <td align="center" class="main" valign="top"><?php echo (PREV_NEXT_PRODUCT) . '&nbsp;' . ($position+1 . '&nbsp;' . PREV_NEXT_OF . '&nbsp;' . $counter) . '&nbsp;' . $prev_next_in; ?></td>
		<td width="120" align="left" class="main"><? if (($counter !=1) && (($position+1) != $counter)) { echo ('&nbsp;<a href="' . tep_href_link('builder_component_info.php', "$fPath&products_id=$next_item") . '">' . tep_image('images/chevron_next.gif', PREV_NEXT_ALT_NEXT) . '</a>'); } ?></td>
      </tr>
  </table>	
  </td>
