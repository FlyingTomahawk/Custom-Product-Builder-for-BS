<?php
/*
  $Id: builder_product_list.php, v 1.1.0 2008/12/06 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');

require('includes/languages' . '/' . $language . '/' . 'builder_product_list.php');

// GET CURRENCY STUFF
$currency_symb_query = tep_db_query("select symbol_left, symbol_right, decimal_point, thousands_point, decimal_places from currencies where code='".$currency."'");
$currency_symb = tep_db_fetch_array($currency_symb_query);

// GET BUILDER OPTIONS AND CATEGORIES ------------------------------------------
if (tep_db_num_rows(tep_db_query("SHOW TABLES LIKE 'builder_options'"))==1) {

// get builder options
  $cbcomp_query = tep_db_query("select * from builder_options");
  while ($cbcomp = tep_db_fetch_array($cbcomp_query)){
    $cpb_system_assembly= $cbcomp['cpb_system_assembly'];
    $cpb_assembly_osccat= $cbcomp['cpb_assembly_osccat'];
    $cpb_build_osccat= $cbcomp['cpb_build_osccat'];
    $cpb_use_dependence= $cbcomp['cpb_use_dependence'];
    $cpb_use_software= $cbcomp['cpb_use_software'];
    $cpb_show_nostock= $cbcomp['cpb_show_nostock'];
    $cpb_show_disabled= $cbcomp['cpb_show_disabled'];
    $cpb_ignore_specials= $cbcomp['cpb_ignore_specials'];
    $cpb_popup_show_product_image= $cbcomp['cpb_popup_show_product_image'];
    $cpb_product_builder_image= $cbcomp['cpb_product_builder_image'];
    $cpb_product_builder_name= $cbcomp['cpb_product_builder_name'];
    $cpb_popup_product_image_width= $cbcomp['cpb_popup_product_image_width'];
    $cpb_popup_product_image_height= $cbcomp['cpb_popup_product_image_height'];
    $cpb_popup_show_short_description= $cbcomp['cpb_popup_show_short_description'];
    $cpb_popup_short_description_length= $cbcomp['cpb_popup_short_description_length'];
    $cpb_build_show_short_description= $cbcomp['cpb_build_show_short_description'];
    $cpb_build_short_description_length= $cbcomp['cpb_build_short_description_length'];
    $cpb_popup_sort_by_price= $cbcomp['cpb_popup_sort_by_price'];
    $cpb_build_show_tax= $cbcomp['cpb_build_show_tax'];
    $cpb_category_images_folder= $cbcomp['cpb_category_images_folder'];
  }

// JUST CHECK IF THIS BUILDER IS ALLOWED
  if (!$cpb_use_software) {
    tep_redirect(tep_href_link('index.php', '', 'NONSSL'));
  }

// SET PRODUCT FILTER FOR NOSTOCKS AND DISABLEDS
$filter_nostock = "p.products_quantity > 0 and";
if ($cpb_show_nostock) {
  $filter_nostock="";
}
$filter_disabled = "p.products_status = '1' and";
if ($cpb_show_disabled) {
  $filter_disabled = "";
}
$filter_product = $filter_nostock . ' ' . $filter_disabled;

// SET POPUP LIST SORT ORDER
if ($cpb_popup_sort_by_price) {
  $sort_product = " order by p.products_price";
} else {
  $sort_product = "";
}

// get builder categories - insert them into a perfect sequential array (i.e. 1,2,3,4,etc..)
  $pcount=0;
  $bcomp_query = tep_db_query("select * from builder_categories ORDER BY cpb_category_id");
  while ($bcomp = tep_db_fetch_array($bcomp_query)){
    $pcshadowid[$pcount] = $bcomp['cpb_category_id'];
    $pcid[$pcount]= $pcount+1;
    $pccat[$pcount]= $bcomp['cpb_category_name'];
    $pcdcat[$pcount]= $bcomp['cpb_depends_category_id'];
    $pcimg[$pcount]= $bcomp['cpb_category_image'];
    $osccat[$pcount]= $bcomp['osc_category_id'];
    $pcount++;
  }

// arrange the dependency ids to match the new (phantom) category ids
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
  echo "<table bgcolor=\"red\"><tr><td><font color=\"yellow\"><B>Tables may not exist, or Database Error</B></font></td></tr></table>";
  exit();
}

// GET CATEGORY DESCRIPTIONS ----------------------------------
$category_query = tep_db_query("select categories_id, categories_name from categories_description where language_id='".$languages_id."'");
while ($categories=tep_db_fetch_array($category_query)){
  $category_names[$categories['categories_id']]=$categories['categories_name'];
}
$output = $pcount;
for ($ib = 0; $ib < $output; $ib++) {
  $cat = $osccat[$ib]; //
  if ($_GET['row'] == $ib) $temp = $cat;
}
$acount=0;

// CHECK IF WE MUST USE DEPENDENCIES (selected in admin)
if ($cpb_use_dependence==1){
// the very next two sql's address the same database - can these not be done in one sweep
  if ($pcid[$_GET['row']] != $pcdcat[$_GET['row']] && $pcdcat[$_GET['row']] != 0) {
    $strDependences ="(";
    $d_query = tep_db_query("select product2_id from builder_dependences where product1_id='".$_GET['idp'.$pcdcat[$_GET['row']]]."'");
    while ($depends=tep_db_fetch_array($d_query)) {
      $strDependences .=", ".$depends['product2_id'];
    }
    $d_query = tep_db_query("select product1_id from builder_dependences where product2_id='".$_GET['idp'.$pcdcat[$_GET['row']]]."'");
    while ($depends=tep_db_fetch_array($d_query)) {
      $strDependences .=", ".$depends['product1_id'];
    }
    $strDependences .= ")";
    $strDependences = substr_replace($strDependences,'',1,1);
    if ($strDependences != "(") {
      $strQueryProducts= "select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$temp."' and pc.products_id in ". $strDependences . $sort_product;
    } else {
      $strQueryProducts= "select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$temp."' " . $sort_product;
    }
  } else {
    $strQueryProducts= "select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$temp."' " . $sort_product;
  }
} else {
  $strQueryProducts= "select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$temp."' " . $sort_product;
}
$a_query = tep_db_query("select categories_id from categories where parent_id='".$temp."'");
while ($acat=tep_db_fetch_array($a_query)){
  $acategory[$temp][$acount]=$acat['categories_id'];
  $acount++;
}
$count1=1;
$count2=0;

// SHOW AVAILABLE PRODUCTS IN POPUP ----------------------------------------------
// POPUP BOX HEADER ---
$textshow[$temp].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
$textshow[$temp].="print_title('".$category_names[$temp] . TEXT_SELECT_ITEM ."'); \n";

// PRODUCTS WITHOUT SUB CATEGORIES -----------------------------------------------------------
$c_query = tep_db_query($strQueryProducts);
while ($count = tep_db_fetch_array($c_query)) {
  $a_query = tep_db_query("select pd.products_name, pd.products_description from products_description pd, products p where " . $filter_product . " p.products_id = pd.products_id and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
  while ($aount = tep_db_fetch_array($a_query)) {
    $product ['name'] = addslashes($aount['products_name']);
// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $cpb_popup_short_description_length) {
        $product ['description'] = substr($temp_description,0,$cpb_popup_short_description_length) . "...";
      } else {
        $product ['description'] = $temp_description;
      }
      if (strlen($temp_description) >= $cpb_build_short_description_length) {
        $product ['description2']   = substr($temp_description,0,$cpb_build_short_description_length) . "...";
      } else {
        $product ['description2'] = $temp_description;
      }
    $product ['id']= $count['products_id'];
    if ((DISPLAY_PRICE_WITH_TAX) && ($cpb_build_show_tax)) {
      $b_query = tep_db_query("select products_price, products_image, products_tax_class_id from products p where " . $filter_product . " products_id='".$count['products_id']."'");
    } else {
      $b_query = tep_db_query("select products_price, products_image from products p where " . $filter_product . " products_id='".$count['products_id']."'");
    }
    $temps=tep_db_fetch_array($b_query);

// CHECK FOR SPECIALS
        $special_price = tep_get_products_special_price($count['products_id']);
        if ($special_price && !$cpb_ignore_specials) {
          $temp_price = $special_price;
        } else {
          $temp_price = $temps['products_price'];
        }

    $product ['price'] = '&nbsp;'. $currencies->display_price($temp_price,tep_get_tax_rate($temps['products_tax_class_id']));
    $product ['image'] = $temps['products_image'];
    if (!$product ['image']) {
      $product ['image'] = 'no_product_image.gif';
    }
    $ccount++;
  }
  $textshow[$temp].= "print_line('".$count2."','".$product ['image']."','".$product ['name']."','".$product ['description']."','".$product ['description2']."','".$product ['price']."','".$product ['id']."','".$_GET['row']."'); \n";
  $count2++;
}

// PRODUCTS WITH SUBCATEGORIES -------------------------------------------------------------------------------------------------
for ($f = 0, $z = $acount; $f < $z; $f++) {
  $textshow[$temp].="print_title('".$category_names[$acategory[$temp][$f]]. TEXT_SELECT_SUBCATEGORY . "'); \n";
  $count2++;
  if ($cpb_use_dependence==1 && ($pcid[$_GET['row']] != $pcdcat[$_GET['row']]) && ($pcdcat[$_GET['row']] != 0)) {
    if ($strDependences != "(") {
	$c_query = tep_db_query($strQueryProducts2="select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$acategory[$temp][$f]."' and pc.products_id in ". $strDependences . $sort_product);
    } else {
	$c_query = tep_db_query($strQueryProducts2="select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$acategory[$temp][$f]."' " . $sort_product);
    }
  } else {
    $c_query = tep_db_query($strQueryProducts2="select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='".$acategory[$temp][$f]."' " . $sort_product);
  }
  while ($count = tep_db_fetch_array($c_query)) {
    $a_query = tep_db_query("select pd.products_name, pd.products_description from products_description pd, products p where " . $filter_product . " p.products_id = pd.products_id and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
    while ($aount = tep_db_fetch_array($a_query)) {
      $product ['name'] = addslashes($aount['products_name']);
// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $cpb_popup_short_description_length) {
        $product ['description'] = substr($temp_description,0,$cpb_popup_short_description_length) . "...";
      } else {
        $product ['description'] = $temp_description;
      }
      if (strlen($temp_description) >= $cpb_build_short_description_length) {
        $product ['description2']   = substr($temp_description,0,$cpb_build_short_description_length) . "...";
      } else {
        $product ['description2'] = $temp_description;
      }
      $product ['id']= $count['products_id'];
    if ((DISPLAY_PRICE_WITH_TAX) && ($cpb_build_show_tax)) {
        $b_query = tep_db_query("select products_price, products_image, products_tax_class_id from products p where " . $filter_product . " products_id='".$count['products_id']."'");
      } else {
        $b_query = tep_db_query("select products_price, products_image from products p where " . $filter_product . " products_id='".$count['products_id']."'");
      }
      $temps=tep_db_fetch_array($b_query);

// CHECK FOR SPECIALS
        $special_price = tep_get_products_special_price($count['products_id']);
        if ($special_price && !$cpb_ignore_specials) {
          $temp_price = $special_price;
        } else {
          $temp_price = $temps['products_price'];
        }

      $product ['price'] = '&nbsp;'. $currencies->display_price($temp_price,tep_get_tax_rate($temps['products_tax_class_id']));
      $product ['image'] = $temps['products_image'];
      if (!$product ['image']) {
        $product ['image'] = 'no_product_image.gif';
      }
      $ccount++;
    }
    $textshow[$temp].= "print_line('".$count2."','".$product ['image']."','".$product ['name']."','".$product ['description']."','".$product ['description2']."','".$product ['price']."','".$product ['id']."','".$_GET['row']."'); \n";
    $count2++;
  }
}

// POPUP BOX FOOTER ---------------------------------------------------------
$count1++;
if ($count2==0) {
  $textshow[$temp].="print_title('".TEXT_NO_ITEMS."'); \n";
} else {
  $textshow[$temp].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
}

?>
<html><head>
<style>TD,TH,BODY{font-family:Arial,Tahoma,Helvetica,sans-serif;font-size:9pt;}TH{background-color:#86A5D2;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#0086A5D2',EndColorStr='#C0FFFFFF');font-style:italic;border:1px solid Black;cursor:default;}.select_table{BORDER-COLLAPSE:collapse;border:1px ridge;background-color:#F5F5F5;}tr{cursor:pointer;cursor:hand;}BODY{overflow: auto;margin: 0 0 0 0;background-color: #F5F5F5;}</style>
<script language="JavaScript">

function print_line(pnum,pimage,pdesc,pinfo,pinfo2,pprice,precid,row){
  var currency_left="<?php echo $currency_symb['symbol_left'];?>";
  var currency_right="<?php echo $currency_symb['symbol_right'];?>";
  var pdesc2 = pdesc.replace(/:inc:/gi, '"')
  re2 = new RegExp ('\'', 'gi') ;
  pdesc = pdesc.replace(re2, ":tag:");
  pinfo = pinfo.replace(re2, "");
  pinfo2 = pinfo2.replace(re2, "");
<?php
if ($cpb_build_show_short_description) {?>
  document.write ("<tr onclick=\"parent.document.mainform.elements['products_id["+row+"]'].value='"+precid+"';parent.add_product('"+pnum+"','"+pimage+"','"+pdesc+"','"+pinfo2+"','"+pprice+"','"+precid+"','"+row+"');\" onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\">");
<?php } else { ?>
  document.write ("<tr onclick=\"parent.document.mainform.elements['products_id["+row+"]'].value='"+precid+"';parent.add_product('"+pnum+"','"+pimage+"','"+pdesc+"','','"+pprice+"','"+precid+"','"+row+"');\" onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\">");
<?php
}
 if ($cpb_popup_show_product_image) {?>
  document.write ("<td align='left' width='20'>");
  document.write ('<?php echo tep_image('images/' . "'+pimage+'", $cpb_product_builder_name, $cpb_popup_product_image_width, $cpb_popup_product_image_height );?>');
  document.write ("</td>");
<?php } ?>
  document.write ("<td>"+pdesc2+"<br>");
<?php if ($cpb_popup_show_short_description) {?>
  document.write (pinfo);
<?php } ?>
  document.write ("</td><td align='right' width=80>&nbsp;"+pprice+"</td></tr>");
}

function print_title(title){
  document.write("<tr><th align='center' colspan='3'>"+title+"</th></tr>");
}
function print_deselect(title,pindex){
  document.write("<tr onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\" onclick=\"parent.add_product('','','','','','','"+pindex+"');parent.document.mainform.elements['products_id["+pindex+"]'].value='-1';\"><td align='center' colspan=3><b>"+title+"</b></td></tr>");
}
</script>
</head>

<?php
// ASSEMBLY FEES.... GETS ITS OWN PROCEDURE -------------------------------------------
?>
<body>
<table style="BORDER-COLLAPSE: collapse" borderColor="#86a5d2" border="1" width="100%">
<script language='JavaScript'>
<?php
if ($_GET['row']==$_GET['assemb_id']) {
  $textshow['assembly'].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['pindex']."');\n";
  $textshow['assembly'].="print_title('". ASSEMBLY . TEXT_SELECT_ITEM ."'); \n";
  $c_query = tep_db_query("select pc.products_id from products_to_categories pc, products p where " . $filter_product . " p.products_id = pc.products_id and pc.categories_id='" . (int)$cpb_assembly_osccat . "' " . $sort_product);
  $count2=0;
  while ($count = tep_db_fetch_array($c_query)) {
    $a_query = tep_db_query("select pd.products_name, pd.products_description from products_description pd, products p where " . $filter_product . " p.products_id = pd.products_id and (pd.products_id='".$count['products_id']."' AND pd.language_id='".$languages_id."')");
    while ($aount = tep_db_fetch_array($a_query)){
      $assembly_fees['name'] = addslashes($aount['products_name']);

// CLEANUP THE DESCRIPTION AND CUT TO SIZE
      $temp_description = str_replace("\r", "", $aount['products_description']);
      $temp_description = str_replace("\n", "", $temp_description);
      $temp_description = strip_tags(addslashes($temp_description));
      if (strlen($temp_description) >= $cpb_popup_short_description_length) {
        $assembly_fees ['description'] = substr($temp_description,0,$cpb_popup_short_description_length) . "...";
      } else {
        $assembly_fees ['description'] = $temp_description;
      }
      if (strlen($temp_description) >= $cpb_build_short_description_length) {
        $assembly_fees ['description2']   = substr($temp_description,0,$cpb_build_short_description_length) . "...";
      } else {
        $assembly_fees ['description2'] = $temp_description;
      }
      $assembly_fees['id']= $count['products_id'];
    if ((DISPLAY_PRICE_WITH_TAX) && ($cpb_build_show_tax)) {
        $b_query = tep_db_query("select products_price, products_image, products_tax_class_id from products p where " . $filter_product . " products_id='".$count['products_id']."'");
      } else {
        $b_query = tep_db_query("select products_price, products_image from products p where " . $filter_product . " products_id='".$count['products_id']."'");
      }
      $temps=tep_db_fetch_array($b_query);

// CHECK FOR SPECIALS
        $special_price = tep_get_products_special_price($count['products_id']);
        if ($special_price && !$cpb_ignore_specials) {
          $temp_price = $special_price;
        } else {
          $temp_price = $temps['products_price'];
        }

    $assembly_fees['fee'] = '&nbsp;'. $currencies->display_price($temp_price,tep_get_tax_rate($temps['products_tax_class_id']));

      $assembly_fees['image'] = $temps['products_image'];
      if (!$assembly_fees ['image']) {
        $assembly_fees ['image'] = 'no_product_image.gif';
      }
      $ccount++;
    }
    $textshow['assembly'].= "print_line('".$count2."','".$assembly_fees ['image']."','".$assembly_fees ['name']."','".$assembly_fees ['description']."','".$assembly_fees ['description2']."','".$assembly_fees ['fee']."','".$assembly_fees ['id']."','".$_GET['row']."'); \n";
    $count2++;
  }
  $textshow['assembly'].="print_deselect('"."<font color=\"red\">".TEXT_DESELECT_ITEM."</font>"."','".$_GET['row']."');\n";
  echo $textshow['assembly'];
} else {
  $output = $pcount;
  for ($ib = 0; $ib < $output; $ib++) {
    $cat = $osccat[$ib]; //
    if ($_GET['row'] == $ib) echo $textshow[$cat];
  }
}
?>
</script>
</body>
</html>
