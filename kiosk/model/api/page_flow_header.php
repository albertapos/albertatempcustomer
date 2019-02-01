<?php
class ModelApiPageFlowHeader extends Model {
    public function getPageFlowHeaders($MenuDetailId = null,$db2) {
        $query = $db2->query("SELECT a.*,b.* FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON(a.PageId=b.PageId) where a.MenuDetailId='".$MenuDetailId."' ORDER BY a.ReceiptPrintSeq");
        
        return $query->rows;
    }

}
?>