<?php
/**
 * Collection of a base classes for a custom WordPress plugins
 * 
 * @author Alexey Golubnichenko <profosbox@gmail.com>
 * @license GPLv2
 * @link https://github.com/AGolubnichenko/agp-core
 * @package AGPCore
 * @version 1.0.6
 */

/*  Copyright 2015  Alexey Golubnichenko  (email : profosbox@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

use Webcodin\WCPContactForm\Core\Agp_Autoloader;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Autoloader
 */
if (!class_exists('Webcodin\WCPContactForm\Core\Agp_Autoloader')) {
    require_once __DIR__ . '/classes/Agp_Autoloader.class.php';
    Agp_Autoloader::instance();    
}
