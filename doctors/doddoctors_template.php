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
  
  $doctor_type = get_post_meta(get_the_ID(), 'doctor_type', true);

?>
<script type="text/javascript">
// being shitty and fixing layout issues with JS
  $(document).ready(function () {
    $('.dodrdoctorheader').wrap('<div class="dodrheaderprev">');
  });
  <?php
    echo 'var doctor_type = ' . $doctor_type;
    if($doctor_type==="pediatrician"){
  ?>
    $('.dodrdoctorheader [href*="medical"]').attr('href','http://wwwtest.doctorondemand.com/pediatrics');
  <?php
    }
  ?>
</script>
