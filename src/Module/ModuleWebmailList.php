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

namespace Webmail\ContaoWebmail\Module;

use Contao\Module;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Contao\BackendTemplate;
use Webmail\ContaoWebmail\Model\WebmailModel;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\StringUtil;
use Contao\FrontendTemplate;

class ModuleWebmailList extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_webmail_list_all';

	public function generate()
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
 
			$objTemplate->wildcard = '### ' . ($GLOBALS['TL_LANG']['FMD']['webmail_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = StringUtil::specialcharsUrl(System::getContainer()->get('router')->generate('contao_backend', array('do'=>'themes', 'table'=>'tl_module', 'act'=>'edit', 'id'=>$this->id)));
 
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		global $objPage;
		
		System::loadLanguageFile('tl_webmail');
				
		$webmailCount = WebmailModel::findAll();
		$rows = array();	
		while($webmailCount->next())
		{
			$rows[] = $webmailCount->row();
		}
		
		$total = \count($rows);
		$limit = $total;
		$offset = 0;
				
		// Pagination
	    if ($this->perPage > 0)
	    {
        	$id = 'page_e' . $this->id;
        	$page = Input::get($id) ?? 1;
 
        	if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
        	{
        		throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
        	}
 
        	$offset = ($page - 1) * $this->perPage;
        	$limit = min($this->perPage + $offset, $total);
 
        	$objPagination = new Pagination($total, $this->perPage, Config::get('maxPaginationLinks'), $id);
        	$this->Template->pagination = $objPagination->generate("\n  ");
        }

		/**
		 * Abfragen der Tabelle
		 **/
		$webmails = array();

        $result = WebmailModel::findAllByPublished($offset, (int)$this->perPage);
				
		while ($result->next())
		{		
			
			$webmails[] = array
			(
				'title' => StringUtil::specialchars($result->title),
				'url'	=> htmlspecialchars($result->url),
				'alle'  => $result->alle,
				'compliance' => $result->compliance,
				'date'	=> $result->date
			);
		}
				
		//Template
		if (($this->webmail_template != $this->strTemplate) && ($this->webmail_template != ''))
		{
			$this->strTemplate = $this->webmail_template;
			$this->Template = new FrontendTemplate($this->strTemplate);
		}
		$this->Template->title = StringUtil::specialchars($GLOBALS['TL_LANG']['tl_webmail']['header_title']);
		$this->Template->date = StringUtil::specialchars($GLOBALS['TL_LANG']['tl_webmail']['header_date']);
		$this->Template->webmails = $webmails;
		
	}
}
