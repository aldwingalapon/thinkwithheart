<?php
/**
 * LearnDash Data Upgrades for Course Access List
 *
 * @package LearnDash
 * @subpackage Data Upgrades
 */

if ( ( class_exists( 'Learndash_Admin_Data_Upgrades' ) ) && ( ! class_exists( 'Learndash_Admin_Data_Upgrades_Course_Access_List' ) ) ) {

	/**
	 * Class to create the Data Upgrade for Course Access List.
	 */
	class Learndash_Admin_Data_Upgrades_Course_Access_List extends Learndash_Admin_Data_Upgrades {

		/**
		 * Protected constructor for class
		 */
		protected function __construct() {
			$this->data_slug = 'course-access-lists';
			parent::__construct();
			parent::register_upgrade_action();
		}

		/**
		 * Show data upgrade row for this instance.
		 *
		 * @since 2.3
		 */
		public function show_upgrade_action() {
			?>
			<tr id="learndash-data-upgrades-container-<?php echo $this->data_slug; ?>" class="learndash-data-upgrades-container">
				<td class="learndash-data-upgrades-button-container">
					<button class="learndash-data-upgrades-button button button-primary" data-nonce="<?php echo wp_create_nonce( 'learndash-data-upgrades-' . $this->data_slug . '-' . get_current_user_id() ); ?>" data-slug="<?php echo $this->data_slug; ?>">
					<?php
						esc_html_e( 'Upgrade', 'learndash' );
					?>
					</button>
				</td>
				<td class="learndash-data-upgrades-status-container">
					<span class="learndash-data-upgrades-name">
					<?php
					printf(
						// translators: placeholder: Course.
						esc_html_x( 'Upgrade %s Meta', 'placeholder: Course', 'learndash' ), LearnDash_Custom_Label::get_label( 'course' )
					);
					?>
					</span>
					<p>
					<?php
						printf(
							// translators: placeholder: course.
							esc_html_x( 'This upgrade will upgrade the %s meta elements. (Optional)', 'placeholder: course', 'learndash' ), learndash_get_custom_label_lower( 'course' )
						);
					?>
					</p>
					<p class="description"><?php echo $this->get_last_run_info(); ?></p>	
						
					<?php
					$show_progess = false;
					$this->transient_key = $this->data_slug;
					$this->transient_data = $this->get_transient( $this->transient_key );
					if ( ! empty( $this->transient_data ) ) {
						if ( isset( $this->transient_data['result_count'] ) ) {
							$this->transient_data['result_count'] = intval( $this->transient_data['result_count'] );
						} else {
							$this->transient_data['result_count'] = 0;
						}
						if ( isset( $this->transient_data['total_count'] ) ) {
							$this->transient_data['total_count'] = intval( $this->transient_data['total_count'] );
						} else {
							$this->transient_data['total_count'] = 0;
						}

						if ( ( ! empty( $this->transient_data['result_count'] ) ) && ( ! empty( $this->transient_data['total_count'] ) ) && ( $this->transient_data['result_count'] != $this->transient_data['total_count'] ) ) {

							$show_progess = true;
							?>
							<p id="learndash-data-upgrades-continue-<?php echo $this->data_slug; ?>" class="learndash-data-upgrades-continue"><input type="checkbox" name="learndash-data-upgrades-continue" value="1" /> <?php esc_html_e( 'Continue previous upgrade processing?', 'learndash' ); ?></p>
							<?php
						}
					}

					$progress_style       = 'display:none;';
					$progress_meter_style = '';
					$progress_label       = '';
					$progress_slug        = '';

					if ( true === $show_progess ) {
						$progress_style = '';
						$data = $this->transient_data;
						$data = $this->build_progress_output( $data );
						if ( ( isset( $data['progress_percent'] ) ) && ( ! empty( $data['progress_percent'] ) ) ) {
							$progress_meter_style = 'width: ' . $data['progress_percent'] . '%';
						}

						if ( ( isset( $data['progress_label'] ) ) && ( ! empty( $data['progress_label'] ) ) ) {
							$progress_label = $data['progress_label'];
						}

						if ( ( isset( $data['progress_slug'] ) ) && ( ! empty( $data['progress_slug'] ) ) ) {
							$progress_slug = 'progress-label-' . $data['progress_slug'];
						}
					}
					?>
					<div style="<?php echo esc_attr( $progress_style ); ?>" class="meter learndash-data-upgrades-status">
						<div class="progress-meter">
							<span class="progress-meter-image" style="<?php echo esc_attr( $progress_meter_style ); ?>"></span>
						</div>
						<div class="progress-label <?php echo esc_attr( $progress_slug ); ?>"><?php echo esc_attr( $progress_label ); ?></div>
					</div>
				</td>
			</tr>
			<?php
		}

		/**
		 * Class method for the AJAX update logic
		 * This function will determine what users need to be converted. Then the course and quiz functions
		 * will be called to convert each individual user data set.
		 *
		 * @since 2.3
		 *
		 * @param  array $data Post data from AJAX call.
		 * @return array $data Post data from AJAX call
		 */
		public function process_upgrade_action( $data = array() ) {
			global $wpdb;

			$this->init_process_times();

			if ( ( isset( $data['nonce'] ) ) && ( ! empty( $data['nonce'] ) ) ) {
				if ( ( wp_verify_nonce( $data['nonce'], 'learndash-data-upgrades-' . $this->data_slug . '-' . get_current_user_id() ) ) && ( current_user_can( LEARNDASH_ADMIN_CAPABILITY_CHECK ) ) ) {
					$this->transient_key = $this->data_slug;

					if ( ( isset( $data['init'] ) ) && ( true == $data['init'] ) ) {
						unset( $data['init'] );

						if ( ( ! isset( $data['continue'] ) ) || ( 'true' != $data['continue'] ) ) {
							/**
							 * Transient_data is used to store the local server state information and will
							 * saved in a transient type options variable.
							 */
							$this->transient_data = array();
							// Hold the number of completed/processed items.
							$this->transient_data['result_count']     = 0;
							$this->transient_data['current_course']   = array();
							$this->transient_data['progress_started'] = time();
							$this->transient_data['progress_user']    = get_current_user_id();

							$this->query_items();
						} else {
							$this->transient_data = $this->get_transient( $this->transient_key );
						}

						$this->set_transient( $this->transient_key, $this->transient_data );
					} else {
						$this->transient_data = $this->get_transient( $this->transient_key );
						if ( ( ! isset( $this->transient_data['process_courses'] ) ) || ( empty( $this->transient_data['process_courses'] ) ) ) {
							$this->query_items();
						}

						if ( ( isset( $this->transient_data['process_courses'] ) ) && ( ! empty( $this->transient_data['process_courses'] ) ) ) {
							foreach ( $this->transient_data['process_courses'] as $course_idx => $course_id ) {
								$course_id = intval( $course_id );
								if ( ( ! isset( $this->transient_data['current_course']['course_id'] ) ) || ( $this->transient_data['current_course']['course_id'] !== $course_id ) ) {
									$this->transient_data['current_course'] = array(
										'course_id' => $course_id,
										'item_idx'  => 0,
									);
								}

								$course_complete = $this->convert_course_access_list( intval( $course_id ) );
								if ( true === $course_complete ) {
									$this->transient_data['current_course'] = array();
									unset( $this->transient_data['process_courses'][ $course_idx ] );
									$this->transient_data['result_count'] = (int) $this->transient_data['result_count'] + 1;

								}

								$this->set_transient( $this->transient_key, $this->transient_data );

								if ( $this->out_of_timer() ) {
									break;
								}
							}
						}
					}
				}
			}

			$data = $this->build_progress_output( $data );

			// If we are at 100% then we update the internal data settings so other parts of LD know the upgrade has been run.
			if ( ( isset( $data['progress_percent'] ) ) && ( 100 == $data['progress_percent'] ) ) {

				$this->set_last_run_info( $data );
				$data['last_run_info'] = $this->get_last_run_info();

				$this->remove_transient( $this->transient_key );
			}

			return $data;
		}

		/**
		 * Common function to query needed items.
		 *
		 * @since 2.6.0
		 *
		 * @param boolean $increment_paged default true to increment paged.
		 */
		private function query_items( $increment_paged = true ) {
			// Initialize or increment the current paged or items.
			if ( ! isset( $this->transient_data['paged'] ) ) {
				$this->transient_data['paged'] = 1;
			} else {
				if ( true === $increment_paged ) {
					$this->transient_data['paged'] = (int) $this->transient_data['paged'] + 1;
				}
			}

			$this->transient_data['query_args'] = array(
				'post_type'      => 'sfwd-courses',
				'post_status'    => 'any',
				'fields'         => 'ids',
				'posts_per_page' => LEARNDASH_LMS_DEFAULT_DATA_UPGRADE_BATCH_SIZE,
				'paged'          => $this->transient_data['paged'],
			);
			$this->transient_data['query_args'] = apply_filters( 'learndash_data_upgrade_query', $this->transient_data['query_args'], $this->data_slug );
			$courses_query = new WP_Query( $this->transient_data['query_args'] );
			if ( is_a( $courses_query, 'WP_Query' ) ) {
				$this->transient_data['total_count'] = intval( $courses_query->found_posts );
				$this->transient_data['process_courses'] = $courses_query->posts;
			}
		}

		/**
		 * Common function to build the returned data progress output.
		 *
		 * @since 2.6.0
		 *
		 * @param array $data Array of existing data elements.
		 * @return array or data.
		 */
		private function build_progress_output( $data = array() ) {
			if ( isset( $this->transient_data['result_count'] ) ) {
				$data['result_count'] = intval( $this->transient_data['result_count'] );
			} else {
				$data['result_count'] = 0;
			}

			if ( isset( $this->transient_data['total_count'] ) ) {
				$data['total_count'] = intval( $this->transient_data['total_count'] );
			} else {
				$data['total_count'] = 0;
			}

			if ( ! empty( $data['total_count'] ) ) {
				$data['progress_percent'] = ( $data['result_count'] / $data['total_count'] ) * 100;
			} else {
				$data['progress_percent'] = 0;
			}

			if ( 100 == $data['progress_percent'] ) {
				$progress_status = __( 'Complete', 'learndash' );
				$data['progress_slug'] = 'complete';
			} else {
				if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
					$progress_status = __( 'In Progress', 'learndash' );
					$data['progress_slug'] = 'in-progress';
				} else {
					$progress_status = __( 'Incomplete', 'learndash' );
					$data['progress_slug'] = 'in-complete';
				}
			}

			$data['progress_label'] = sprintf(
				// translators: placeholders: result count, total count.
				esc_html_x( '%1$s: %2$d of %3$d Courses', 'placeholders: progress status, result count, total count', 'learndash' ), $progress_status, $data['result_count'], $data['total_count']
			);

			return $data;
		}

		/**
		 * Convert single course access list.
		 *
		 * @since 2.3
		 *
		 * @param int $course_id Course ID of post to convert.
		 * @return boolean true if complete, false if not.
		 */
		private function convert_course_access_list( $course_id = 0 ) {

			$course_access_list = learndash_get_setting( $course_id, 'course_access_list' );
			update_post_meta( $course_id, 'course_access_list', learndash_convert_course_access_list( $course_access_list ) );

			return true;
		}

		// End of functions.
	}
}

add_action( 'learndash_data_upgrades_init', function() {
	Learndash_Admin_Data_Upgrades_Course_Access_List::add_instance();
} );
