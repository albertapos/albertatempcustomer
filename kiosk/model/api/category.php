<?php
class ModelApiCategory extends Model {
    public function getCategories() {
        $query = $this->db2->query("SELECT CategoryId,MenuId,Category,Sequence,StartEndTime,Status,SID,LastUpdate,RowSize,ColumnSize FROM kiosk_category");
        
        return $query->rows;
    }

    public function getCategoriesByMenu($menu_id,$db2) {
        $query = $db2->query("SELECT CategoryId,MenuId,Category,Sequence,StartEndTime,Status,SID,LastUpdate,RowSize,ColumnSize,TO_BASE64(ImageLoc) as image_string FROM kiosk_category WHERE MenuId='". $menu_id ."' ORDER BY Sequence");
        
        return $query->rows;
    }
}
?>