<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Certification fields.
 *
 * @package    certificateelement_certify
 * @copyright  2023 Open LMS (https://www.openlms.net/)
 * @author     Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/** @var stdClass $plugin */

$plugin->version   = 2023080600;
$plugin->requires  = 2022112802.00; // 4.1.2 (Build: 20230313)
$plugin->component = 'certificateelement_certify';
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = 'v2.0+';
$plugin->supported = [401, 401];

$plugin->dependencies = ['tool_certify' => 2023080600, 'tool_certificate' => 2023042500];
