<?php
/**
 * affiliates-product-rates-skeleton.php
 * 
 * Copyright (c) 2013 "kento" Karim Rahimpur www.itthinx.com
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
 *
 * Plugin Name: Affiliates Product Rates Skeleton
 * Plugin URI: http://www.itthinx.com/plugins/affiliates-product-rates-skeleton/
 * Description: This is a skeleton plugin intended to serve as a basis to provide product rates for affiliate commissions. Without proper customization, it serves no other purpose on its own. This plugin is an extension to <a href="http://www.itthinx.com/plugins/affiliates-pro/">Affiliates Pro</a> and <a href="http://www.itthinx.com/plugins/affiliates-enterprise/">Affiliates Enterprise</a>.
 * Version: 1.0.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * License: GPLv3
 */

define( 'AFFILIATES_PRODUCT_RATES_SKELETON_PRODUCT_CPT', '' ); // @todo insert your product CPT here, e.g. 'product'
define( 'AFFILIATES_PRODUCT_RATES_SKELETON_DEFAULT_PRODUCT_RATE', '' ); // @todo insert your default rate here, e.g. '0.10' for 10% default rates
define( 'AFFILIATES_PRODUCT_RATES_SKELETON_REFERENCE', 'reference' ); // @todo the referral field in which the order reference is passed, usually 'reference' or 'post_id' 
if ( is_admin() ) {
	require_once( 'class-affiliates-prs-product.php' );
}
require_once 'class-affiliates-prs-method.php';
