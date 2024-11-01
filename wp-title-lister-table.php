<?php
error_reporting(E_ALL);
include(WTLDIR.'/wp-title-lister-source.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wp Title Lister Tables</title>
<script type="text/javascript" src="<?php echo WTLURL ?>/js/jquery.js"></script> 
<script type="text/javascript" src="<?php echo WTLURL ?>/js/ajaxtable.js"></script> 
<script>
$(document).ready(function() {
$("#categories").ajaxtable({source: "<?php echo WTLURL ?>/wp-title-lister-source.php",
								currentPage: 1,
								rowsPerPage:20,
								loadElement: ".loader2",
								searchField: "#search",
								ascImage: "images/down.png",
								descImage: "images/up.png",
								columnWidth: ["10%", "40%", "13%", "18%", "19%"],
								sortColumnDefault: "ID",
								sortDefault: "desc",
								nextPrev: true});
});
</script>
<link href="<?php echo WTLURL ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WTLURL ?>/css/table.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
<div id="maincontent">
<h2><?php bloginfo('name'); ?></h2>
<p><?php bloginfo('description'); ?></p>
<table width="700px" border="0" cellspacing="0" cellpadding="0" id="categories" class="advancedtable">
  <caption>
  <div class="search">
    <input style="display:none" type="text" name="search" id="search" />
  </div>
  <div class="loader2 loader"><img alt="Loader" src="<?php echo WTLURL ?>/images/loader.gif" /></div>
  <div class="title wptlTitle">Wordpress Title Lister</div>
  </caption>
  <thead>
    <?php echo $Provider->GetHead(); ?>
  </thead>
  <tbody>
    <?php echo $Provider->GetBody(); ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="5"><div class="tableInfo"><?php _e('This is record', 'wp-title-lister') ?> <span class="firstrow"><?php echo $Provider->GetFirstRow(); ?></span> <?php _e('to', 'wp-title-lister') ?> <span class="lastrow"><?php echo $Provider->GetLastRow(); ?></span> <?php _e('from', 'wp-title-lister') ?>  <span class="totalrows"><?php echo $Provider->GetTotalRows(); ?></span></div>
          <div class="tablenavigation"><?php echo $Provider->GetNavigation(); ?></div></td>
    </tr>
  </tfoot>
</table>

</div>
</body>
</html>
