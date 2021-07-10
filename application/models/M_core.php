<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_core extends CI_Model
{

	public function get($table, $select = '*', $where = NULL, $orderBy = NULL, $orderOrien = 'ASC', $limit = NULL, $offset = 0, $groupBy = NULL)
	{
		$this->db->select($select);
		if ($where != NULL) {
			$this->db->where($where);
		}

		if ($orderBy != NULL) {
			$this->db->order_by($orderBy, $orderOrien);
		}

		if ($groupBy != NULL) {
			$this->db->group_by($groupBy);
		}

		return $this->db->get($table, $limit, $offset);
	}

	public function count($table, $where = NULL)
	{
		if ($where != NULL) {
			$this->db->where($where);
		}

		$this->db->from($table);
		return $this->db->count_all_results();
	}

	public function store($table, $object)
	{
		return $this->db->insert($table, $object);
	}

	public function store_uuid($table, $object)
	{
		$this->db->set('id', 'UUID()', FALSE);
		return $this->db->insert($table, $object);
	}

	public function store_batch($table, $object)
	{
		return $this->db->insert_batch($table, $object);
	}

	public function store_uuid_batch($table, $object)
	{
		$this->db->set('id', 'UUID()', FALSE);
		return $this->db->insert_batch($table, $object);
	}

	public function update($table, $object, $where)
	{
		$this->db->where($where);
		return $this->db->update($table, $object);
	}

	public function delete($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}

	public function uuid()
	{
		return $this->db->query('SELECT UUID() AS uuid')->row()->uuid;
	}

	public function truncate($table)
	{
		$this->db->truncate($table);
	}
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
