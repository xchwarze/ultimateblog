<?php
/**
 *
 * Ultimate Blog. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Mr. Goldy
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mrgoldy\ultimateblog\controller;

/**
 * Class archives
 *
 * @package mrgoldy\ultimateblog\controller
 */
class archives
{
	protected $config;
	protected $func;
	protected $helper;
	protected $lang;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config					$config
	* @param \mrgoldy\ultimateblog\core\functions	$func
	* @param \phpbb\controller\helper				$helper
	* @param \phpbb\language\language				$lang
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	*/
	public function __construct(\phpbb\config\config $config, $func, \phpbb\controller\helper $helper, \phpbb\language\language $lang, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config	= $config;
		$this->func		= $func;
		$this->helper	= $helper;
		$this->lang		= $lang;
		$this->template	= $template;
		$this->user		= $user;
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function overview()
	{
		# Check if Ultimate Blog is enabled and if the user has the 'view' permission
		$this->func->ub_status();

		$data = $this->func->archive_list();
		$archive_array = array();

		foreach ($data as $row)
		{
			$archive_array[] = array($this->user->format_date($row['blog_date'], 'Y') => $this->user->format_date($row['blog_date'], 'm'));
		}

		array_walk_recursive($archive_array, function($month_value, $year_key) use (&$archive){
			$archive[$year_key][] = $month_value;
		});

		foreach ($archive as $year => $months)
		{
			$this->template->assign_block_vars('years', array(
				'YEAR'	=> $year,
			));

			foreach ($months as $month)
			{
				$this->template->assign_block_vars('years.months', array(
					'MONTH'		=> $this->user->format_date(mktime(0, 0, 0, (int) $month), 'F'),

					'U_ARCHIVE'	=> $this->helper->route('mrgoldy_ultimateblog_archive', array('year' => (int) $year, 'month' => (int) $month)),
				));
			}
		}

		# Assign template variables
		$this->template->assign_vars(array(
			'ULTIMATEBLOG_TITLE'	=> $this->config['ub_title'],

			'U_BLOG_ADD'		=> $this->helper->route('mrgoldy_ultimateblog_posting', array('mode' => 'add')),
			'U_BLOG_ARCHIVE'	=> $this->helper->route('mrgoldy_ultimateblog_archives'),
			'U_BLOG_CATEGORIES'	=> $this->helper->route('mrgoldy_ultimateblog_categories'),
			'U_BLOG_INDEX'		=> $this->helper->route('mrgoldy_ultimateblog_index'),
		));

		# Breadcrumbs: add the Ultimate Blog part
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->config['ub_title'],
			'U_VIEW_FORUM'	=> $this->helper->route('mrgoldy_ultimateblog_index'),
		));

		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->lang->lang('BLOG_ARCHIVE'),
			'U_VIEW_FORUM'	=> $this->helper->route('mrgoldy_ultimateblog_archives'),
		));

		return $this->helper->render('ub_archives.html', $this->lang->lang('BLOG_ARCHIVE'));
	}
}
