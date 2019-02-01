<?php
class ModelApiItemsShowItemPrice extends Model {

    public function getTotalItems($data = array()) {
        $sql="SELECT * FROM mst_item";
        
        if (!empty($data['searchbox'])) {
            $sql .= " WHERE vitemname='". $this->db->escape($data['searchbox']) ."' OR vbarcode='". $this->db->escape($data['searchbox']) ."'";
        }

        $query = $this->db2->query($sql);

        $return_arr = array();

        $return_arr['total'] = count($query->rows);
        
        return $return_arr;
    }

    public function getItem($data = array()) {
        
        $sql="SELECT iitemid, vitemname, vbarcode, dunitprice FROM mst_item";

        if (!empty($data['searchbox'])) {
            $sql .= " WHERE vitemname='". $this->db->escape($data['searchbox']) ."' OR vbarcode='". $this->db->escape($data['searchbox']) ."'";
        }

        if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }

}
?>