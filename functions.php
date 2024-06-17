<?php 

add_action('wp_footer', 'redirect_to_thanks_page');
function redirect_to_thanks_page() {
  $homeUrl = home_url();
  echo <<< EOD
    <script>
      document.addEventListener( 'wpcf7mailsent', function( event ) {
        location = '{$homeUrl}/thanks/';
      }, false );
    </script>
  EOD;
}

// カスタム投稿タイプ【コース】
function cpt_register_friend(){
	$args = [
		'label' => 'フレンド',
		'labels' => [
			'singular_name' => 'フレンド',
			'edit_item' => 'フレンドを編集',
			'add_new_item' => '新規フレンドを追加'
		],
		'public' => true, //カスタム投稿タイプを一般に公開するかどうか
		'show_in_rest' => true, //REST APIにカスタム投稿タイプを含めるかどうか → カスタム投稿タイプでブロックエディタを使うならtrue
		'has_archive' => false, //アーカイブページを持つかどうか
		'delete_with_user' => false, //ユーザーを削除した後、コンテンツも削除するかどうか
		'exclude_from_search' => false, //検索から除外するかどうか
		'hierarchical' => true, //階層化するかどうか
		'query_var' => true, //クエリパラメーターを使えるようにする → プレビュー画面を使うためにはtrue
		'menu_position' => 5, //管理画面に表示するメニューの位置
		'supports' => [
			'title', 'editor', 'thumbnail', 'custom-fields'
		], //カスタム投稿タイプがサポートする機能
	];
	register_post_type('friend', $args);
}
add_action('init', 'cpt_register_friend');


function enqueue_scripts() {
    // 全投稿の画像数をカウント
    $args = array('posts_per_page' => -1);
    $all_posts = get_posts($args);
    $total_images = 0;

    foreach ($all_posts as $post) {
        $content = $post->post_content;
        $content = strip_shortcodes($content);
        preg_match_all('/<img(?:.*?)src=[\"\'](.*?)[\"\'](.*?)>/i', $content, $all_imgs);
        $total_images += count($all_imgs[1]);
    }

    // JavaScriptにデータを渡す
    wp_localize_script('main', 'globalData', array('totalImages' => $total_images));
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');
