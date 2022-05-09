<?php
/**
 * Plugin Name: Hyperion Doctrine
 * Plugin URI:
 * Description: Intègre doctrine dans wordpress
 * Version: 0.1
 * Requires PHP: 8.1
 * Author: Benoit DELBOE & Grégory COLLIN
 * Author URI:
 * Licence: GPLv2
 */

add_action('init', '\Hyperion\Doctrine\Plugin::init');