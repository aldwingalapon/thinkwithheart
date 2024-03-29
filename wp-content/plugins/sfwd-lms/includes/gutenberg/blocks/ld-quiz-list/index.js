/**
 * LearnDash Block ld-quiz-list
 *
 * @since 2.5.9
 * @package LearnDash
 */

/**
 * LearnDash block functions
 */
import {
	ldlms_get_custom_label,
	ldlms_get_per_page,
} from '../ldlms.js';

/**
 * Internal block libraries
 */
const { __, _x, sprintf } = wp.i18n;
const {
	registerBlockType,
} = wp.blocks;

const {
	InspectorControls,
} = wp.editor;

const {
	ServerSideRender,
	PanelBody,
	RangeControl,
	SelectControl,
	ToggleControl,
	TextControl
} = wp.components;

registerBlockType(
	'learndash/ld-quiz-list',
	{
		title: sprintf(_x('LearnDash %s List', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz')),
		description: sprintf(_x('This block shows a list of %s.', 'placeholders: quizzes', 'learndash'), ldlms_get_custom_label('quizzes')),
		icon: 'list-view',
		category: 'learndash-blocks',
		attributes: {
			orderby: {
				type: 'string',
				default: 'ID'
			},
			order: {
				type: 'string',
				default: 'DESC'
			},
			per_page: {
				type: 'string',
				default: '',
			},
			course_id: {
				type: 'string',
				default: ''
			},
			show_content: {
				type: 'boolean',
				default: true
			},
			show_thumbnail: {
				type: 'boolean',
				default: true
			},
			quiz_category_name: {
				type: 'string',
				default: ''
			},
			quiz_cat: {
				type: 'string',
				default: ''
			},
			quiz_categoryselector: {
				type: 'boolean',
				default: false
			},
			quiz_tag: {
				type: 'string',
				default: ''
			},
			quiz_tag_id: {
				type: 'string',
				default: ''
			},
			category_name: {
				type: 'string',
				default: ''
			},
			cat: {
				type: 'string',
				default: ''
			},
			categoryselector: {
				type: 'boolean',
				default: false
			},
			tag: {
				type: 'string',
				default: ''
			},
			tag_id: {
				type: 'string',
				default: ''
			},
			course_grid: {
				type: 'boolean',
			},
			col: {
				type: 'string',
				default: (ldlms_settings['plugins']['learndash-course-grid']['enabled']['col_default'] || 3),
			},
			preview_show: {
				type: 'boolean',
				default: true
			},
		},
		edit: function (props) {
			const { attributes: { orderby, order, per_page, course_id, show_content, show_thumbnail, quiz_category_name, quiz_cat, quiz_categoryselector, quiz_tag, quiz_tag_id, category_name, cat, categoryselector, tag, tag_id, course_grid, col, preview_show },
				setAttributes } = props;

			let field_show_content = '';
			let field_show_thumbnail = '';
			let panel_quiz_grid_section = '';

			let course_grid_default = true;
			if (ldlms_settings['plugins']['learndash-course-grid']['enabled'] === true) {
				if ((typeof course_grid !== 'undefined') && ((course_grid == true) || (course_grid == false))) {
					course_grid_default = course_grid;
				}

				let quiz_grid_section_open = false;
				if (course_grid_default == true) {
					quiz_grid_section_open = true;
				}
				panel_quiz_grid_section = (
					<PanelBody
						title={__('Grid Settings', 'learndash')}
						initialOpen={quiz_grid_section_open}
					>
						<ToggleControl
							label={__('Show Grid', 'learndash')}
							checked={!!course_grid_default}
							onChange={course_grid => setAttributes({ course_grid })}
						/>
						<RangeControl
							label={__('Columns', 'learndash')}
							value={col || ldlms_settings['plugins']['learndash-course-grid']['enabled']['col_default']}
							min={1}
							max={ldlms_settings['plugins']['learndash-course-grid']['enabled']['col_max']}
							step={1}
							onChange={col => setAttributes({ col })}
						/>
					</PanelBody>
				);
			}

			field_show_content = (
				<ToggleControl
					label={__('Show Content', 'learndash')}
					checked={!!show_content}
					onChange={show_content => setAttributes({ show_content })}
				/>
			);

			field_show_thumbnail = (
				<ToggleControl
					label={__('Show Thumbnail', 'learndash')}
					checked={!!show_thumbnail}
					onChange={show_thumbnail => setAttributes({ show_thumbnail })}
				/>
			);

			const panelbody_header = (
				<PanelBody
					title={__('Settings', 'learndash')}
				>
					<TextControl
						label={sprintf(_x('%s ID', 'Course ID', 'learndash'), ldlms_get_custom_label('course'))}
						help={sprintf(_x('Enter single %1$s ID to limit listing. Leave blank if used within a %2$s.', 'placeholders: course, course', 'learndash'), ldlms_get_custom_label('course'), ldlms_get_custom_label('course'))}
						value={course_id || ''}
						onChange={course_id => setAttributes({ course_id })}
					/>

					<SelectControl
						key="orderby"
						label={__('Order by', 'learndash')}
						value={orderby}
						options={[
							{
								label: __('ID - Order by post id. (default)', 'learndash'),
								value: 'ID',
							},
							{
								label: __('Title - Order by post title', 'learndash'),
								value: 'title',
							},
							{
								label: __('Date - Order by post date', 'learndash'),
								value: 'date',
							},
							{
								label: __('Menu - Order by Page Order Value', 'learndash'),
								value: 'menu_order',
							}
						]}
						onChange={orderby => setAttributes({ orderby })}
					/>
					<SelectControl
						key="order"
						label={__('Order', 'learndash')}
						value={order}
						options={[
							{
								label: __('DESC - highest to lowest values (default)', 'learndash'),
								value: 'DESC',
							},
							{
								label: __('ASC - lowest to highest values', 'learndash'),
								value: 'ASC',
							},
						]}
						onChange={order => setAttributes({ order })}
					/>
					<TextControl
						label={sprintf(_x('%s per page', 'placeholder: Quizzess', 'learndash'), ldlms_get_custom_label('quizzes'))}
						help={sprintf(_x('Leave empty for default (%d) or 0 to show all items.', 'placeholder: default per page', 'learndash'), ldlms_get_per_page('per_page'))}
						value={per_page || ''}
						type={'number'}
						onChange={per_page => setAttributes({ per_page })}
					/>

					{field_show_content}
					{field_show_thumbnail}
				</PanelBody>
			);

			let panel_quiz_category_section = '';
			if (ldlms_settings['settings']['quizzes_taxonomies']['ld_quiz_category'] === 'yes') {
				let panel_quiz_category_section_open = false;
				if ((quiz_category_name != '') || (quiz_cat != '')) {
					panel_quiz_category_section_open = true;
				}
				panel_quiz_category_section = (
					<PanelBody
						title={sprintf(_x('%s Category Settings', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
						initialOpen={panel_quiz_category_section_open}
					>
						<TextControl
							label={sprintf(_x('%s Category Slug', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows %s with mentioned category slug.', 'placeholder: quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={quiz_category_name || ''}
							onChange={quiz_category_name => setAttributes({ quiz_category_name })}
						/>

						<TextControl
							label={sprintf(_x('%s Category ID', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows %s with mentioned category ID.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={quiz_cat || ''}
							onChange={quiz_cat => setAttributes({ quiz_cat })}
						/>
						<ToggleControl
							label={sprintf(_x('%s Category Selector', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows a %s category dropdown.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							checked={!!quiz_categoryselector}
							onChange={quiz_categoryselector => setAttributes({ quiz_categoryselector })}
						/>
					</PanelBody>
				);
			}

			let panel_quiz_tag_section = '';
			if (ldlms_settings['settings']['quizzes_taxonomies']['ld_quiz_tag'] === 'yes') {
				let panel_quiz_tag_section_open = false;
				if ((quiz_tag != '') || (quiz_tag_id != '')) {
					panel_quiz_tag_section_open = true;
				}
				panel_quiz_tag_section = (
					<PanelBody
						title={sprintf(_x('%s Tag Settings', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
						initialOpen={panel_quiz_tag_section_open}
					>
						<TextControl
							label={sprintf(_x('%s Tag Slug', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows %s with mentioned tag slug.', 'placeholder: quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={quiz_tag || ''}
							onChange={quiz_tag => setAttributes({ quiz_tag })}
						/>

						<TextControl
							label={sprintf(_x('%s Tag ID', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows %s with mentioned tag ID.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={quiz_tag_id || ''}
							onChange={quiz_tag_id => setAttributes({ quiz_tag_id })}
						/>
					</PanelBody>
				);
			}

			let panel_wp_category_section = '';
			if (ldlms_settings['settings']['quizzes_taxonomies']['wp_post_category'] === 'yes') {
				let panel_wp_category_section_open = false;
				if ((category_name != '') || (cat != '')) {
					panel_wp_category_section_open = true;
				}
				panel_wp_category_section = (
					<PanelBody
						title={__('WP Category Settings', 'learndash')}
						initialOpen={panel_wp_category_section_open}
					>
						<TextControl
							label={__('WP Category Slug', 'learndash')}
							help={sprintf(_x('shows %s with mentioned WP category slug.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={category_name || ''}
							onChange={category_name => setAttributes({ category_name })}
						/>

						<TextControl
							label={sprintf(_x('%s Category ID', 'placeholder: Quiz', 'learndash'), ldlms_get_custom_label('quiz'))}
							help={sprintf(_x('shows %s with mentioned category ID.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={cat || ''}
							onChange={cat => setAttributes({ cat })}
						/>
						<ToggleControl
							label={__('WP Category Selector', 'learndash')}
							help={__('shows a WP category dropdown.', 'learndash')}
							checked={!!categoryselector}
							onChange={categoryselector => setAttributes({ categoryselector })}
						/>
					</PanelBody>
				);
			}

			let panel_wp_tag_section = '';
			if (ldlms_settings['settings']['quizzes_taxonomies']['wp_post_tag'] === 'yes') {
				let panel_wp_tag_section_open = false;
				if ((tag != '') || (tag_id != '')) {
					panel_wp_tag_section_open = true;
				}
				panel_wp_tag_section = (
					<PanelBody
						title={__('WP Tag Settings', 'learndash')}
						initialOpen={panel_wp_tag_section_open}
					>
						<TextControl
							label={__('WP Tag Slug', 'learndash')}
							help={sprintf(_x('shows %s with mentioned WP tag slug.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={tag || ''}
							onChange={tag => setAttributes({ tag })}
						/>

						<TextControl
							label={__('WP Tag ID', 'learndash')}
							help={sprintf(_x('shows %s with mentioned WP tag ID.', 'placeholder: Quizzes', 'learndash'), ldlms_get_custom_label('quizzes'))}
							value={tag_id || ''}
							onChange={tag_id => setAttributes({ tag_id })}
						/>
					</PanelBody>
				);
			}

			const panel_preview = (
				<PanelBody
					title={__('Preview', 'learndash')}
					initialOpen={false}
				>
					<ToggleControl
						label={__('Show Preview', 'learndash')}
						checked={!!preview_show}
						onChange={preview_show => setAttributes({ preview_show })}
					/>
				</PanelBody>
			);

			const inspectorControls = (
				<InspectorControls>
					{panelbody_header}
					{panel_quiz_grid_section}
					{panel_quiz_category_section}
					{panel_quiz_tag_section}
					{panel_wp_category_section}
					{panel_wp_tag_section}
					{panel_preview}
				</InspectorControls>
			);

			function do_serverside_render(attributes) {
				if (attributes.preview_show == true) {
					return <ServerSideRender
						block="learndash/ld-quiz-list"
						attributes={attributes}
					/>
				} else {
					return __('[ld_quiz_list] shortcode output shown here', 'learndash');
				}
			}

			return [
				inspectorControls,
				do_serverside_render(props.attributes)
			];
		},

		save: props => {
		}
	},
);
