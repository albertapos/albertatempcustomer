<?php
class ModelApiMenuItem extends Model {
    public function getMenuItems($CategoryId,$MenuId,$db2) {
        $query = $db2->query("SELECT a.*,b.vitemname,TO_BASE64(b.itemimage) as image_string FROM kiosk_menu_item a,mst_item b WHERE a.CategoryId='". $CategoryId ."' AND a.MenuId='". $MenuId ."' AND a.iitemid=b.iitemid ORDER BY a.DisplayPosition");
        
        return $query->rows;
    }

    public function getMenuItemImage($iitemid,$db2){
        $query = $db2->query("SELECT TO_BASE64(itemimage) as image_string FROM mst_item WHERE iitemid='". $iitemid ."'")->row;

        return $query;
    }

}
?>