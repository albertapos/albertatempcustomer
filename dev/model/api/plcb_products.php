<?php
class ModelApiPlcbProducts extends Model {
    
    public function getPlcbProductsTotal($data = array()){

        $sql="SELECT COUNT(*) AS total FROM mst_item a LEFT JOIN mst_item_size b ON(a.iitemid=b.item_id) LEFT JOIN mst_plcb_item c ON(a.iitemid=c.item_id) LEFT JOIN  mst_item_unit d ON(b.unit_id=d.id) LEFT JOIN mst_item_bucket e ON(e.id=c.bucket_id)";
        
        if (!empty($data['searchbox'])) {
            $sql .= " WHERE a.iitemid= ". $this->db->escape($data['searchbox']);
        }else{
            $sql .= " WHERE a.estatus= 'Active'";
        }

        $query = $this->db2->query($sql);

        return $query->row['total'];
    }

    public function getPlcbProducts($data = array()){

        $sql="SELECT a.iitemid,a.vitemname,b.unit_id,b.unit_value,e.bucket_name,c.bucket_id,c.prev_mo_beg_qty,c.prev_mo_end_qty,c.malt FROM mst_item a LEFT JOIN mst_item_size b ON(a.iitemid=b.item_id) LEFT JOIN mst_plcb_item c ON(a.iitemid=c.item_id) LEFT JOIN  mst_item_unit d ON(b.unit_id=d.id) LEFT JOIN mst_item_bucket e ON(e.id=c.bucket_id)";
        
        if (!empty($data['searchbox'])) {
            $sql .= " WHERE a.iitemid= ". $this->db->escape($data['searchbox']);
        }else{
            $sql .= " WHERE a.estatus= 'Active'";
        }

        if(!empty($data['sort']) && !empty($data['order'])){
            if($data['sort'] == 'itemname'){
                $sql .= " ORDER BY a.vitemname ".$data['order'];
            }else{
                $sql .= " ORDER BY e.bucket_name ".$data['order'];
            }
            
        }else{
            $sql .= " ORDER BY c.LastUpdate DESC";
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

    public function getPlcbunits(){

        $sql="SELECT * FROM mst_item_unit";
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getPlcbBuckets(){

        $sql="SELECT * FROM mst_item_bucket";
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getMstItemSize($item_id){

        $sql="SELECT * FROM mst_item_size WHERE item_id='". (int)$item_id ."'";
        
        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function updateMstItemSize($data = array()) {
        $this->db2->query("UPDATE mst_item_size SET unit_id = '" . $this->db->escape($data['unit_id']) . "', unit_value = '" . $this->db->escape($data['unit_value']) . "' WHERE item_id='". (int)$this->db->escape($data['iitemid']) ."'");
    }

    public function insertMstItemSize($data = array()) {
        $this->db2->query("INSERT INTO mst_item_size SET item_id = '" . (int)$this->db->escape($data['iitemid']) . "', unit_id = '" . (int)$this->db->escape($data['unit_id']) . "', unit_value = '" . $this->db->escape($data['unit_value']) . "',SID = '" . (int)($this->session->data['sid'])."'");
    }

    public function getMstPlcbItem($id) {
        $query = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id='". (int)$id ."'");

        return $query->row;
    }

    public function updateMstPlcbItem($data = array()) {
        $this->db2->query("UPDATE mst_plcb_item SET bucket_id = '" . (int)$this->db->escape($data['bucket_id']) . "',prev_mo_beg_qty = '" . (int)$this->db->escape($data['prev_mo_beg_qty']) . "', prev_mo_end_qty = '" . (int)$this->db->escape($data['prev_mo_end_qty']) . "', malt = '" . (int)$this->db->escape($data['malt']) . "' WHERE item_id='". (int)$this->db->escape($data['iitemid']) ."'");
    }

    public function insertMstPlcbItem($data = array()) {
        $this->db2->query("INSERT INTO mst_plcb_item SET item_id = '" . (int)$this->db->escape($data['iitemid']) . "', bucket_id = '" . (int)$this->db->escape($data['bucket_id']) . "',prev_mo_beg_qty = '" . (int)$this->db->escape($data['prev_mo_beg_qty']) . "', prev_mo_end_qty = '" . (int)$this->db->escape($data['prev_mo_end_qty']) . "', malt = '" . (int)$this->db->escape($data['malt']) . "' ,SID = '" . (int)($this->session->data['sid'])."'");
    }

    

    public function getItemsSearchResult($search){

       $query = $this->db2->query("SELECT iitemid,vitemname FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($search). "%' OR vbarcode LIKE  '%" .$this->db->escape($search). "%' AND estatus='Active'");

        return $query->rows;
    }

}
?>