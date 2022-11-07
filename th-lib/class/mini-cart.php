<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

if(!defined('ABSPATH')) return;

if(!class_exists('th_Mini_Cart'))
{
    class Th_Mini_Cart{

        private static $_instance = null;
   

        public static function _init() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function menu_cart_icon_bew( $fragments ) {
                
            
        }
    }

    th_Template::_init();
}