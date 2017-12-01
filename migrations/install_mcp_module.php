<?php
/**
 *
 * Ultimate Blog. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Mr. Goldy
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace mrgoldy\ultimateblog\migrations;

/**
 * Class install_mcp_module
 *
 * @package mrgoldy\ultimateblog\migrations
 */
class install_mcp_module extends \phpbb\db\migration\migration
{
	/**
	 * @return array
	 */
	static public function depends_on()
	{
		return array('\mrgoldy\ultimateblog\migrations\initial_schema');
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return array(
			array('module.add', array(
				'mcp',
				'MCP_REPORTS',
				array(
					'module_basename'	=> '\mrgoldy\ultimateblog\mcp\report_module',
					'modes'				=> array('ub_blog_reports_open', 'ub_blog_reports_closed', 'ub_blog_reports_details', 'ub_comment_reports_open', 'ub_comment_reports_closed', 'ub_comment_reports_details'),
				),
			)),
			array('module.add', array(
				'mcp',
				'MCP_QUEUE',
				array(
					'module_basename'	=> '\mrgoldy\ultimateblog\mcp\approve_module',
					'modes'				=> array('ub_blog_approve', 'ub_comment_approve'),
				)
			))
		);
	}
}
