<?php

declare(strict_types=1);

/*
 * This file is part of Webmail.
 *
 * (c) Andreas Steinkellner 2024 <andreas.steinkellner@privatconsult.com>
 * @license LGPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/webmail/contao-webmail
 */

use Webmail\ContaoWebmail\Controller\FrontendModule\WebmailListController;

/**
 * Backend modules
 */
$GLOBALS['TL_LANG']['MOD']['webmail'] = ['Webmail', 'Webmailverwaltung'];

/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['webmail'] = 'Webmail';
$GLOBALS['TL_LANG']['FMD'][WebmailListController::TYPE] = ['Webmails', 'Webmailliste'];

