<?php
class ModelApiTemplate extends Model {
    public function getTemplates($data = array()) {
        $data = array();

        $sql = "SELECT * FROM mst_template";

        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE itemplateid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= ' ORDER BY LastUpdate DESC';

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $templates = $this->db2->query($sql)->rows;

        if(count($templates) > 0){
            foreach ($templates as $key => $template) {
                $templatedetails = $this->db2->query("SELECT * FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($template['itemplateid']) . "'")->rows;
                $data[$key] = $template;
                $data[$key]['items'] = $templatedetails;
            }
        }

        return $data;
    }

    public function getTemplatesTotal($data = array()) {
        $data = array();

        $sql = "SELECT * FROM mst_template";

        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE itemplateid= ". $this->db->escape($data['searchbox']);
        }

        $templates = $this->db2->query($sql)->rows;

        return count($templates);
    }

    public function getTemplate($itemplateid) {
        $data = array();

        $templates = $this->db2->query("SELECT * FROM mst_template WHERE itemplateid='" . (int)$itemplateid . "'")->row;

        $templatedetails = $this->db2->query("SELECT * FROM mst_templatedetail WHERE itemplateid='" . (int)$itemplateid . "'")->rows;
        $data = $templates;
        $data['items'] = $templatedetails;

        return $data;
    }

    public function deleteTemplateProduct($itemplateid, $Id) {
        $success = array();

        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_templatedetail',`Action` = 'delete',`TableId` = '" . (int)$Id . "',SID = '" . (int)($this->session->data['sid'])."'");

        $itemgroup = $this->db2->query("DELETE FROM mst_templatedetail WHERE itemplateid='" . (int)$itemplateid . "' AND Id='" . (int)$Id . "'");

        $success['success'] = 'Successfully Deleted Template Product';
        return $success;
    
    }

    public function getTemplateSearch($search) {
        
        $data = array();

        $templates = $this->db2->query("SELECT * FROM mst_template WHERE vtemplatename LIKE  '%" .$this->db->escape($search). "%' OR vtemplatetype LIKE  '%" .$this->db->escape($search). "%' OR vinventorytype LIKE  '%" .$this->db->escape($search). "%' ")->rows;

        foreach ($templates as $key => $template) {
            $templatedetails = $this->db2->query("SELECT * FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($template['itemplateid']) . "'")->rows;
            $data[$key] = $template;
            $data[$key]['items'] = $templatedetails;
        }

        return $data;
    }

    public function addTemplate($datas = array()) {

        $success =array();
        $error =array();

        $istoreid = $this->db2->query("SELECT * FROM mst_store")->row;
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO mst_template SET  vtemplatename = '" . $this->db->escape($data['vtemplatename']) . "',`vtemplatetype` = '" . $this->db->escape($data['vtemplatetype']) . "', vinventorytype = '" . $this->db->escape($data['vinventorytype']) . "',`isequence` = '" . $this->db->escape($data['isequence']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "', istoreid = '" . (int)$istoreid['istoreid'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $itemplateid = $this->db2->getLastId();

                    if((isset($data['items'])) && (count($data['items']) > 0) ){

                        foreach ($data['items'] as $k => $v) {
                           $this->db2->query("INSERT INTO mst_templatedetail SET  itemplateid = '" . (int)$itemplateid . "',`vitemcode` = '" . $this->db->escape($v['vitemcode']) . "', isequence = '" . (int)$this->db->escape($v['isequence']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                        
                    }
                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
            }
        }

        $success['success'] = 'Successfully Added Template';
        return $success;
    }

    public function editlistTemplate($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_template SET  vtemplatename = '" . $this->db->escape($data['vtemplatename']) . "',`vtemplatetype` = '" . $this->db->escape($data['vtemplatetype']) . "', vinventorytype = '" . $this->db->escape($data['vinventorytype']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "' WHERE itemplateid = '" . (int)$this->db->escape($data['itemplateid']) . "'");

                    if((isset($data['items'])) && (count($data['items']) > 0) ){

                        $template_ids = $this->db2->query("SELECT `Id` FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' ")->rows;

                        if(count($template_ids) > 0){
                            foreach ($template_ids as $k => $template_id) {
                                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_templatedetail',`Action` = 'delete',`TableId` = '" . (int)$template_id['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }

                        $this->db2->query("DELETE FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' ");
                        
                        foreach ($data['items'] as $k => $v) {


                            $templatedetails = $this->db2->query("SELECT * FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' AND vitemcode='" . $this->db->escape($v['vitemcode']) . "'")->row;

                            if(count($templatedetails) > 0){
                                $this->db2->query("UPDATE mst_templatedetail SET  isequence = '" . (int)$this->db->escape($data['isequence']) . "' WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' AND vitemcode='" . $this->db->escape($v['vitemcode']) . "'");
                            }else{
                                $this->db2->query("INSERT INTO mst_templatedetail SET  itemplateid = '" . (int)$this->db->escape($data['itemplateid']) . "',`vitemcode` = '" . $this->db->escape($v['vitemcode']) . "', isequence = '" . (int)$this->db->escape($v['isequence']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }
                        
                    }else{
                        $template_ids = $this->db2->query("SELECT `Id` FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' ")->rows;

                        if(count($template_ids) > 0){
                            foreach ($template_ids as $k => $template_id) {
                                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_templatedetail',`Action` = 'delete',`TableId` = '" . (int)$template_id['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }

                        $this->db2->query("DELETE FROM mst_templatedetail WHERE itemplateid='" . (int)$this->db->escape($data['itemplateid']) . "' ");
                    }

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }

            }

        }

        $success['success'] = 'Successfully Updated Template';
        return $success;
    }

}
?>