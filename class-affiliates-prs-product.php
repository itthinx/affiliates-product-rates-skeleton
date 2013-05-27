<?php
/**
 * class-affiliates-prs-product.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 * 
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-product-rates-skeleton
 * @since affiliates-product-rates-skeleton 1.0.0
 */

/**
 * Product CPT extension.
 */
class Affiliates_PRS_Product {

	/**
	 * Register own tab.
	 */
	public static function init() {
		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
			add_action( 'save_post', array( __CLASS__, 'save_post' ), 10, 2 );
		}
	}
	
	public static function add_meta_boxes( $post_type, $post ) {
		if ( $post_type == AFFILIATES_PRODUCT_RATES_SKELETON_PRODUCT_CPT ) {
			add_meta_box(
				'affiliates_rate_box',
				__( 'Affiliates Rate', GROUPS_NEWSLETTERS_PLUGIN_DOMAIN ),
				array( __CLASS__, 'affiliates_rate_box' ),
				'campaign',
				'normal'
			);
		}
	}

	/**
	 * Affiliates product rate meta box renderer.
	 */
	public static function affiliates_rate_box() {

		global $post;

		$rate = get_post_meta( $post->ID, '_affiliates_rate', true );

		_e( 'Referral Rate', 'affiliates-product-rate-skeleton' );
		echo ' ';
		printf(
			'<input type="text" name="_affiliates_rate" value=%s" title="%s" placeholder="%s" />',
			$rate,
			__( 'Product referral rate for affiliates.', 'affiliates-product-rate-skeleton' ),
			__( 'no rate applies', 'affiliates-product-rate-skeleton' )
		);

		echo '<div style="padding:1em">';
		echo __( 'Examples:', 'affiliates-product-rate-skeleton' ) . '<br/>';
		echo '<ul>';
		echo '<li>' . __( 'Indicate <strong>0.1</strong> for 10% commissions on this product.', 'affiliates-product-rate-skeleton' ) . '</li>';
		echo '<li>' . __( 'Indicate <strong>0</strong> to exclude this product from commissions.', 'affiliates-product-rate-skeleton' ) . '</li>';
		echo '<li>' . __( 'Leave empty if no product referral rate should be applied (default setting).', 'affiliates-product-rate-skeleton' ) . '</li>';
		echo '</ul>';
		echo '</div>';
	}

	/**
	 * Process data for post being saved.
	 * 
	 * @param int $post_id product post id
	 * @param object $post
	 */
	public static function save_post( $post_id = null, $post = null ) {
		if ( ! ( ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) ) ) {
			if ( $post->post_type == AFFILIATES_PRODUCT_RATES_SKELETON_PRODUCT_CPT ) {
				delete_post_meta( $post_id, '_affiliates_rate' );
				if ( strlen( trim( $_POST['_affiliates_rate'] ) ) > 0 ) {
					$rate = Affiliates_Attributes::validate_value( 'referral.rate', trim( $_POST['_affiliates_rate'] ) );
					if ( $rate !== false ) {
						add_post_meta( $post_id, '_affiliates_rate', $rate, true );
					}
				}
			}
		}
	}

	/**
	 * Retruns true if the product has an affiliate rate set.
	 * @param int $post_id product post id
	 * @return boolean true if product post has rate, otherwise false
	 */
	public static function has_rate( $post_id ) {
		$rate = get_post_meta( $post_id, '_affiliates_rate', true );
		return strlen( (string) $rate ) > 0;
	}

	/**
	 * Returns the product rate.
	 * @param int $post_id product post id
	 * @return string rate for product
	 */
	public static function get_rate( $post_id ) {
		$result = null;
		$rate = get_post_meta( $post_id, '_affiliates_rate', true );
		if ( strlen( (string) $rate ) > 0 ) {
			$result = $rate;
		}
		return $result;
	}

}
Affiliates_PRS_Product::init();
