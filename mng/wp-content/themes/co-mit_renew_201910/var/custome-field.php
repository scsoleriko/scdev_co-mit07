<?php

// 固定カスタムフィールドボックス
function add_column_fields() {
  //add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
  //第4引数のpostをpageに変更すれば固定ページにオリジナルカスタムフィールドが表示されます(custom_post_typeのslugを指定することも可能)。
  //第5引数はnormalの他にsideとadvancedがあります。
  add_meta_box(
    'facility_column_relation',
    '研修ノウハウ・コラムの関連付け',
    'insert_html_fields',
    'facility',
    'normal',
    'high',
    array(
      "field_key" => "facility_column_relation_meta",
      "field_label" => "表示したいコラムを選択してください",  //項目別のタイトル
    )
  );
}
add_action('admin_menu', 'add_column_fields');


// カスタムフィールドの入力エリア
function insert_html_fields ($post, $param) {
  $current = trim(get_post_meta($post->ID, trim($param['args']['field_key']), true));
  // nonceの追加
  wp_nonce_field( 'action-' . trim($param['args']['field_key']), 'nonce-' . trim($param['args']['field_key']) );

?>

<select name="<?php echo trim($param['args']['field_key']); ?>">
<option value=""><?php echo trim($param['args']['field_label']); ?></option>
<?php

$the_query = new WP_Query( array(
    "post_type" => "column",
    "post_status" => "publish",
    "posts_per_page" => -1,
    "tax_query" => array(
    array(
      "taxonomy" => "category_column",
      "field" => "slug",
      "terms" => array("special_content"),
      "operator" => "NOT IN"
    )
  )
));

if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
$id = trim(get_the_ID());
?>
<option value="<?php echo $id; ?>" <?php echo ($id === $current) ? "selected='selected'" : ""; ?> ><?php the_title_attribute(); ?></option>

<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</select>

<?php
}

// カスタムフィールドの値を保存
function save_column_fields( $post_id ) {
  $custom_fields = array("facility_column_relation_meta");

  foreach( $custom_fields as $d ) {
    if ( isset( $_POST['nonce-' . $d] ) && $_POST['nonce-' . $d] ) {
      if( check_admin_referer( 'action-' . $d, 'nonce-' . $d ) ) {
        if( isset( $_POST[$d] ) && $_POST[$d] ) {
          update_post_meta( $post_id, $d, $_POST[$d] );
        } else {
          delete_post_meta( $post_id, $d, get_post_meta( $post_id, $d, true ) );
        }
      }
    }
  }
}

add_action("save_post", "save_column_fields");
?>