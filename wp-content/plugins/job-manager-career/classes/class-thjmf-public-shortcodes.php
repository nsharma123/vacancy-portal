<?php
/**
 * The file that defines the post types of plugin.
 *
 * @link       https://themehigh.com
 * @since      1.0.0
 *
 * @package    job-manager-career
 * @subpackage job-manager-career/includes
 */
if(!defined('WPINC')){	die; }

if(!class_exists('THJMF_Public_Shortcodes')):

	class THJMF_Public_Shortcodes extends THJMF_Public{
		public function __construct() {
			add_action( 'wp', array( $this, 'prepare_reset_actions') );
		}

		public function shortcode_thjmf_job_listing($atts){
			if( isset( $_POST['thjmf_job_filter'] ) || isset( $_POST['thjmf_filter_load_more'] ) ){
				$this->thjmf_jobs_filter_event(true);
				return;
			}

			global $wp_query,$post;
			$settings = THJMF_Utils::get_default_settings();
			$content_args = [];
			$query_args = [];
			$query_args['hide_expired'] = isset( $settings['job_detail']['job_hide_expired'] ) ? $settings['job_detail']['job_hide_expired'] : false;
			$query_args['hide_filled'] = isset( $settings['job_detail']['job_hide_filled'] ) ? $settings['job_detail']['job_hide_filled'] : false;

			$per_page = get_option( 'posts_per_page' );
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$query_args['posts_per_page'] = (int) $per_page*$paged;
			$args = $this->get_query_args( $query_args );
			
			$loop = new WP_Query( $args );
			if( ! $loop->have_posts() ) {
			   return false;
			}
			$content_args['thjmf_max_page'] = $this->max_num_pages($per_page, $loop->found_posts);
			$content_args['pagenum_link_url'] = html_entity_decode( get_pagenum_link() );
			$content_args['pagenum_link'] = $content_args['pagenum_link_url'].'page/'.($paged+1).'/';

			ob_start();
			$this->render_page_listing_content($loop, $content_args, $paged);
			wp_reset_postdata();
			return ob_get_clean();
		}

		private function render_page_listing_content($loop, $content_args, $paged, $filter=false, $filter_load_more = false){
			$pagenum_link = isset( $content_args['pagenum_link'] ) ? $content_args['pagenum_link'] : "";
			?>
			<div id="thjmf-job-listings-box">
				<?php $this->render_post_filter_section( $filter, $content_args ); ?>
				<form name="thjmf_load_more_post" method="POST" action="<?php echo esc_attr( $pagenum_link );?>">
					<?php if($filter){
						echo $this->render_form_requirements( $content_args ); 
					} ?>
					<div class="thjmf-job-listings">
						<?php
						while( $loop->have_posts() ) {
						    $loop->the_post();
						    $meta_args = $this->prepare_loop_settings();
						    $this->render_post_type_list( $meta_args );
						} ?>
					</div>
					<div class="thjmf-load-more-section">
						<?php $this->render_load_more_pagination($content_args, $paged); ?>
					</div>
				</form>
			</div>
			<?php
		}

		private function get_query_args( $q_args, $filter=false){
			$posts_per_page = isset( $q_args['posts_per_page'] ) ? $q_args['posts_per_page'] : false;
			$args = array (
				'posts_per_page'    => $posts_per_page,
				'post_date'			=> 'DESC',
				'post_type'         => THJMF_Utils::get_job_cpt(),
			);

			if( $filter ){
				$category = isset( $q_args['category'] ) ? $q_args['category'] : false;
				$location = isset( $q_args['location'] ) ? $q_args['location'] : false;
				$type = isset( $q_args['type'] ) ? $q_args['type'] : false;
				if( $category && $location || $category && $type || $location && $type){
					$args['tax_query'] = array( 'relation'=>'AND' );
				}
			
				if($category){
					$args['tax_query'][] = array(
						'taxonomy' => 'thjm_job_category',
						'field' => 'slug',
						'terms' => $category
					);
				}
				if($location){
					$args['tax_query'][] = array(
						'taxonomy' => 'thjm_job_locations',
						'field' => 'slug',
						'terms' => $location
					);
				}
				if($type){
					$args['tax_query'][] = array(
						'taxonomy' => 'thjm_job_type',
						'field' => 'slug',
						'terms' => $type
					);
				}
			}
			$hide_filled = isset( $q_args['hide_filled'] ) ? $q_args['hide_filled'] : false;
			$hide_expired = isset( $q_args['hide_expired'] ) ? $q_args['hide_expired'] : false;

			if($hide_filled && $hide_expired){
				$args['meta_query'] = array( 'relation'=>'AND' );
			}

			if( $hide_filled == '1'){
	    		$args['meta_query'][] = array(
					'key'       => THJMF_Utils::get_filled_meta_key(),
				    'value'   	=> '',
				    'compare' 	=> '=',
				);
			}

			if( $hide_expired == '1'){
	    		$args['meta_query'][] = array(
	    			'relation'	=> 'OR',
	    			array(
						'key'       => THJMF_Utils::get_expired_meta_key(),
					    'value'   	=> '',
					    'compare' 	=> '=',
					),
					array(
					    'key' => THJMF_Utils::get_expired_meta_key(), // Check the start date field
		                'value' => date('Y-m-d'), // Set today's date (note the similar format)
		                'compare' => '>=', // Return the ones greater than today's date
		                'type' => 'DATE' // Let WordPress know we're working with date
					),
	    		);
			}
			return $args;
		}

		private function prepare_loop_settings(){
			$args = [];
			$args = THJMF_Utils::get_post_meta_requirements( get_the_ID() );
			return $args;
		}

		private function render_load_more_pagination($args, $paged, $filter_l_m=false){
			if( (int) $args['thjmf_max_page'] != $paged){
	       		?>
	       		<div class="thjmf-load-more-button-wrapper">
	       			<button type="submit" name="<?php echo $filter_l_m ? "thjmf_filter_load_more" : "thjmf_load_more" ?>" id="thjmf_load_more"> <?php echo __('Load more', 'job-manager-career'); ?></button>
	       		</div>
	       		<?php
	       }
		}

		public function thjmf_jobs_filter_event( $filter_load_more = false){
			$per_page = get_option( 'posts_per_page' );
			$settings = THJMF_Utils::get_default_settings();
			$settings = THJMF_Utils::get_default_settings();
			$q_args = [];

			$q_args['hide_expired'] = isset( $settings['job_detail']['job_hide_expired'] ) ? $settings['job_detail']['job_hide_expired'] : false;
			$q_args['hide_filled'] = isset( $settings['job_detail']['job_hide_filled'] ) ? $settings['job_detail']['job_hide_filled'] : false;
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
			$q_args['posts_per_page'] = (int) $per_page*$paged;
			
			$category = isset( $_POST['thjmf_filter_category'] ) && !empty( $_POST['thjmf_filter_category'] ) ? sanitize_key($_POST['thjmf_filter_category']) : false;
			$location = isset( $_POST['thjmf_filter_location'] ) && !empty( $_POST['thjmf_filter_location'] ) ? sanitize_key($_POST['thjmf_filter_location']) : false;
			$type = isset( $_POST['thjmf_filter_type'] ) && !empty( $_POST['thjmf_filter_type'] ) ? sanitize_key($_POST['thjmf_filter_type']) : false;

			if($category){
				$q_args['category'] = $category;
			}
			if($location){
				$q_args['location'] = $location;
			}
			if($type){
				$q_args['type'] = $type;
			}
			$filter_args = $this->get_query_args( $q_args, true );
			
			$filter_query = new WP_Query( $filter_args );
			if( ! $filter_query->have_posts() ) {
				?>
				<div id="thjmf-job-listings-box">
					<?php 
						$this->render_post_filter_section(true, $q_args); 
						$this->render_no_jobs();
					?>
			  	</div>
			  	<?php
			   return false;
			}
			
			$q_args['thjmf_max_page'] = $this->max_num_pages($per_page, $filter_query->found_posts);
			$q_args['pagenum_link_url'] = html_entity_decode( get_pagenum_link() );
			$q_args['pagenum_link'] = $q_args['pagenum_link_url'].'page/'.($paged+1).'/';
			$this->render_page_listing_content($filter_query, $q_args, $paged, true, $filter_load_more);
			return;
		}

		public function render_no_jobs(){
			?>
			<div class="thjmf-no-jobs">
				<p><?php echo __('No jobs found . . .'); ?></p>
			</div>
			<?php
		}

		public function render_form_requirements($arr){
			$ref_arr = array('location', 'category', 'type');
			$fields = '';
			foreach ($arr as $key => $value) {
				if( $value && in_array($key, $ref_arr) ){
					$fields .= '<input type="hidden" name="thjmf_filter_'.esc_attr( $key ).'" value="'.esc_html( $value ).'">';
				}
			}
			return $fields;
		}

		public function render_post_type_list( $meta_args ){
			$featured_job = isset( $meta_args['featured'] ) ? $meta_args['featured'] : false;
			?>
			<div class="thjmf-job-listings-list thjmf-listing-loop-content list-wrapper">
				<table class="thjmf-listing-solo-table" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr class="thjmf-listing-header">
							<td colspan="2">
								<div class="thjmf-listing-title" style="overflow: hidden;">
									<?php $this->render_post_title( false, $featured_job ); ?>
								</div>
								<?php $this->render_post_tags(); ?>
							</td>
						</tr>
						<tr class="thjmf-listing-body">
							<td class="thjmf-job-single-excerpt">
								<div class="thjmf-listing-single-content">
									<?php the_excerpt();?>
								</div>
							</td>
							<td class="thjmf-job-single-more">
								<button type="button"><a href="<?php echo esc_url(the_permalink()); ?>">
									<?php echo apply_filters('thjmf_job_details_button', __('Details', 'job-manager-career') ); ?></a>
								</button>
							</td>
						</tr>
					</thead>
				</table>
			</div>
			<?php
		}

		public function render_post_title($link=true, $featured_job = false){
			$link = apply_filters( 'thjmf_shortcode_post_title_link', $link );
			?>
				<h3>
					<?php if($link){ ?>
					<a href="<?php echo esc_url(the_permalink()); ?>"><?php echo esc_html( the_title() ) ?></a>
				<?php }else{
					echo esc_html( the_title() );
				} ?>
				</h3>
				<?php if( $featured_job ){ ?>
					<div class="thjmf-featured-post">
						<img class="thjm-featured-icon" src="<?php echo THJMF_ASSETS_URL.'images/bookmark.svg';?>" title="Featured Job">
					</div>
				<?php }?>
			<?php
		}

		public function render_post_filter_section( $filter=false, $props = false){
			$ft_url = isset( $props['pagenum_link_url'] ) ? $props['pagenum_link_url'] : "";
			$loc_flag = $type_flag = $cat_flag = false;
			$settings = THJMF_Utils::get_default_settings();
			if( isset( $settings['search_and_filt'] ) ){
				$settings = $settings['search_and_filt'];
				$loc_flag = isset( $settings['search_location'] ) ? $settings['search_location'] : false;
				$type_flag = isset( $settings['search_type'] ) ? $settings['search_type'] : false;
				$cat_flag = isset( $settings['search_category'] ) ? $settings['search_category'] : false;
			}
			$loc_val = isset( $props['location'] ) ? $props['location'] : false;
			$cat_val = isset( $props['category'] ) ? $props['category'] : false;
			$type_val = isset( $props['type'] ) ? $props['type'] : false;
			$location = THJMF_Utils::get_all_post_terms('location');
			$category = THJMF_Utils::get_all_post_terms('category');
			$job_type = THJMF_Utils::get_all_post_terms('job_type');
			
			if($loc_flag || $cat_flag || $type_flag):
			?>
				<div id="thjmf_ajax_load_modal"></div>
				<div class="thjmf-job-listing-filter-wrapper">
					<form id="thjmf_job_filter_form" name="thjmf_job_filter_form" method="POST" action="<?php echo $ft_url ? esc_attr( $ft_url ) : '';?>">
						<div class="thjmf-search-filters">
							<?php if($loc_flag) : ?>
								<div class="thjmf-job-filters">
									<select name="thjmf_filter_location">
										<option value=""><?php echo __('Select Location', 'job-manager-career'); ?></option>
										<?php
										foreach ( $location as $loc_key => $loc_value) {
											echo '<option value="'.esc_attr( $loc_value->slug ).'" '.($loc_val && $loc_val == $loc_value->slug  ? "selected" : "").'>'.esc_html( $loc_value->name ).'</option>';
										}
										?>
									</select>
								</div>
							<?php endif;
							if($cat_flag) : ?>
								<div class="thjmf-job-filters">
									<select name="thjmf_filter_category">
										<option value=""> <?php echo __('Select Category', 'job-manager-career'); ?></option>
										<?php
										foreach ( $category as $cat_key => $cat_value) {
											echo '<option value="'.esc_attr( $cat_value->slug ).'"'.($cat_val && $cat_val == $cat_value->slug ? "selected" : "").'>'.esc_html( $cat_value->name ).'</option>';
										}
										?>
									</select>
								</div>
							<?php endif; 
							if($type_flag) : ?>
								<div class="thjmf-job-filters">
									<select name="thjmf_filter_type">
										<option value=""> <?php echo __('Select Job Type', 'job-manager-career'); ?></option>
										<?php
										foreach ( $job_type as $job_index => $job_value ) {
											echo '<option value="'.esc_attr( $job_value->slug ).'"'.($type_val && $type_val == $job_value->slug ? "selected" : "").'>'.esc_html( $job_value->name ).'</option>';
										}
										?>
									</select>
								</div>
							<?php endif; ?>
						</div>
						<?php if($loc_flag || $cat_flag || $type_flag): ?>
							<div class="thjmf-search-button">
								<button type="submit" class="thjmf-job-filters-button" id="thjmf_job_filter_reset" name="thjmf_job_filter_reset"><?php echo __('Reset', 'job-manager-career'); ?></button>
								<button type="submit" class="thjmf-job-filters-button" id="thjmf_job_filter" name="thjmf_job_filter" onclick="thjmfFilterJobsEvent(this)"><?php echo __('Filter', 'job-manager-career'); ?></button>
							</div>
						<?php endif; ?>
					</form>
				</div>
				<?php
			endif;
		}

		public function prepare_reset_actions(){
			global $post;
			if( !isset( $_POST['thjmf_job_filter'] ) && isset( $_POST['thjmf_job_filter_reset'] ) && has_shortcode( $post->post_content, THJMF_Utils::$shortcode) ){
				global $wp;
				wp_safe_redirect( home_url( $wp->request ) );
			}
		}
	}
	
endif;