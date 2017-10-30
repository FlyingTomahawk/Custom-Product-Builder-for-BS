<?php
/*
  $Id: builder_main.php, v 1.1.0 2008/11/26 23:03:53 10c $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>

<script language="JavaScript">
var tindex=0;
var final_sum=0,sum=0,shipmentprice=0;
var PopupHeight= <?php echo $cpb_popup_height;?>;
var fields= <?php echo $total_builder_categories;?>;
var price = new Array();
var product = new Array();
var description = new Array();
var image = new Array();
var pid = new Array();
var recid = new Array();
var ammount = new Array();
var categ = new Array();
var prods_counter=0;
// IF AN OPTION IS NOT SET YET THEN THE MESSAGE IS HELD IN VARIABLE default_line (BELOW)
var default_line = '<?php echo "&nbsp;&nbsp;" . tep_image('images/' . "no_select.gif", '', 17, 17, 'align=absmiddle') . "&nbsp;&nbsp;" . TEXT_COMPONENT_NOT_SELECTED;?>';
var fmTimer;
var faded=true;
var fadeObj;

for (i=0;i<=fields;i++){
        price[i] = 0;
        product[i] = "0";
        description[i] = "";
        image[i] = "";
        pid[i] = "";
        recid[i] = "";
        ammount[i] = 0;
        categ[i]="";
}

// --------------------- Print Field ---------------------------- FOR DISPLAYING EACH LINE OF THE COMPONENTS SELECTED
function print_field(category,indx,row,picname,assemb_id){
  categ[indx]=category;
  document.write ("<tr onmouseover=\"this.style.backgroundColor='#DEDEDE';\" onmouseout=\"this.style.backgroundColor='';\" height=30>");
  var showcatimage='<?php echo $cpb_build_show_category_image;?>';
  if (showcatimage>0){
    document.write ("<th onClick='show_products(event,this,"+indx+","+row+","+assemb_id+")' valign=center width=<?php echo $cpb_build_category_image_width;?> align=left style='cursor:pointer;cursor:hand;' >");
//    document.write ("<th onClick=\"oFrame.style.display='none'\" valign=center width=<?php echo $cpb_build_category_image_width;?> align=left>");
    document.write ('<?php echo tep_image('images/' . $cpb_category_images_folder . "'+picname+'", "'+category+'", $cpb_build_category_image_width, $cpb_build_category_image_height, "align=absmiddle");?>');
  } else {

    document.write ("<th onClick='show_products(event,this,"+indx+","+row+","+assemb_id+")' valign=center align=left style='cursor:pointer;cursor:hand;' >");
//    document.write ("<th onClick=\"oFrame.style.display='none'\" valign=center align=left>");
    document.write ("&nbsp;"+category);
  }
  document.write ("</th>"
  +"<th>"
        +"<table style='border-collapse: collapse' bordercolor='#dddddd' border=0>"
          +"<tr>"
                +"<th align='left' onclick='show_products(event,this,"+indx+","+row+","+assemb_id+")' style='cursor:pointer;cursor:hand;' width=100%>"+default_line+"</th>"
                +"<th onClick='show_products(event,this,"+indx+","+row+","+assemb_id+")' style='cursor:pointer;cursor:hand;' >");
document.write ('<?php echo tep_image('images/' . "scroll.gif", '', 20, 18, 'align=absmiddle');?>');
document.write ("</th>");
document.write ("<th onClick=\"oFrame.style.display='none'\" valign=center><input type=\"button\" value=\"info\" style=\"border: #C4B0AB 1px solid; background-color: #F1F1F1; color: #5C5C5C; font-weight: bold\" onclick='show_desc("+indx+")'></th>"
          +"</tr>"
        +"</table>"
  +"</th>"
  +"<th align='right' onClick=\"oFrame.style.display='none'\" ></th>"
  +"<th align='center' onClick=\"oFrame.style.display='none'\" width=35>"
  +"<input type='hidden' name='products_id["+indx+"]' value='-1'>");
  document.write ("<select name='qty["+indx+"]' onchange=\"calc_subtotal(mainform);calc_total(mainform);\">");
<?php if($cpb_build_show_product_quantity) { ?>
  var qty_max = "<?php echo $cpb_build_component_qty_max; ?>";
  for (i=1;i<=qty_max;i++)
    document.write ("<option value="+i+">"+i+"</option>");
<?php } else { ?>
    document.write ("<option value=1 selected>1</option>");
<?php } ?>
  document.write ("</select>");
  document.write ("</th></tr>");
}

//--------------------- Fader ----------------------------
function fade(){
  if (!faded) {
        faded=true;
        faderObj.innerHTML=default_line;
        window.clearTimeout(fmTimer);
  }else{
          faded=false;
        fmTimer=window.setTimeout("Fade()",2000);
  }
}

//--------------------- Fade Row --------- INCLUDES PRIORITY ERRORS
function fade_row(row){
  if (!faded){
    faded=true;
    faderObj.innerHTML=default_line;
    window.clearTimeout(fmTimer);
  }
  var note="";
  if (row>1) {
    var PriorityCount = '<?php echo $cpb_build_priority_count;?>';
    if (row <= PriorityCount) {
      if (!recid[row-1]) {
        note=" <font color=#FF0000><b><?php echo TEXT_PRIORITY_ERROR; ?></b></font>";
      }
    }
  }
  if (note!="") {
    faderObj = document.getElementById("prod_table").rows[row].cells[1].childNodes[0].rows[0].cells[0];
    faderObj.innerHTML=default_line+note;
    fade();
    return false;
  } else {
    return true;
  }
}

//--------------------- Show Products ---------------------------- IN POPUP
function show_products(evt,e,pindex,row,assemb_id){
	if (pindex!=tindex){
        document.getElementById("oFrame").style.display="none";
        tindex=pindex;
	}
	if (!fade_row(pindex+1)) return;
      sURL="<?php echo 'builder_product_list.php';?>?assemb_id="+assemb_id+"&row="+pindex+"&currency="+currency+"&pindex="+pindex;
      for (i=0;i<recid.length;i++)
  	{
        sURL+="&idp"+i+"="+recid[i];
  	}
	if (document.getElementById("oFrame").innerHTML==""){
        document.getElementById("oFrame").innerHTML="<iframe name='oiFrame' id='oiFrame' height='100%' width='100%' border='0' frameborder='0'></iframe>";
	}
	var buffer="<html><head><style>BODY{font-family:Verdana,Arial,Tahoma,Helvetica,sans-serif;font-size:9pt;}TH{background-color:#86A5D2;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#0086A5D2',EndColorStr='#C0FFFFFF');font-style:italic;border:1px solid Black;cursor:default;}.select_table{BORDER-COLLAPSE:collapse;border:1px ridge;background-color:#F5F5F5;}tr{cursor:pointer;cursor:hand;}BODY{overflow: auto; margin: 0 0 0 0;background-color: #F5F5F5;}</style>";

// AUTO CLEAR LIST
      var clear_count = '<?php echo $cpb_build_auto_clear_count;?>';
      for (j=pindex+1;j<clear_count;j++) {
        add_product('-1','','','','','',j);
        mainform.elements["qty["+j+"]"].selectedIndex = 0;
      }

      sURL+="&select="+product[pindex]+"&currency="+currency;
      oiFrame.document.write("<center><br>"+buffer+text_please_wait+"<br><br><img src='<?php echo 'images/';?>pbar.gif' width='71' height='11' border='0'>");
      window.open(sURL,"oiFrame");
      if (pindex){
        buffer+="<tr onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\" onclick=\"parent.add_product('','','','','','"+pindex+"','"+pindex+"');\"><td align='center' colspan=3><b>"+text_deselect_items+"</b></td></tr>";
        oiFrame.document.write(buffer+loadRow(pindex)+"</table>");
        window.open(sURL,"oiFrame");
      }

    if (document.getElementById("oFrame").style.display=="none") {
        var categoryid=-1;
        var aTag;
        tab=e.parentNode; //TR
        var aTag=tab;
        var offsetHeight=100;
        var leftpos=<?php echo $cpb_popup_offset_left;?>;
        var toppos=<?php echo $cpb_popup_offset_top;?>;
        do {
                aTag = aTag.offsetParent;
                leftpos += aTag.offsetLeft;
                toppos += aTag.offsetTop;
        } while(aTag.tagName!="BODY");

        var TotTop=tab.offsetTop+tab.offsetHeight+toppos;

        document.getElementById("oFrame").style.left =tab.offsetLeft+leftpos+1;
        if (evt.clientY+PopupHeight+10>document.body.clientHeight){
                TotTop-=PopupHeight+tab.offsetHeight;
        }
        document.getElementById("oFrame").style.height=PopupHeight;
        document.getElementById("oFrame").style.top = TotTop;
        document.getElementById("oFrame").style.width = tab.cells[0].offsetWidth+tab.cells[1].offsetWidth+1;
        document.getElementById("oFrame").style.display="inline";
    }
    else{
      document.getElementById("oFrame").style.display="none";
    }
}

//--------------------- Load Row ----------------------------
function loadRow(indx){
        var j;
        var buffer="";
        for (j=0;(l[indx][j]);j++)
		  buffer+=print_line(indx,j);
        if (!buffer)
          buffer = "";
        return buffer;
}

//--------------------- Print Line ------------- THIS FUNCTION IS DUPLICATED IN ANOTHER - SEPARATED, BUT CONFUSING - had me going for a while
function print_line(row,line){
  var buffer="";
  if (l[row][line][1]){
        var pdesc2 = l[row][line][1].replace(/:inc:/gi, '"')
        re2 = new RegExp ('\'', 'gi') ;
        l[row][line][1] = l[row][line][1].replace(re2, ":tag:")
        buffer+= "<tr onclick=\"parent.add_product('"+l[row][line][0]+"','"+l[row][line][1]+"','"+l[row][line][2]+"','"+l[row][line][3]+"',"+l[row][line][4]+");\" onmouseover=\"this.style.backgroundColor='#86A5D2';\" onmouseout=\"this.style.backgroundColor='';\">"
+"<td align='left'>"+pdesc+"</td><td align='right' width=70>&nbsp;"+l[row][line][2]+""+currency+"</td></tr>";
  }else{
        buffer+=print_title(l[row][line][0]);
  }
  return buffer;
}

//--------------------- Print Title ----------------------------
function print_title(title){
        return "<tr><th align='center' colspan='3'>"+title+"</th></tr>";
}

//--------------------- Calculate Subtotal ----------------------------
function calc_subtotal(form){
        var sum=0

        for (i=0;i<=fields;i++){
                if (price[i]>0){
                        sum=sum+parseFloat(price[i]*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));
                }
        }
        var lines=form.select1.length
        var softprice=0;
        for (i=1;i<lines;i++){
                if (form.select1.options(i).selected){
                        softprice+=parseFloat(form.select1.options(i).price)*parseFloat(form.qty100.selectedIndex+1);
                }
        }
        form.sum.value=formatnumber(sum+softprice);
}

//--------------------- Calculate Sum ----------------------------
// THIS ONE ONLY SEEMS TO GET CALLED WHEN CHANGING A QTY
function calc_total(form){
    	form.totsum.value=form.sum.value;
}

function calc_total_tmp(form){
        var sum=0;
        var final_sum;
        for (i=0;i<=fields;i++){
                if (price[i]>0){
                        sum=sum+parseFloat(price[i]*(form.elements["qty["+(i-1)+"]"].selectedIndex+1));
                }
        }
        var lines=form.select1.length
        var softprice=0;
        for (i=1;i<lines;i++){
                if (form.select1.options(i).selected){
                        softprice+=parseFloat(form.select1.options(i).price)*parseFloat(form.qty[100].selectedIndex+1);
                }
        }
        sum=formatnumber(sum+softprice);
        final_sum=sum;
        form.sum.value=final_sum;
        form.totsum.value=final_sum;
}

//--------------------- Form check before submission ---------------------------- now checks for proper 'zero'
function mainform_onsubmit(form,sact,fields) {
  if (sact!=3) {
    if (form.sum.value<"0.001"){
      alert ("<?php echo TEXT_NO_ITEMS_WARNING;?>");
      return false;
    }
    var minimum_order_count = "<?php echo $cpb_build_minimum_order_count;?>";
    if (minimum_order_count>0){
      for (i=1;i<=minimum_order_count;i++) {
        if (!recid[i]){
          alert ("<?php echo TEXT_MINIMUM_ITEMS_WARNING;?>");
          return false;
        }
      }
    }
    for (i=0;i<=fields;i++){
      ammount[i+1]=form.elements["qty["+i+"]"].selectedIndex+1;
    }

// CLEAR ALL OUTPUT FIELDS
    var urltemp="<?php echo tep_href_link('builder_main.php?action=add_products');?>";
    form.product.value="";
    form.description.value="";
    form.image.value="";
    form.p_id.value="";
    form.p_qty.value="";
    form.price.value="";

    for (i=1;i<=fields+1;i++){
      if (recid[i]){
        // these used for printing
        if (decimal_places>0 && decimal_point.length<1){
          form.price.value+=price[i].substr(0,(price[i].length-decimal_places))+"."+price[i].substr((price[i].length-decimal_places),decimal_places)+"::";
        } else {
          form.price.value+=price[i]+"::";
        }
        form.product.value+=product[i]+"::";
        form.description.value+=description[i]+"::";
        form.image.value+=image[i]+"::";
        // these used for building
        form.p_id.value+=recid[i]+"::";
        form.p_qty.value+=ammount[i]+"::";
      } else {
        form.price.value+="::";
        form.product.value+="::";
        form.description.value+="::";
        form.image.value+="::";
        form.p_id.value+="::";
        form.p_qty.value+="::";
      }
    }

    if (sact==2){
      form.action=urltemp;
      form.target="_self";
      form.submit();

    } else if (sact==1){
      form.totprint.value=currency_left+" "+form.totsum.value+" "+currency_right;
	form.action="<?php echo tep_href_link('builder_print_preview.php');?>";
      form.target="_new";
      form.submit();
    }

  } else {
    form.action="<?php echo tep_href_link('builder_main.php');?>";
    form.target="_self";
    form.submit();
  }
}

//----------------- Show Description ---------------
function show_desc(row){
        row++;
        if (recid[row])
                window.open ("builder_component_info.php?products_id="+recid[row]+"",'','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=600,screenX=150,screenY=150,top=150,left=150');return(false);
}
</script>
