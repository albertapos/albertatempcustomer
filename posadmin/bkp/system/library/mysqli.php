<?php
class MySQLi2 {
	private $connection;

	public function __construct($hostname, $username, $password, $database, $port = '3306') {
		$this->connection = new \mysqli($hostname, $username, $password, $database, $port);

		if ($this->connection->connect_error) {
			throw new \Exception('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br /> Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br />' . $sql);
		}

		$this->connection->set_charset("utf8");
		$this->connection->query("SET SQL_MODE = ''");
	}

	public function query($sql) {
		$query = $this->connection->query($sql);

		if (!$this->connection->errno) {
			if ($query instanceof \mysqli_result) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				$query->close();

				return $result;
			} else {
				return true;
			}
		} else {
			throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
		}
	}

	public function escape($value) {
		//return $this->connection->real_escape_string($value);
		//return $this->connection->real_escape_string(htmlspecialchars_decode($value, ENT_NOQUOTES));
		return $this->connection->real_escape_string(html_entity_decode($value));
	}
	
	public function countAffected() {
		return $this->connection->affected_rows;
	}

	public function getLastId() {
		return $this->connection->insert_id;
	}
	
	public function connected() {
		return $this->connection->connected();
	}
	
	public function __destruct() {
		$this->connection->close();
	}
}