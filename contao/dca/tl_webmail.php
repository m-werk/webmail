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

use Contao\Backend;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Input;

/**
 * Table tl_webmail
 */
 
$GLOBALS['TL_DCA']['tl_webmail'] = array(
    'config'      => array(
        'dataContainer'    => DC_Table::class,
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
                'id' => 'primary'
            )
        ),
    ),
    'list'        => array(
        'sorting'           => array(
            'mode'        => DataContainer::MODE_SORTABLE,
            'fields'      => array('date'),
            'flag'        => DataContainer::SORT_INITIAL_LETTER_ASC,
            'panelLayout' => 'filter;sort,search,limit'
        ),
        'label'             => array(
            'fields' => array('date', 'title'),
            'showColumns' => true
        ),
        'global_operations' => array(
            'all' => array(
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array(
            'edit'   => array(
                'href'  => 'act=edit',
                'icon'  => 'edit.svg'
            ),
            'copy'   => array(
                'href'  => 'act=copy',
                'icon'  => 'copy.svg'
            ),
            'delete' => array(
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_webmail']['toggle'],
				'icon'                => 'visible.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('MWerk\Webmail\Classes\DcaWebmail', 'toggleIcon')
			),
            'show'   => array(
                'href'       => 'act=show',
                'icon'       => 'show.svg',
                'attributes' => 'style="margin-right:3px"'
            ),
        )
    ),
	
    // Palettes
	'palettes' => array
	(
		'default' => '{title_legend},title,url,date;{zusatz_legend},alle,compliance;{published_legend},published'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_webmail']['title'],
			'inputType' => 'text',
			'exclude'   => true,
			'search'    => true,
			'eval'      => array ('mandatory'=>true, 'unique'=>false, 'maxlength'=>255, 'tl_class'=>'long',	'doNotCopy'=>true),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'url' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_webmail']['url'],
			'inputType' => 'text',
			'exclude'   => true,
			'eval'      => array ('mandatory'=>true, 'unique'=>false, 'maxlength'=>255, 'tl_class'=>'long', 'rgxp'=>'url', 'decodeEntities'=>true, 'doNotCopy'=>true),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'date' => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_webmail']['date'],
			'default'	=> time(),
			'exclude'	=> true,
			'filter'	=> true,
			'sorting'	=> true,
			'flag'		=> 8,
			'inputType'	=> 'text',
			'eval'		=> array ('rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizzard'),
			'sql'		=> "int(10) unsigned NOT NULL default '0'"
		),
		'alle' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_webmail']['alle'],
			'default'		=> true,
			'execute'		=> true,
			'filter'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array ('doNotCopy'=>true, 'tl_class'=>'w50 wizard'),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'compliance' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_webmail']['compliance'],
			'execute'		=> true,
			'filter'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array ('doNotCopy'=>true, 'tl_class'=>'w50 wizard'),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'published' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_webmail']['published'],
			'exclude'		=> true,
			'filter'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array ('doNotCopy'=>true, 'tl_class'=>'w50 m12'),
			'sql'			=> "char(1) NOT NULL default ''"
		)
	)
);
