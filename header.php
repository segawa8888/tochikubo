<!--
　　     　::::    :::     :::     :::    ::: :::    :::     :::
     :+:+:   :+:     :+:     :+:   :+:  :+:   :+:      :+:      
    :+:+:+  +:+     +:+     +:+  +:+   +:+  +:+       +:+       
   +#+ +:+ +#+     +#+     +#++:++    +#++:++        +#+        
  +#+  +#+#+#     +#+     +#+  +#+   +#+  +#+       +#+         
 #+#   #+#+#     #+#     #+#   #+#  #+#   #+#      #+#          
###    ####     ###     ###    ### ###    ###     ###
-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <!-- meta情報 -->
  <title>Tochikubo Ryunosuke</title>
  <meta name="description" content="Here is my portfolio." />
  <meta name="keywords" content="tochikuboryunosuke,とちくぼりゅうのすけ,栃久保龍之介,トチクボリュウノスケ,tochikubo,ryunosuke,Graphicdesign,Artdirection,illustration,designer,director,illustrator" />
  <!-- ogp -->
  <meta property="og:title" content="Tochikubo Ryunosuke" />
  <meta property="og:type" content="top" />
  <meta property="og:url" content="https://tochikuboryunosuke.com" />
  <meta property="og:image" content="" />
  <meta property="og:site_name" content="Tochikubo Ryunosuke" />
  <meta property="og:description" content="Here is my portfolio." />
  <!-- css -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/styles.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/swiper-bundle.css">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <!-- fontawesome -->
  <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
  <?php wp_head(); ?>
</head>
<body>

<?php if(is_front_page()) { ?>
  <div id="loader">
    <div class="loader-slide"></div>
</div>
<?php }; ?>

<header class="header">
    <p class="header-copyright">&copy; 2023 Tochikubo Ryunosuke</p>

    <div class="header-menu">
      <ul class="swiper-wrapper">
      <?php
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC' //日付の早い順から取得
);

$sub_query = new WP_Query( $args );

if ( $sub_query->have_posts() ) :
    while ( $sub_query->have_posts() ) :
        $sub_query->the_post();
?>

  <li class="swiper-slide">
    <?php if ( has_post_thumbnail() ) : ?>
    <?php the_post_thumbnail(); ?>
<?php else : ?>
    |
<?php endif; ?>
  </li>

  <?php
    endwhile;

    wp_reset_postdata();
endif;
?>
      </ul>
      <div class="header-button-prev"></div>
      <div class="header-button-next"></div>
  </div>
  
  </header>