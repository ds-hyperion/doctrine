<?php
/**
 * Plugin Name: Hyperion - Module Doctrine
 * Plugin URI:
 * Description: Intègre doctrine dans wordpress
 * Version: 0.1
 * Requires PHP: 8.1
 * Author: Benoit DELBOE & Grégory COLLIN
 * Author URI:
 * Licence: GPLv2
 */

register_activation_hook(__FILE__, '\Hyperion\Doctrine\Plugin::onActivation');
register_deactivation_hook(__FILE__, '\Hyperion\Doctrine\Plugin::onDeactivation');
add_action('init', '\Hyperion\Doctrine\Plugin::init');
add_action('cli_init', '\Hyperion\Doctrine\Plugin::addCLICommands');