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

namespace MWerk\Webmail\Classes;

use Contao\Backend;
use Contao\BackendUser;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Database;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;

/**
 * DCA Helper Class DcaVisitors
 *
 * @copyright  Glen Langer 2023 <http://contao.ninja>
 */
class DcaWebmail extends Backend
{

	/**
	 * Return the "toggle visibility" button
	 * @param  array  $row
	 * @param  string $href
	 * @param  string $label
	 * @param  string $title
	 * @param  string $icon
	 * @param  string $attributes
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (\strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), Input::get('state') == 1);
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		$user = BackendUser::getInstance();
		if (!$user->isAdmin && !$user->hasAccess('tl_webmail::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.svg';
		}

		return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
	}

	/**
	 * Disable/enable a counter
	 * @param integer $intId
	 * @param boolean $blnVisible
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to publish
		$user = BackendUser::getInstance();
		if (!$user->isAdmin && !$user->hasAccess('tl_webmail::published', 'alexf'))
		{
			// System::getContainer()
			// 	->get('monolog.logger.contao')
			// 	->log(
			// 		LogLevel::ERROR,
			// 		'Not enough permissions to publish/unpublish Visitors ID "' . $intId . '"',
			// 		array('contao' => new ContaoContext('tl_visitors toggleVisibility', ContaoContext::ERROR))
			// 	);
			$this->monologLogger->logSystemLog('Not enough permissions to publish/unpublish Visitors ID "' . $intId . '"', 'tl_webmail toggleVisibility', ContaoContext::ERROR);

			$this->redirect('contao/main.php?act=error');
		}

		// Update database
		Database::getInstance()->prepare("UPDATE
                                               tl_webmail
                                           SET
                                               published='" . ($blnVisible ? 1 : '') . "'
                                           WHERE
                                               id=?")
								->execute($intId);
	}
}