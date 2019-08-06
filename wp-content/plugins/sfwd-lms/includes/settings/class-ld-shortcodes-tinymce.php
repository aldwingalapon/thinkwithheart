<?php
if ( ! class_exists( 'LearnDash_Shortcodes_TinyMCE' ) ) {

	class LearnDash_Shortcodes_TinyMCE {

		protected $post_types = array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'sfwd-quiz', 'sfwd-question', 'sfwd-certificates', 'page', 'post' );

		public function __construct() {

			add_action( 'load-post.php', array( $this, 'add_button' ), 1 );
			add_action( 'load-post-new.php', array( $this, 'add_button' ), 1 );
			add_action( 'admin_print_footer_scripts', array( $this, 'qt_button_script' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
			add_action( 'wp_ajax_learndash_generate_shortcodes_content', array( $this, 'learndash_generate_shortcodes_content' ) );
		}

		public function qt_button_script() {
			global $typenow, $pagenow, $post;

			if ( ( 'post.php' === $pagenow ) || ( 'post-new.php' === $pagenow ) ) {
				// check user permissions
				if ( current_user_can( 'edit_posts' ) ) {
					//if ( ! use_block_editor_for_post( $post ) ) {
						if ( in_array( $typenow, apply_filters( 'learndash_shortcodes_tinymce_post_types', $this->post_types, $typenow ) ) ) {
							if ( wp_script_is( 'quicktags' ) ) {
								?>
								<script type="text/javascript">
									QTags.addButton( 'learndash_shortcodes', '[ld]', learndash_shortcodes_qt_callback, '', '', '', 'LearnDash Shortcodes' );

									// In the QTags.addButton we need to call this intermediate function because learndash_shortcodes is now loaded yet. 
									function learndash_shortcodes_qt_callback() {
										learndash_shortcodes.qt_callback();
									}
								</script>
								<?php
							}
						}
					//}
				}
			}
		}

		public function add_button() {
			global $typenow, $pagenow, $post;

			if ( ( 'post.php' === $pagenow ) || ( 'post-new.php' === $pagenow ) ) {
				// check user permissions
				if ( current_user_can( 'edit_posts' ) ) {
					//if ( ! use_block_editor_for_post( $post ) ) {
						// check if WYSIWYG is enabled
						if ( get_user_option( 'rich_editing' ) == 'true' ) {

							// verify the post type
							if ( in_array( $typenow, apply_filters( 'learndash_shortcodes_tinymce_post_types', $this->post_types, $typenow ) ) ) {
								add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ), 1 );
								add_filter( 'mce_buttons', array( $this, 'register_button' ), 1 );
							}
						}
					//}
				}
			}
		}

		public function add_tinymce_plugin( $plugin_array ) {
			$plugin_array['learndash_shortcodes_tinymce'] = LEARNDASH_LMS_PLUGIN_URL . 'assets/js/learndash-admin-shortcodes-tinymce' . leardash_min_asset() . '.js';

			return $plugin_array;
		}

		public function register_button( $buttons ) {
			array_push( $buttons, 'learndash_shortcodes_tinymce' );
			return $buttons;
		}

		public function load_admin_scripts() {
			global $typenow, $pagenow;
			global $learndash_assets_loaded;

			global $post;
			if ( ( $post ) && ( is_a( $post, 'WP_Post' ) ) && ( is_admin() ) && ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ) ) {
				//if ( ! use_block_editor_for_post( $post ) ) {
					if ( in_array( $typenow, apply_filters( 'learndash_shortcodes_tinymce_post_types', $this->post_types, $typenow ) ) ) {

						wp_enqueue_style(
							'learndash_admin_shortcodes_style',
							LEARNDASH_LMS_PLUGIN_URL . 'assets/css/learndash-admin-shortcodes' . leardash_min_asset() . '.css',
							array(),
							LEARNDASH_SCRIPT_VERSION_TOKEN
						);
						$learndash_assets_loaded['styles']['learndash_shortcodes_admin_style'] = __FUNCTION__;

						$learndash_admin_shortcodes_assets              = array();
						$learndash_admin_shortcodes_assets['post_id']   = $post->ID;
						$learndash_admin_shortcodes_assets['post_type'] = $post->post_type;
						$learndash_admin_shortcodes_assets['nonce']     = wp_create_nonce( 'learndash_admin_shortcodes_assets_nonce_' . get_current_user_id() . '_' . $post->post_type . '_' . $post->ID );

						wp_enqueue_script(
							'learndash_admin_shortcodes_script',
							LEARNDASH_LMS_PLUGIN_URL . 'assets/js/learndash-admin-shortcodes' . leardash_min_asset() . '.js',
							array( 'jquery' ),
							LEARNDASH_SCRIPT_VERSION_TOKEN,
							true
						);
						$learndash_assets_loaded['styles']['learndash_admin_shortcodes_script'] = __FUNCTION__;
						wp_localize_script( 'learndash_admin_shortcodes_script', 'learndash_admin_shortcodes_assets', $learndash_admin_shortcodes_assets );

						// Hold until after LD 3.0 release.
						//learndash_admin_settings_page_assets();
					}
				//}
			}
		}

		public function learndash_generate_shortcodes_content() {

			if ( ( ! isset( $_POST['atts'] ) ) || ( empty( $_POST['atts'] ) ) ) {
				die();
			}

			$fields_args = array(
				'post_type' => '',
				'post_id'   => 0,
				'nonce'     => '',
			);
			$fields_args = shortcode_atts( $fields_args, $_POST['atts'] );

			if ( ( ! isset( $fields_args['nonce'] ) ) || ( empty( $fields_args['nonce'] ) ) ) {
				die();
			}

			if ( ! wp_verify_nonce( $fields_args['nonce'], 'learndash_admin_shortcodes_assets_nonce_' . get_current_user_id() . '_' . $fields_args['post_type'] . '_' . $fields_args['post_id'] ) ) {
				die();
			}

			if ( ( ! empty( $fields_args['post_type'] ) ) && ( in_array( $fields_args['post_type'], apply_filters( 'learndash_shortcodes_tinymce_post_types', $this->post_types, $fields_args['post_type'] ) ) ) ) {

				$shortcode_sections = array();

				require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/class-ld-shortcodes-sections.php';

				if ( 'sfwd-certificates' !== $fields_args['post_type'] ) {

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_profile.php';
					$shortcode_sections['ld_profile'] = new LearnDash_Shortcodes_Section_ld_profile( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_course_list.php';
					$shortcode_sections['ld_course_list'] = new LearnDash_Shortcodes_Section_ld_course_list( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_lesson_list.php';
					$shortcode_sections['ld_lesson_list'] = new LearnDash_Shortcodes_Section_ld_lesson_list( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_topic_list.php';
					$shortcode_sections['ld_topic_list'] = new LearnDash_Shortcodes_Section_ld_topic_list( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_quiz_list.php';
					$shortcode_sections['ld_quiz_list'] = new LearnDash_Shortcodes_Section_ld_quiz_list( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/learndash_course_progress.php';
					$shortcode_sections['learndash_course_progress'] = new LearnDash_Shortcodes_Section_learndash_course_progress( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/visitor.php';
					$shortcode_sections['visitor'] = new LearnDash_Shortcodes_Section_visitor( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/student.php';
					$shortcode_sections['student'] = new LearnDash_Shortcodes_Section_student( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/course_complete.php';
					$shortcode_sections['course_complete'] = new LearnDash_Shortcodes_Section_course_complete( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/course_inprogress.php';
					$shortcode_sections['course_inprogress'] = new LearnDash_Shortcodes_Section_course_inprogress( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/course_notstarted.php';
					$shortcode_sections['course_notstarted'] = new LearnDash_Shortcodes_Section_course_notstarted( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_course_info.php';
					$shortcode_sections['ld_course_info'] = new LearnDash_Shortcodes_Section_ld_course_info( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_user_course_points.php';
					$shortcode_sections['ld_user_course_points'] = new LearnDash_Shortcodes_Section_ld_user_course_points( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/user_groups.php';
					$shortcode_sections['user_groups'] = new LearnDash_Shortcodes_Section_user_groups( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_group.php';
					$shortcode_sections['ld_group'] = new LearnDash_Shortcodes_Section_ld_group( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/learndash_payment_buttons.php';
					$shortcode_sections['learndash_payment_buttons'] = new LearnDash_Shortcodes_Section_learndash_payment_buttons( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/course_content.php';
					$shortcode_sections['course_content'] = new LearnDash_Shortcodes_Section_course_content( $fields_args );

					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_course_expire_status.php';
					$shortcode_sections['ld_course_expire_status'] = new LearnDash_Shortcodes_Section_ld_course_expire_status( $fields_args );

					if ( ( 'sfwd-lessons' === $fields_args['post_type'] ) || ( 'sfwd-topic' === $fields_args['post_type'] ) ) {
						require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/ld_video.php';
						$shortcode_sections['ld_video'] = new LearnDash_Shortcodes_Section_ld_video( $fields_args );
					}
				}

				require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/courseinfo.php';
				$shortcode_sections['courseinfo'] = new LearnDash_Shortcodes_Section_courseinfo( $fields_args );

				if ( 'sfwd-certificates' === $fields_args['post_type'] ) {
					require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/quizinfo.php';
					$shortcode_sections['quizinfo'] = new LearnDash_Shortcodes_Section_quizinfo( $fields_args );
				}

				require_once LEARNDASH_LMS_PLUGIN_DIR . '/includes/settings/shortcodes-sections/usermeta.php';
				$shortcode_sections['usermeta'] = new LearnDash_Shortcodes_Section_usermeta( $fields_args );

				$shortcode_sections = apply_filters( 'learndash_shortcodes_content_args', $shortcode_sections );

				?>
				<div id="learndash_shortcodes_wrap" class="wrap sfwd_options">
					<div id="learndash_shortcodes_tabs">
						<ul>
							<?php foreach ( $shortcode_sections as $section ) { ?>
							<li><a data-nav="<?php echo $section->get_shortcodes_section_key(); ?>" href="#"><?php echo $section->get_shortcodes_section_title(); ?></a></li>
							<?php } ?>
						</ul>
					</div>

					<div id="learndash_shortcodes_sections">
						<?php foreach ( $shortcode_sections as $section ) { ?>
							<div id="tabs-<?php echo $section->get_shortcodes_section_key(); ?>" class="hidable wrap" style="display: none;">
								<?php echo $section->show_section_fields(); ?>
							</div>
						<?php } ?>
					</div>
				</div>
					<?php
			}
			die();
		}

		// End of functions

	}
}

add_action(
	'plugins_loaded',
	function() {
		new LearnDash_Shortcodes_TinyMCE();
	}
);
