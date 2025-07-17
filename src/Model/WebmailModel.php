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

namespace MWerk\Webmail\Model;

use Contao\Model;

class WebmailModel extends Model
{
    protected static $strTable = 'tl_webmail';
	
	public static function findAllByPublished($offset, $limit, $compliance)
	{	
		$t = static::$strTable;
		if ($compliance != 0)
		{	
			$arrColumns = array("$t.published=? AND $t.compliance=$compliance");
		} else {
			$arrColumns = array("$t.published=?");
		}
		$arrOptions = array('order' => "$t.date desc", 'offset' => $offset, 'limit' => $limit);

		return static::findBy($arrColumns, 1, $arrOptions);
	}
}
