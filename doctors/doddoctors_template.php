<?php
  get_header();
?>
<div class='dodrdcontent'>
<?php
  the_content('Read more...');
?>
</div>
<?php  
  get_footer(); 
?>
<script type="text/javascript">
// being shitty and fixing layout issues with JS
  $(document).ready(function () {
    $('.dodrdoctorheader').wrap('<div class="dodrheaderprev">');
  });
</script>
