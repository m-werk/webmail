<?php

declare(strict_types=1);

/*
 * This file is part of Webmail.
 *
 * (c) Andreas Steinkellner 2024 <a-steinkellner@outlook.com>
 * @license LGPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/m-werk/webmail
 */

use MWerk\Webmail\Controller\FrontendModule\WebmailListController;
use Contao\Controller;

/**
 * Frontend modules
 */
$GLOBALS['TL_DCA']['tl_module']['palettes'][WebmailListController::TYPE] = '{title_legend},name,headline,type,webmail_template;{config_legend},perPage';

$GLOBALS['TL_DCA']['tl_module']['fields']['webmail_template'] = array
(
	'inputType'	=> 'select',
	'options_callback' => static function () {
		return Controller::getTemplateGroup('mod_webmail_list_');
	},
	'eval'	=> array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'	=> "varchar(64) COLLATE ascii_bin NOT NULL default ''"
);