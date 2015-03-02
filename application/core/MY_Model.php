<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * extend model
 * 
 */
class MY_Model extends CI_Model{
	protected $table = '';
	
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * get only 1 row
	 * sometimes you may just want 
	 * to know is it exists the record let the "$select = 1"
	 * 
	 * @return 
	 */
	function fetch_one($where, $select = '')
	{
		if(!$where) return FALSE;
		if($select)
		{
			$this->db->select($select, is_numeric($select) ? FALSE : NULL);
		}
		$this->db->where($where);
		$row = $this->db->get($this->table, 1)->row_array();

		return $row ? $row : null;
	}
	
	/**
	 * fetch all row
	 * 
	 */
	function fetch($where = array(), $select = '', $order_by = '')
	{
		if($select)
		{
			$this->db->select($select);
		}
		if($where)
		{
			$this->db->where($where);
		}
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		
		return $this->db->get($this->table)->result_array();
	}
	
	/**
	 * insert
	 * @param array $data
	 * @return 
	 */
	function insert($data)
	{
		if($this->db->insert($this->table, $data))
		{
			return $this->db->insert_id();
		}
		return FALSE; 
	}
	
	/**
	 * update
	 * @param array $data
	 * @param array $where [optional]
	 * @return 
	 */
	function update($data, $where = array())
	{
		if($where)
		{
			$this->db->where($where);
		}
		
		return $this->db->update($this->table, $data);
	}
	
	/**
	 * save
	 * @param object $data
	 * @param object $where [optional]
	 * @param object $is_update [optional]
	 * @return 
	 */
	function save($data, $where = array(), $is_update = FALSE)
	{
		if(!$where && !$is_update)
		{
			return $this->insert($data);
		}
		return $this->update($data, $where);
	}
	
	/**
	 * delete
	 * 
	 * @param object $where
	 * @return 
	 */
	function delete($where)
	{
		return $this->db->delete($this->table, $where); 
	}
	
	/**
	 * 返回一个空数组，无数据
	 * @return array
	 */
	function blank()
	{
		$row = $this->db->list_fields($this->table);
		$blank_row = array();
		if($row)
		{
			foreach($row as $data)
			{
				$blank_row[$data] = false;
			}
		}
		return $blank_row;
	}
}

//End of file
