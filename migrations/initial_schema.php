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

use \phpbb\db\migration\container_aware_migration;

/**
 * Class initial_schema
 *
 * @package mrgoldy\ultimateblog\migrations
 */
class initial_schema extends \phpbb\db\migration\container_aware_migration
{
	/**
	* @return void
	* @access public
	*/
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	/**
	* @return void
	* @access public
	*/
	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'ub_blogs'	=> array(
					'COLUMNS'		=> array(
						'blog_id'				=> array('UINT', null, 'auto_increment'),
						'blog_date'				=> array('TIMESTAMP', 0),
						'blog_description'		=> array('VCHAR:125', ''),
						'blog_image'			=> array('VCHAR:255', ''),
						'blog_text'				=> array('MTEXT_UNI', ''),
						'blog_title'			=> array('VCHAR:255', ''),
						'blog_views'			=> array('UINT', 0),
						'blog_approved'			=> array('BOOL', 1),
						'blog_reported'			=> array('BOOL', 0),
						'author_id'				=> array('UINT', 0),
						'bbcode_bitfield'		=> array('VCHAR:255', ''),
						'bbcode_uid'			=> array('VCHAR:8', ''),
						'enable_bbcode'			=> array('BOOL', 1),
						'enable_smilies'		=> array('BOOL', 1),
						'enable_magic_url'		=> array('BOOL', 1),
						'locked_comments'		=> array('BOOL', 0),
						'locked_edit'			=> array('BOOL', 0),
						'locked_rating'			=> array('BOOL', 0),
						'friends_only'			=> array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> 'blog_id',
				),

				$this->table_prefix . 'ub_blog_category'	=> array(
					'COLUMNS'		=> array(
						'blog_id'			=> array('UINT', 0),
						'category_id'		=> array('UINT', 0),
					),
				),

				$this->table_prefix . 'ub_categories'	=>  array(
					'COLUMNS'		=> array(
						'category_id'			=> array('UINT', null, 'auto_increment'),
						'left_id'				=> array('UINT', 0),
						'right_id'				=> array('UINT', 0),
						'category_name'			=> array('VCHAR:255', ''),
						'category_description'	=> array('TEXT_UNI', ''),
						'category_image'		=> array('VCHAR:255', ''),
						'bbcode_bitfield'		=> array('VCHAR:255', ''),
						'bbcode_uid'			=> array('VCHAR:8', ''),
						'enable_bbcode'			=> array('BOOL', 1),
						'enable_smilies'		=> array('BOOL', 1),
						'enable_magic_url'		=> array('BOOL', 1),
						'is_private'			=> array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> 'category_id',
				),

				$this->table_prefix . 'ub_comments'	=> array(
					'COLUMNS'		=> array(
						'comment_id'			=> array('UINT', null, 'auto_increment'),
						'comment_text'			=> array('TEXT_UNI', ''),
						'comment_time'			=> array('TIMESTAMP', 0),
						'comment_approved'		=> array('BOOL', 1),
						'comment_reported'		=> array('BOOL', 0),
						'user_id'				=> array('UINT', 0),
						'blog_id'				=> array('UINT', 0),
						'parent_id'				=> array('UINT', 0),
						'bbcode_bitfield'		=> array('VCHAR:255', ''),
						'bbcode_uid'			=> array('VCHAR:8', ''),
						'bbcode_options'		=> array('TINT:7', 7),
					),
					'PRIMARY_KEY'	=> 'comment_id',
				),

				$this->table_prefix . 'ub_edits'	=> array(
					'COLUMNS'		=> array(
						'edit_id'				=> array('UINT', null, 'auto_increment'),
						'edit_text'				=> array('VCHAR:100', ''),
						'edit_time'				=> array('TIMESTAMP', 0),
						'editor_id'				=> array('UINT', 0),
						'blog_id'				=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'edit_id',
				),

				$this->table_prefix . 'ub_index'	=> array(
					'COLUMNS'		=> array(
						'block_id'				=> array('USINT', 0),
						'block_name'			=> array('XSTEXT', ''),
						'block_limit'			=> array('USINT', 0),
						'block_order'			=> array('USINT', 0),
						'block_data'			=> array('UINT', 0),
					),
				),

				$this->table_prefix . 'ub_ratings'	=> array(
					'COLUMNS'		=> array(
						'blog_id'				=> array('UINT', 0),
						'user_id'				=> array('UINT', 0),
						'rating'				=> array('TINT:5', 0),
					),
				),

				$this->table_prefix . 'ub_reports' => array(
					'COLUMNS'		=> array(
						'report_id'				=> array('UINT', null, 'auto_increment'),
						'reason_id'				=> array('USINT', 0),
						'blog_id'				=> array('UINT', 0),
						'comment_id'			=> array('UINT', 0),
						'user_id'				=> array('UINT', 0),
						'user_notify'			=> array('BOOL', 1),
						'report_closed'			=> array('BOOL', 0),
						'report_time'			=> array('TIMESTAMP', 0),
						'report_text'			=> array('TEXT_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'report_id',
				),
			),
		);
	}

	/**
	* @return void
	* @access public
	*/
	public function update_data()
	{
		$data = array(
			# Add config
			array('config.add', array('ub_allow_bbcodes', 1)),
			array('config.add', array('ub_allow_smilies', 1)),
			array('config.add', array('ub_allow_magic_url', 1)),
			array('config.add', array('ub_blog_min_chars', 200)),
			array('config.add', array('ub_blogs_per_page', 9)),
			array('config.add', array('ub_comments_per_page', 10)),
			array('config.add', array('ub_custom_index', 1)),
			array('config.add', array('ub_enable', 1)),
			array('config.add', array('ub_enable_announcement', 0)),
			array('config.add', array('ub_enable_comments', 1)),
			array('config.add', array('ub_enable_friends_only', 1)),
			array('config.add', array('ub_enable_rating', 1)),
			array('config.add', array('ub_enable_rss', 1)),
			array('config.add', array('ub_enable_subscriptions', 1)),
			array('config.add', array('ub_fa_icon', 'fa-book')),
			array('config.add', array('ub_image_dir', 'images/blog')),
			array('config.add', array('ub_image_cat_dir', 'images/blog/categories')),
			array('config.add', array('ub_image_size', '15')),
			array('config.add', array('ub_start_date', time())),
			array('config.add', array('ub_title', 'Ultimate Blog')),
			array('config_text.add', array('ub_announcement_text', '<h3>Announcement</h3><p>This is an announcement message that will be displayed troughout the entire <strong>Ultimate Blog</strong> extension.<br>It will be shown on all pages related to this extension.<br><strong><span style="text-decoration: underline;">NOTE</span>:</strong> You have to use <em>HTML</em> and <strong>not</strong> <em>BBCodes</em>!</p>')),

			# Add permissions
			array('permission.add', array('u_ub_view')),
			array('permission.add', array('u_ub_post')),
			array('permission.add', array('u_ub_post_private')),
			array('permission.add', array('u_ub_edit')),
			array('permission.add', array('u_ub_edit_view')),
			array('permission.add', array('u_ub_delete')),
			array('permission.add', array('u_ub_noapprove')),
			array('permission.add', array('u_ub_comment_delete')),
			array('permission.add', array('u_ub_comment_edit')),
			array('permission.add', array('u_ub_comment_noapprove')),
			array('permission.add', array('u_ub_comment_post')),
			array('permission.add', array('u_ub_comment_view')),
			array('permission.add', array('u_ub_rate')),
			array('permission.add', array('u_ub_report')),

			array('permission.add', array('m_ub_edit')),
			array('permission.add', array('m_ub_delete')),
			array('permission.add', array('m_ub_approve')),
			array('permission.add', array('m_ub_changeauthor')),
			array('permission.add', array('m_ub_edit_lock')),
			array('permission.add', array('m_ub_edit_delete')),
			array('permission.add', array('m_ub_view_friends_only')),
			array('permission.add', array('m_ub_lock_rating')),
			array('permission.add', array('m_ub_lock_comments')),
			array('permission.add', array('m_ub_report')),

			array('permission.add', array('a_ub_overview')),
			array('permission.add', array('a_ub_settings')),
			array('permission.add', array('a_ub_categories')),

			# Add view permission for the Guests group
			array('permission.permission_set', array('GUESTS', 'u_u_view', 'group')),

			# Insert sample data for Ultimate Blog
			array('custom', array(array($this, 'insert_sample_data'))),

			# Create blog images directory
			array('custom', array(array($this, 'create_blog_image_dir'))),

			# Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ULTIMATEBLOG'
			)),
			array('module.add', array(
				'acp',
				'ACP_ULTIMATEBLOG',
				array(
					'module_basename'	=> '\mrgoldy\ultimateblog\acp\main_module',
					'modes'				=> array('overview', 'settings', 'categories'),
				),
			)),
		);

		# Assign permissions to roles
		if ($this->role_exists('ROLE_USER_STANDARD'))
		{
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_post'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_edit'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_edit_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_delete'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_noapprove'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_comment_delete'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_comment_edit'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_comment_noapprove'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_comment_post'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_comment_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_rate'));
			$data[] = array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_ub_report'));
		}

		if ($this->role_exists('ROLE_USER_FULL'))
		{
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_post'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_edit'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_edit_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_delete'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_noapprove'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_comment_delete'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_comment_edit'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_comment_noapprove'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_comment_post'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_comment_view'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_rate'));
			$data[] = array('permission.permission_set', array('ROLE_USER_FULL', 'u_ub_report'));
		}

		if ($this->role_exists('ROLE_MOD_STANDARD'))
		{
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_edit'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_delete'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_approve'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_changeauthor'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_edit_lock'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_edit_delete'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_view_friends_only'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_lock_rating'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_lock_comments'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_ub_report'));
		}

		if ($this->role_exists('ROLE_MOD_FULL'))
		{
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_edit'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_delete'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_approve'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_changeauthor'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_edit_lock'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_edit_delete'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_view_friends_only'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_lock_rating'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_lock_comments'));
			$data[] = array('permission.permission_set', array('ROLE_MOD_FULL', 'm_ub_report'));
		}

		if ($this->role_exists('ROLE_ADMIN_STANDARD'))
		{
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_ub_overview'));
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_ub_settings'));
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_ub_categories'));
		}

		if ($this->role_exists('ROLE_ADMIN_FULL'))
		{
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ub_overview'));
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ub_settings'));
			$data[] = array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ub_categories'));
		}

		return $data;
	}

	/**
	* @return void
	* @access public
	*/
	public function revert_schema()
	{
		return array(
				'drop_tables'		=> array(
					$this->table_prefix . 'ub_blogs',
					$this->table_prefix . 'ub_categories',
					$this->table_prefix . 'ub_blog_category',
					$this->table_prefix . 'ub_comments',
					$this->table_prefix . 'ub_index',
					$this->table_prefix . 'ub_edits',
					$this->table_prefix . 'ub_ratings',
					$this->table_prefix . 'ub_reports',
				),
		);
	}

	public function create_blog_image_dir()
	{
		global $phpbb_container;

		$img_dir = $this->phpbb_root_path . 'images';
		$blog_dir = $img_dir . '/blog';
		$cat_dir = $blog_dir . '/categories';
		$filesystem = $phpbb_container->get('filesystem');

		if ($filesystem->exists($img_dir) && $filesystem->is_writable($img_dir))
		{
			if (!$filesystem->exists($blog_dir))
			{
				$filesystem->mkdir($blog_dir, 511);
			}
			if (!$filesystem->exists($cat_dir))
			{
				$filesystem->mkdir($cat_dir, 511);
			}
		}

		$filesystem->mirror($this->phpbb_root_path . 'ext/mrgoldy/ultimateblog/images/', $img_dir . $blog_dir);
	}

	/**
	 * # Check if permission role exists
	 *
	 * @param $role
	 * @return void
	 * @access private
	 */
	private function role_exists($role)
	{
		$sql = 'SELECT role_id
				FROM ' . ACL_ROLES_TABLE . "
				WHERE role_name = '" . $this->db->sql_escape($role) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$role_id = $this->db->sql_fetchfield('role_id');
		$this->db->sql_freeresult($result);

		return $role_id;
	}

	/**
	* # Insert sample data
	* @return void
	* @access public
	*/
	public function insert_sample_data()
	{
		$user = $this->container->get('user');

		$sample_blog = array(
			array(
				'blog_id'				=> 1,
				'blog_date'				=> time(),
				'blog_description'		=> 'This is a descriptive piece of text summarising everything in this blog. Enjoy using Ultimate Blog!',
				'blog_image'			=> 'ub_image.png',
				'blog_text'				=> '<r>This is an example blog in your phpBB3 Extension: <B><s>[b]</s>Ultimate Blog<e>[/b]</e></B>.<br/>
<br/>
Everything seems to be working. You may delete this blog if you like and continue to set up your Ultimate Blog extension. During the installation of this extension a category and blog post have been made. Which you are read right now. These were to made to show you the overall look and options of the extension.<br/>
<br/>
Permissions have also been added, regular permissions for Registered Users role <I><s>[i]</s>Standard<e>[/i]</e></I> and <I><s>[i]</s>Full<e>[/i]</e></I>. Moderating permissions for the Global Moderators roles <I><s>[i]</s>Standard<e>[/i]</e></I> and <I><s>[i]</s>Full<e>[/i]</e></I> and administrative permissions for the Administrators roles <I><s>[i]</s>Standard<e>[/i]</e></I> and <I><s>[i]</s>Full<e>[/i]</e></I>.<br/>
<br/>
Hope you like the Ultimate Blog extension and: Have fun!</r>',
				'blog_title'			=> 'Welcome to Ultimate Blog',
				'blog_views'			=> 0,
				'blog_approved'			=> 1,
				'author_id'				=> (int) $user->data['user_id'],
				'bbcode_bitfield'		=> '',
				'bbcode_uid'			=> '',
				'enable_bbcode'			=> 1,
				'enable_smilies'		=> 1,
				'enable_magic_url'		=> 1,
				'locked_comments'		=> 0,
				'locked_edit'			=> 0,
				'locked_rating'			=> 0,
				'friends_only'			=> 0,
			),
		);

		$sample_category = array(
			array(
				'category_id'			=> 1,
				'category_name'			=> 'Your first Ultimate Blog category',
				'category_description'	=> 'A description of your first Ultimate Blog category.',
				'category_image'		=> 'ub_cat_image.png',
				'bbcode_bitfield'		=> '',
				'bbcode_uid'			=> '',
				'enable_bbcode'			=> 1,
				'enable_smilies'		=> 1,
				'enable_magic_url'		=> 1,
				'is_private'			=> 0,
				'left_id'				=> 1,
				'right_id'				=> 2,
			),
		);

		$sample_blog_category = array(
			array(
				'blog_id'				=> 1,
				'category_id'			=> 1,
			),
		);

		$sample_comment = array(
			array(
				'comment_id'			=> 1,
				'comment_text'			=> '<r>This is an example comment on one of your <B><s>[b]</s>Ultimate Blog<e>[/b]</e></B> blogs.</r>',
				'comment_time'			=> time(),
				'comment_approved'		=> 1,
				'user_id'				=> (int) $user->data['user_id'],
				'blog_id'				=> 1,
				'parent_id'				=> 0,
				'bbcode_bitfield'		=> '',
				'bbcode_uid'			=> '',
				'bbcode_options'		=> 7,
			),
			array(
				'comment_id'			=> 2,
				'comment_text'			=> '<r>This is a second example comment on one of your <B><s>[b]</s>Ultimate Blog<e>[/b]</e></B> blogs. <E>:-D</E></r>',
				'comment_time'			=> time()+300,
				'comment_approved'		=> 1,
				'user_id'				=> (int) $user->data['user_id'],
				'blog_id'				=> 1,
				'parent_id'				=> 0,
				'bbcode_bitfield'		=> '',
				'bbcode_uid'			=> '',
				'bbcode_options'		=> 7,
			),
			array(
				'comment_id'			=> 3,
				'comment_text'			=> '<t>This is an example reply on one of your Ultimate Blog comments.</t>',
				'comment_time'			=> time()+600,
				'comment_approved'		=> 1,
				'user_id'				=> (int) $user->data['user_id'],
				'blog_id'				=> 1,
				'parent_id'				=> 1,
				'bbcode_bitfield'		=> '',
				'bbcode_uid'			=> '',
				'bbcode_options'		=> 7,
			),
		);

		$ultimateblog_index = array(
			array(
				'block_id'		=> 1,
				'block_name'	=> 'category1',
				'block_limit'	=> 3,
				'block_order'	=> 0,
				'block_data'	=> 1,
			),
			array(
				'block_id'		=> 2,
				'block_name'	=> 'category2',
				'block_limit'	=> 3,
				'block_order'	=> 0,
				'block_data'	=> 1,
			),
			array(
				'block_id'		=> 3,
				'block_name'	=> 'category3',
				'block_limit'	=> 3,
				'block_order'	=> 0,
				'block_data'	=> 1,
			),
			array(
				'block_id'		=> 4,
				'block_name'	=> 'latest',
				'block_limit'	=> 3,
				'block_order'	=> 1,
				'block_data'	=> 0,
			),
			array(
				'block_id'		=> 5,
				'block_name'	=> 'comments',
				'block_limit'	=> 3,
				'block_order'	=> 1,
				'block_data'	=> 0,
			),
			array(
				'block_id'		=> 6,
				'block_name'	=> 'rating',
				'block_limit'	=> 3,
				'block_order'	=> 0,
				'block_data'	=> 10,
			),
			array(
				'block_id'		=> 7,
				'block_name'	=> 'views',
				'block_limit'	=> 3,
				'block_order'	=> 0,
				'block_data'	=> 0,
			),
		);

		# Insert the data
		$this->db->sql_multi_insert($this->table_prefix . 'ub_blogs', $sample_blog);
		$this->db->sql_multi_insert($this->table_prefix . 'ub_categories', $sample_category);
		$this->db->sql_multi_insert($this->table_prefix . 'ub_blog_category', $sample_blog_category);
		$this->db->sql_multi_insert($this->table_prefix . 'ub_comments', $sample_comment);
		$this->db->sql_multi_insert($this->table_prefix . 'ub_index', $ultimateblog_index);
	}
}
