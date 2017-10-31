<div class="panel panel-default">
  <div class="panel-heading"><?php echo '<a href="' . tep_href_link('builder_main.php') . '">' . MODULE_BOXES_BUILDER_BOX_TITLE . '</a>'; ?></div>
  <div class="panel-body">
    <?php echo '<a href="' . tep_href_link('builder_main.php') . '">' . tep_image('images/' . $builder['cpb_product_builder_image'] , $builder[cpb_product_builder_name], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br><div class="text-center">' . $builder['cpb_product_builder_name'] . '</div></a>'; ?>
  </div>
</div>
