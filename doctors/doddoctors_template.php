<?php
  get_header();
  the_content('Read more...');
  get_footer(); 
?>
<script type="text/javascript">
// being shitty and fixing layout issues with JS
  $(document).ready(function () {
    $('.dodrdoctorheader').wrap('<div class="dodrheaderprev">');
  });
</script>
