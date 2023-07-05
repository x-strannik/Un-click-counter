<?php 
/*
Plugin Name: Un-click counter
Plugin URI: https://kodabra.unchikov.ru/file-download-counter/
Description: Счетчик скачиваний файлов (шорткод [un_click_counter], у ссылки id="download"; или [un_click_counter id="id_ссылки"])
Author: Elena Unchikova
Version: 1.0.0
Author URI: https://kodabra.unchikov.ru/
License: GPL2
*/
 
// Выход при прямом доступе.
     if ( ! defined( 'ABSPATH' ) ) { exit; }
 
add_shortcode( 'un_click_counter', 'un_click_counterf' ); // шорткод [un_click_counter]
function un_click_counterf($attrs) {
ob_start();

$params=shortcode_atts( array('id' => 'download'),$attrs);
$idlink=$params['id'];
 
// *******************************************************
?>
<link rel='stylesheet' href="<?php echo plugin_dir_url( __FILE__ ) . 'un-click-counter-style.css'; ?>" type='text/css' media='all' />
<span id="<?php echo $idlink . 'clc';?>" class="uncnt"></span>
<script type="text/javascript">
jQuery(document).ready(function($) {
	var dnl = document.getElementById('<?php echo $idlink;?>');
	var hrf = dnl.href;
	var dnld_name = hrf.split("/").pop();
    var dnld_href = dnld_name.slice(0, -4);
    var dnld_href_txt = dnld_href+'.txt';
	var dnld_hrefn_txt = "<?php echo plugin_dir_url( __FILE__ ) . 'calc/'; ?>"+dnld_href_txt;
	
$.ajaxSetup({cache: false});
$.ajax({ url: dnld_hrefn_txt, success: function(file_content) {
	document.getElementById("<?php echo $idlink . 'clc';?>").innerHTML="(Скачиваний: "+file_content+")";
  }
});
	
dnl.addEventListener('click', function () {   
  var data = "dnld_href_txt=" + encodeURIComponent(dnld_href_txt);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "<?php echo plugin_dir_url( __FILE__ ) . 'un-click-counter-post.php'; ?>" , true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
  xhr.onreadystatechange = function()
  {
    if (xhr.readyState == 4)
    {
      if(xhr.status == 200)
      {
         document.getElementById("<?php echo $idlink . 'clc';?>").innerHTML="(Скачиваний: "+xhr.responseText+")";
      }
    }
  }
 
})
 
});
</script>
<?php
// *******************************************************
return ob_get_clean();
}
?>