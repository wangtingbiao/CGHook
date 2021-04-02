<?php
/**
 * 后台文章列表设置文章特色图片
 *
 * Plugin Name: Easy Thumbnail Switcher
 *
 * @package CGHook
 */

class CGh_Easy_Thumbnail_Switcher {

	public $add_new_str;
	public $change_str;
	public $remove_str;
	public $upload_title;
	public $upload_add;
	public $confirm_str;

	public function __construct() {

		$this->add_new_str = __( '添加' );
		$this->change_str = __( '更改' );
		$this->remove_str = __( '移除' );
		$this->upload_title = __( '上传特色图片' );
		$this->upload_add = __( '确定' );
		$this->confirm_str = __( '你确定?' );

		add_filter( 'manage_posts_columns', array( $this, 'add_column' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'thumb_column' ), 10, 2 );
		add_action( 'admin_footer', array( $this, 'add_nonce' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

		add_action( 'wp_ajax_ts_ets_update', array( $this, 'update' ) );
		add_action( 'wp_ajax_ts_ets_remove', array( $this, 'remove' ) );

		add_image_size( 'ts-ets-thumb', 'auto', 60, array( 'center', 'center' ) );

	}

	/**
	 * 安全检查
	 */
	public function add_nonce() {

		global $pagenow;

		if ( $pagenow !== 'edit.php' ) {
			return;
		}
		wp_nonce_field( 'ts_ets_nonce', 'ts_ets_nonce' );

	}

	/**
	 * 加载脚本
	 */
	public function scripts( $pagenow ) {

		if ( $pagenow !== 'edit.php' ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'doocii-ets-js', get_template_directory_uri() . '/assets/js/easy-thumbnail.js', array( 'jquery', 'media-upload', 'thickbox' ), '1.0', true );

		wp_localize_script( 'doocii-ets-js', 'ets_strings', array(
			'upload_title' => $this->upload_title,
			'upload_add' => $this->upload_add,
			'confirm' => $this->confirm_str,
		) );

	}

	/**
	 * The action which is added to the post row actions
	 */
	public function add_column( $columns ) {

		$columns[ 'ts-ets-option' ] = __( '缩略图' );
		return $columns;

	}

	/**
	 * 显示列
	 */
	public function thumb_column( $column, $id ) {

		switch ( $column ) {
			case 'ts-ets-option':

				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'ts-ets-thumb' );
					echo '<br>';
					echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->change_str );
					echo sprintf( ' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr( $id ), $this->remove_str );
				} else {
					echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->add_new_str );
				}

				break;
		}

	}

	/**
	 * AJAX保存更新缩略图
	 */
	public function update() {

		// 检查是否所有需要的数据都设置与否
		if ( !isset( $_POST[ 'nonce' ] ) || !isset( $_POST[ 'post_id' ] ) || !isset( $_POST[ 'thumb_id' ] ) ) {
			wp_die();
		}

		//验证
		if ( !wp_verify_nonce( $_POST[ 'nonce' ], 'ts_ets_nonce' ) ) {
			wp_die();
		}

		$id = $_POST[ 'post_id' ];
		$thumb_id = $_POST[ 'thumb_id' ];

		set_post_thumbnail( $id, $thumb_id );

		echo wp_get_attachment_image( $thumb_id, 'ts-ets-thumb' );
		echo '<br>';
		echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->change_str );
		echo sprintf( ' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr( $id ), $this->remove_str );

		wp_die();

	}

	/**
	 * AJAX回调后删除缩略图
	 */
	public function remove() {

		// Check if all required data are set or not
		if ( !isset( $_POST[ 'nonce' ] ) || !isset( $_POST[ 'post_id' ] ) ) {
			wp_die();
		}

		// Verify nonce
		if ( !wp_verify_nonce( $_POST[ 'nonce' ], 'ts_ets_nonce' ) ) {
			wp_die();
		}

		$id = $_POST[ 'post_id' ];

		delete_post_thumbnail( $id );

		echo sprintf( '<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr( $id ), $this->add_new_str );

		wp_die();

	}

}

new CGh_Easy_Thumbnail_Switcher();