 <?php get_header(); ?>

<div class="swiper-container main-page">
  <div class="swiper-wrapper">
 

<section class="index swiper-slide">

<input type="radio" name="radio" id="single" class="c-radio" checked="checked">
  <input type="radio" name="radio" id="multi" class="c-radio">

<div class="switch-control">
<label for="single" class="btn__single switch-button" data-columnnum="1">
      <span></span>
    </label>

    <label for="multi" class="btn__multi btn_multi-sp switch-button" data-columnnum="3">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <label for="multi" class="btn__multi btn_multi-pc switch-button" data-columnnum="4">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </label>
</div>

<div class="switch-box">
<div class="swiper-container slider">
    <div class="swiper-wrapper">
      <?php
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC'
);

$sub_query = new WP_Query( $args );

if ( $sub_query->have_posts() ) :
    while ( $sub_query->have_posts() ) :
        $sub_query->the_post();
?>
<div class="swiper-slide">
<div id="card" class="card fade">
    <div class="card-content">
      <p class="card-tittle"><?php the_title(); ?></p>
      <p class="card-desc">
      <?php echo nl2br(get_post_meta($post->ID, 'description', true)); ?>
    </p>
  </div>

  <div class="modal-open post-<?php echo $post->ID; ?>">
    <?php the_content(); ?>
    </div>

<!-- モーダル -->
<div class="modal modal-<?php echo $post->ID; ?>" id="modal-<?php echo $post->ID; ?>">
  <div class="modal__overlay modalClose"></div>
  <div class="modal__content">
    <div class="modal_inner">
      <!-- スライダー -->
      <div class="swiper-container modal-swiper-container">
        <div class="swiper-wrapper">
          <!-- swiper-slide はここに生成される -->
          <?php
            //投稿本文を取得
            $content = $post->post_content;

            //本文内で使用しているショートコードを除去
            $content = strip_shortcodes($content);

            //本文内に入っている画像を全て抽出
            preg_match_all('/<img(?:.*?)src=[\"\'](.*?)[\"\'](.*?)>/i', $content, $all_imgs);

            //初期化
            $complete_imgs = [];

            if ($all_imgs[1]) {
                foreach ($all_imgs[1] as $tmp) {
                    //サムネイル記述を削除して、オリジナルの画像パスに変換
                    $original_img = preg_replace("/(.+)(-[0-9]+x[0-9]+)(\.[^.]+$)/", "$1$3", $tmp);
                    
                    // swiper-slideクラスを生成
                    echo "<div class='swiper-slide modalInSlider'>";
                    echo "<img width='100%' src='" . $original_img  . "'>";
                    echo "</div>";
                }
            }
          ?>
        </div>
        <div class="modal__close-btn modalClose" aria-label="閉じる">	
          <img src="<?php echo get_template_directory_uri(); ?>/images/index/modalClose.png">
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <p class="modal__description"><?php the_title(); ?></p>
      </div>
    </div>
  </div>
</div>

  </div>
  </div>
 

  <?php
    endwhile;

    wp_reset_postdata();
endif;
?>
</div>


</section>

<section id="contact" class="contact swiper-slide noSwiping">
  <div class="contact__container">
    <div class="contact__wrapper">
      <p class="contact__text">Do let me know if you need any further information.</p>
      <div class="contact__form">
      <?php echo do_shortcode('[contact-form-7 id="50" title="contact form"]'); ?>
      </div>
    </div>
  </div>
</section>

<section class="friends swiper-slide">
  <div class="friends__container">
    <div class="friends__wrapper">
      <p class="friends__tittle">Collaborators</p>
      <p class="friends__area--tittle">Friends :</p>

      <div class="friends__content">
      <?php
$args = array(
    'post_type'      => 'friend',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC' //日付の早い順から取得
);

$sub_query = new WP_Query( $args );

if ( $sub_query->have_posts() ) :
    while ( $sub_query->have_posts() ) :
        $sub_query->the_post();
?>
        <div class="friends__area">
          <p><?php echo nl2br(get_post_meta($post->ID, 'name', true)); ?></p>
          <div class="friends__wrap">
          <p class="friends__work"><?php echo nl2br(get_post_meta($post->ID, 'work', true)); ?></p>
          <a href="<?php echo nl2br(get_post_meta($post->ID, 'url', true)); ?>" target="_blank" class="friends__link u-desktop">
            <img src="<?php echo get_template_directory_uri(); ?>/images/index/arrow.svg" alt="arrow">
          </a>
          </div>
        </div>
        <a href="<?php echo nl2br(get_post_meta($post->ID, 'url', true)); ?>" target="_blank" class="friends__link u-mobile">
          <img src="<?php echo get_template_directory_uri(); ?>/images/index/arrow.svg" alt="arrow">
        </a>
        
        <?php
    endwhile;

    wp_reset_postdata();
endif;
?>

        <p class="friends__message u-desktop">Feel free to <a class="slide-link" href="#" data-slide="1">contact</a> us if you are interested in working with us.</p>
      </div>
      <p class="friends__message u-mobile">Feel free to <a class="slide-link" href="#" data-slide="1">contact</a> us <br>
        if you are interested in working with us.</p>
    </div>
  </div>
</section>



</div>
<div class="swiper-scrollbar"></div>
</div>

<?php get_footer(); ?>