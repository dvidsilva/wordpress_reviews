<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

  $args = array(
	'posts_per_page'   => 40,
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


if($doctor_page){
  //$args['meta_key'] = 'doctor_page';
  //$args['meta_value'] = $current_doc;
  $args['meta_query'] = array(
    array('key' => 'doctor_page',
          'value' => $current_doc,
          'compare' => 'LIKE'
         )
  );
}

$reviews_array = get_posts( $args );

$total_reviews = count($reviews_array);

if($doctor_page){
  // getting a minimun of 3 reviews
  $missing = 3 - $total_reviews;
  if($missing > 0 ) {
    remove_all_filters('posts_orderby');
    $args['post_per_page'] = $missing;
    $args['orderby'] = 'rand';
    $args['meta_query'] = array(
    array('key' => 'doctor_page',
          'value' => $current_doc,
          'compare' => '!='
         )
    );
    $reviews_array2 = get_posts( $args );
    $reviews_array = array_merge($reviews_array, $reviews_array2);
  }
}
?>

<!-- main container -->
<div id="dodreviews12">
<!--  <h1>Hear From Our Patients</h1>-->
  <?php
    if($total_reviews>3){
  ?>
  <div class="dodrarrow dodrleftarrow" data-dir="right"></div>
  <div class="dodrarrow dodrrighttarrow" data-dir="left"></div>
  <?php
    }
  ?>
<ul class="dodrslider">
  <?php
  foreach ($reviews_array as $k => $review) {
   ?>
    <li class="dodrslide review_<?php echo $review->ID; ?>">
     <div class="dodrtop">
        <div class="dodrstars">
          <?php $stars = 5; //  get_post_meta($review->ID, 'stars', true);
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
          <?php 
            $c = strip_tags($review->post_content); 
            $doctor_page = get_post_meta($review->ID, 'doctor_page', true);
            $doctor_page = parse_url($doctor_page, PHP_URL_SCHEME) === null ? "http://". $doctor_page : $doctor_page;
            $doctor_name = get_post_meta($review->ID, 'doctor_name', true);        
            $content  = str_replace($doctor_name, "<a href='".$doctor_page."' >".$doctor_name."</a>", $c);
            if(strlen($c) < 220 ) {
              echo $content;
            } else {
              $c  = str_replace($doctor_name, "<a href='".$doctor_page."' >".$doctor_name."</a>", substr(trim($c), 0, 214));
              echo '<span class="dodrclippedr">' ;
              echo $c . '&hellip;' . '</span>' ;
              echo '<a class="dodrreadmore">[more]</a>';
              echo '<span class="dodrfullr">' . $content . '</span>';
            }
          ?>
        </p>
        <p><span class="dodrusername">&ndash; by 
          <?php echo get_post_meta($review->ID, 'author', true); ?></span></p>
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