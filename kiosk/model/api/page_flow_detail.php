<?php
class ModelApiPageFlowDetail extends Model {
    public function getPageFlowDetail($MenuDetailId = null,$PageId = null,$db2) {
        // $query = $db2->query("SELECT a.*,b.* FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON(a.PageId=b.PageId) where a.MenuDetailId='".$MenuDetailId."' ORDER BY a.ReceiptPrintSeq");
        $query = $db2->query("SELECT a.*,b.*,c.*,d.vitemname,TO_BASE64(d.itemimage) as image_string FROM kiosk_page_flow_detail a LEFT JOIN kiosk_page_master b ON(b.PageId=a.PageId) LEFT JOIN kiosk_page_flow_header c ON(c.PageId=a.PageId) LEFT JOIN mst_item d ON(d.iitemid=a.iitemid) where a.PageId='".$PageId."' AND c.MenuDetailId='". $MenuDetailId ."' ORDER BY a.DisplaySeq");
        
        return $query->rows;
    }

}
?>