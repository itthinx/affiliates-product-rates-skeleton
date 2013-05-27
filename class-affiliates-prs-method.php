<?php
/**
 * class-affiliates-prs-method.php
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
 * Product method.
 */
class Affiliates_PRS_Method {

	/**
	 * Register referral method.
	 */
	public static function init() {
		if ( method_exists( 'Affiliates_Referral', 'register_referral_amount_method' ) ) {
			Affiliates_Referral::register_referral_amount_method( array( __CLASS__, 'product_rates' ) );
		}
	}

	/**
	 * Product rates method.
	 */
	public static function product_rates( $affiliate_id, $parameters ) {
		$result = '0';
		if ( isset( $parameters[AFFILIATES_PRODUCT_RATES_SKELETON_REFERENCE] ) ) {
			$result = self::calculate( intval( $parameters[AFFILIATES_PRODUCT_RATES_SKELETON_REFERENCE] ) );
		} else if ( isset( $parameters['base_amount'] ) ) {
			$default_rate = AFFILIATES_PRODUCT_RATES_SKELETON_DEFAULT_PRODUCT_RATE;
			$result = bcmul( $parameters['base_amount'], $default_rate, AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
		} else  if ( isset( $parameters['amount'] ) ) {
			$result = $parameters['amount'];
		}
		return $result;
	}
	
	/**
	 * @todo implement
	 * 
	 * @param int $order_id
	 * @return array of order items
	 */
	public static function get_order_items( $order_id ) {
		return array();
	}
	
	/**
	 * @todo implement
	 * 
	 * @param mixed $item
	 * @param int $order_id
	 * @return object product post
	 */
	public static function get_product_from_item( $item, $order_id = null ) {
		return null;
	}

	/**
	 * @todo implement
	 * 
	 * @param mixed $item
	 * @param int $product_id
	 * @param int $order_id
	 * @return int|float|string net item subtotal (based on item quantity and net price, i.e. after discounts, before tax, no shipping)
	 */
	public static function get_product_subtotal( $item, $product_id, $order_id ) {
		return 0;
	} 

	/**
	 * Calculates the total product commission for an order.
	 * @param int $order_id
	 * @return string total commission amount
	 */
	public static function calculate( $order_id ) {
		$total_commission = '0';
		$items = self::get_order_items( $order_id );
		if ( count( $items )  > 0 ) {
			$default_rate = AFFILIATES_PRODUCT_RATES_SKELETON_DEFAULT_PRODUCT_RATE;
			foreach( $items as $order_item_id => $item ) {
				if ( $product = self::get_product_from_item( $item ) ) {
					$product_id = $product->ID;
					$rate = get_post_meta( $product_id, '_affiliates_rate', true );
					if ( strlen( (string) $rate ) == 0 ) {
						$rate = $default_rate;
					}
					if ( strlen( (string) $rate ) > 0 ) {
						// get the net line item total and calculate the commission
						$product_subtotal = self::get_product_subtotal( $item, $product_id, $order_id );
						if ( $product_subtotal > 0 ) {
							$commission       = bcmul( $product_subtotal, $rate, AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
							// add to total commission
							$total_commission = bcadd( $total_commission, $commission, AFFILIATES_REFERRAL_AMOUNT_DECIMALS );
						}
					}
				}
			}
		}
		return $total_commission;
	}
}
Affiliates_PRS_Method::init();
