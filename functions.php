<?php


function personal_chronicle_theme_enqueue_assets(){
    wp_enqueue_style(
       'personal-chronicle-theme-style',//子テーマcssハンドルネーム
       get_stylesheet_uri(),//子テーマcss、URLを返す。
       array('twentytwentyfive-style')//子テーマcssの前に、親テーマcssハンドル名cssを読みこめってこと
    );
     // SwiperライブラリのJsとcssを読み込む
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0', true );


    wp_enqueue_script(
        'personal-chronicle-main-script',
        get_stylesheet_directory_uri() . '/js/main.js', 
        array('swiper-js'), 
        '1.0.0', 
        true // trueにすると<body>の最後に読み込まれ、表示速度が向上
    );
    }
    add_action('wp_enqueue_scripts', 'personal_chronicle_theme_enqueue_assets');
    
    //これはjsとphpをつなぐ窓口の役割。
    add_action('rest_api_init', function () {
    register_rest_route('my-custom-api/v1', '/posts', array(
        'methods'  => 'GET', 
        'callback' => 'get_category_posts_for_ajax', 
    ));

});

function get_category_posts_for_ajax($request) {
    // 1. URLのパラメータからカテゴリーIDを取得
    $category_id = $request->get_param('category');
    $page_number = $request->get_param('page');
    
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 9, 
        'paged'          => $page_number,
        'ignore_sticky_posts' => 1,
    );
    if (!empty($category_id) && $category_id > 0) {
        $args['cat'] = $category_id;
    }
    

    // 3. 記事データを検索
    $no_image_id = 80; // 
    $no_image_data = wp_get_attachment_image_src($no_image_id, 'medium');
    $no_image_url = $no_image_data[0];

    $query = new WP_Query($args);
    $posts_data = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // 4. 必要なデータだけを抽出して配列に入れる
             $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $posts_data[] = array(
                'title'     => get_the_title(),
                'link'      => get_permalink(),
                'thumbnail' =>  $thumbnail_url ? $thumbnail_url : $no_image_url,
                'date'      => get_the_date('y/m/d'),
            );
        }
    }
    wp_reset_postdata();

    // 5. データをJSON形式でJavaScriptに返す
    return new WP_REST_Response($posts_data, 200);
}



function pickup_swiper_shortcode_function() {
     ob_start(); //バッファリング　即時送信ではなくすべて読み込んでからって感じのやつ。
     //phpファイルに直でjs書くとショートコードで文字列扱いになってjsが動かないのでmain.jsにjsはすべて書いて解決した。
 include( get_stylesheet_directory() . '/patterns/pickuparticle.php' );
    return ob_get_clean();
}
// 上記の関数を [pickup_carousel] という名前のショートコードとしてWordPressに登録
add_shortcode( 'pickup_article', 'pickup_swiper_shortcode_function' );

function new_article_shortcode(){
    ob_start();
    include( get_stylesheet_directory() .'/patterns/article.php');
    return ob_get_clean();
}
add_shortcode( 'new_article', 'new_article_shortcode');

function side_bar_shortcode(){
    ob_start();
    include(get_stylesheet_directory() .'/patterns/sidebar.php');
    return ob_get_clean();
}
add_shortcode('side_bar','side_bar_shortcode');

//プラグインのパンくずリスト
if (!function_exists('display_breadcrumb')) {
    function display_breadcrumb()
    {
        if (function_exists('bcn_display')) {
            $html = '<div class="breadcrumbs">' . bcn_display(true) . '</div>';
        } else {
            $html = '';
        }
        return $html;
    }
    add_shortcode('display_breadcrumb', 'display_breadcrumb');
}


//エディタ上で簡単にデザインができるようにするための設定。
function personal_chronicle_register_block_styles() {
    register_block_style( 'core/heading', array(
        'name'         => 'lined-heading', // CSSクラス名の is-style- の後の部分
        'label'        => '上下線',       // エディタのUIに表示される名前
    ) );
    register_block_style( 'core/heading',array(
        'name'         => 'stripe',
        'label'        => 'ストライプ',
    ));
    register_block_style( 'core/heading',array(
        'name'         => 'nuritubusi',
        'label'        => '塗りつぶし',
    ));
     register_block_style( 'core/heading',array(
        'name'         => 'vkp-heading-diagonal-stripe-line',
        'label'        => 'ストライプの下線',
    ));
     register_block_style( 'core/heading',array(
        'name'         => 'side-line',
        'label'        => '横線',
    ));
      register_block_style( 'core/heading',array(
        'name'         => 'check-buttom',
        'label'        => 'チェックボタン',
    ));
}
add_action( 'init', 'personal_chronicle_register_block_styles' );


// ブロックエディタに、専用のCSSを読み込ませる関数
function  personal_chronicle_enqueue_editor_assets() {
    // 'editor-style.css'という名前のファイルを、エディタ用のスタイルとして追加
    add_editor_style( 'editor-style.css' );
    
}
add_action( 'after_setup_theme', 'personal_chronicle_enqueue_editor_assets' );









