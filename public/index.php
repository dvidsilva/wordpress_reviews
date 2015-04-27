<?php $args = array(
	'posts_per_page'   => 15,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'dodreview',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
 $reviews_array = get_posts( $args );
//print_r($reviews_array);
?>

<!-- main container -->
<div id="dodreviews">
  <h1>Hear From Our Patients</h1>
   
   <div class="dodrarrow dodrleftarrow" data-dir="left"></div>
  <div class="dodrarrow dodrrighttarrow" data-dir="right"></div>
   
<ul class="dodrslider">
  <?php
  foreach ($reviews_array as $k => $review) {
   ?>
    <li class="dodrslide review_<?php echo $review->ID; ?>">
     <div class="dodrtop">
        <div class="dodrstars">
          <?php $stars =  get_post_meta($review->ID, 'stars', true);
            for ($i = 0; $i < $stars; $i++) {
          ?>
            <span class="dodrstar"></span>
          <?php
            }
          ?>
        </div>
      </div>
      <div class="dodrtext">
        <p class="dodrreview ">
          <?php echo $review->post_content; ?>
          <span class="dodrusername">&ndash;<?php echo get_post_meta($review->ID, 'author', true); ?></span>
        </p>
      </div>
      <p class="dodrdate"><?php echo get_post_meta($review->ID, 'date', true); ?></p>
    </li>
    <?php
    }
    ?>
  </ul>
</div>
<!-- /main container -->
<?php 
  //@TODO add doctor_name and doctor_page 
?>