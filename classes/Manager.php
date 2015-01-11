<?php

class Manager {

	/**
	 * @var object The database connection
	 */
	private $db_connection = null;

	private $logger = null;

	function __construct($logger) {
		$this->logger = $logger;
	}

	public function getMembers() {

		$this->connectToDb();

		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT member_id, fullname, workshops
					FROM members";

			$members_result = $this->db_connection->query($sql);

			if ($members_result->num_rows) {
				$members = $this->resultToArray($members_result);

				uasort($members, array($this, 'lastNameSort'));

				return $members;
			}
		}

		return array();
	}

	public function getMemberWorkshops($memberId) {
		$memberId = (int) $memberId;

		$this->connectToDb();

		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT workshops FROM members WHERE member_id = $memberId";
			$member_result = $this->db_connection->query($sql);

			if ($member_result->num_rows == 1) {
				$workshops = $member_result->fetch_object()->workshops;

				// get the workshops from the db or use the defaults
				return $workshops == null ? $this->getWorkshopDefaults() : unserialize($workshops);
			}
		}

		return $this->getWorkshopDefaults();
	}

	public function getMemberIds() {
		$this->connectToDb();

		$ids = array();

		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT member_id FROM members";

			$members_result = $this->db_connection->query($sql);

			if ($members_result->num_rows) {
				$results = $this->resultToArray($members_result);

				foreach ($results as $result) {
					$ids[] = $result->member_id;
				}
			}
		}

		return $ids;
	}

	public function getWorkshops() {
		$workshops = unserialize(WORKSHOPS);

		ksort($workshops);

		return $workshops;
	}

	public function isWorkshop($key) {
		$workshops = $this->getWorkshops();
		
		return isset($workshops[$key]) ? true : false;
	}

	public function checkMemberUpdate() {
		if (!isset($_POST['memberupdate'])) {
			return;
		}

		$this->doMemberUpdate($_POST);
	}

	/**
	 * @see http://stackoverflow.com/a/9370665/520544
	 */
	private function lastNameSort($a, $b) {
		$aLast = end(explode(' ', $a->fullname));
		$bLast = end(explode(' ', $b->fullname));

		return strcasecmp($aLast, $bLast);
	}

	private function resultToArray($result) {
		$rows = array();
		
		while ($row = $result->fetch_assoc()) {
			$rows[] = (object) $row;
		}
		
		return $rows;
	}

	private function connectToDb() {
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->db_connection->set_charset("utf8");
	}

	private function getWorkshopDefaults() {
		// get the workshop keys
		$keys = array_keys($this->getWorkshops());

		// return an array { workshopKey: false }
		return array_fill_keys($keys, false);
	}

	private function doMemberUpdate($data) {
		// all members with default state
		$updates = array_fill_keys($this->getMemberIds(), $this->getWorkshopDefaults());

		// collect updates
		foreach ($data as $keyPair => $value) {
			$keyPair = explode('_', $keyPair);
			$key = $keyPair[0];
			$value = (boolean) $value;
			
			if ($this->isWorkshop($key)) {
				$id = (int) $keyPair[1];
				$updates[$id][$key] = $value;

				// logger logic
				$currentWorkshops = $this->getMemberWorkshops($id);

				if ($currentWorkshops[$key] !== $value) {
					$this->logger->log('update workshop', array('Workshopkey' => $key, 'memberId' => $id, 'value' => $value));
				}
			}
		}

		// save updates
		foreach ($updates as $memberId => $workshops) {
			$this->updateWorkshops($memberId, $workshops);
		}
	}

	private function updateWorkshops($memberId, $workshops) {
		$defaults = $this->getWorkshopDefaults();
		
		$workshops = array_merge($defaults, array_intersect_key($workshops, $defaults));

		$sql_workshops = serialize($workshops);
		$sql = "UPDATE members Set workshops = '$sql_workshops' Where member_id = $memberId";

		$this->connectToDb();
		$query_member_update = $this->db_connection->query($sql); 

		if ($query_member_update) {
			$this->messages[] = "Successfully updated workshops!";
		}

	}

	/**
	 * @deprecated
	 */
	private function updateWorkshop($memberId, $workshopKey, $value) {
		$workshops = $this->getMemberWorkshops($memberId);

		// update the workshop key
		if (!isset($workshops[$workshopKey])) return;

		$workshops[$workshopKey] = (boolean) $value;

		// serialize the object into a string and save it
		$sql_workshops = serialize($workshops);
		$sql = "UPDATE members Set workshops = '$sql_workshops' Where member_id = $memberId";

		$query_member_update = $this->db_connection->query($sql); 

		if ($query_member_update) {
			$this->messages[] = "Successfully updated";
		}
	}
}