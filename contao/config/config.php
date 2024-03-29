<?php

/*
 * This file is part of Webmail.
 *
 * (c) Andreas Steinkellner 2024 <andreas.steinkellner@privatconsult.com>
 * @license LGPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/webmail/contao-webmail
 */

use Webmail\ContaoWebmail\Model\WebmailModel;
use Webmail\ContaoWebmail\Module\ModuleWebmailList;

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
