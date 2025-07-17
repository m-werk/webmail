<?php

/*
 * This file is part of Webmail.
 *
 * (c) Andreas Steinkellner 2024 <a-steinkellner@outlook.com>
 * @license LGPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/m-werk/webmail
 */

use MWerk\Webmail\Model\WebmailModel;
use MWerk\Webmail\Module\ModuleWebmailList;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['content']['webmail'] = array(
    'tables' => array('tl_webmail')
);

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['webmail']['webmail_list'] = ModuleWebmailList::class;

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_webmail'] = WebmailModel::class;
