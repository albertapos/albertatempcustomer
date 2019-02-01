<?php
class ModelApiHoldOrder extends Model {
    public function getPageFlowHeaders($data = array(),$db2,$sid) {
        $sucess = array();
        $db2->query("INSERT INTO web_trn_hold_order SET Quantity = '" . (int)$data['Quantity'] . "', Amount = '" . $this->db->escape($data['Amount']) . "', SID = '" . (int)$sid."', Source = 'web', isPaid = 0, Status = 'pending'");

        $OrderId = $db2->getLastId();

        if (isset($data['products']) && count($data['products']) > 0) {
            foreach ($data['products'] as $product) {
                $db2->query("INSERT INTO web_trn_hold_order_items SET OrderId = '" . (int)$OrderId . "', ItemId = '" . (int)$product['iitemid'] . "', Qty = '" . (int)$product['Qty'] . "', Price = '" . $this->db->escape($product['Price']) . "', Amount = '" . $this->db->escape($product['TotalPrice']) . "', SID = '" . (int)$sid."'");

                $TransId = $db2->getLastId();
                if(isset($product['childItems']) && count($product['childItems']) > 0){
                    foreach ($product['childItems'] as $option) {
                        $db2->query("INSERT INTO web_trn_hold_order_details SET TransId = '" . (int)$TransId . "', ItemId = '" . (int)$product['iitemid'] . "', SubItemId = '" . (int)$option['iitemid'] . "', PrintSeq = '" . (int)$option['DisplaySeq'] . "', Price = '" . $this->db->escape($option['Price']) . "', SID = '" . (int)$sid."'");
                    }
                }
            }
        }
        $sucess['success'] = 'Order Placed Successfully!';
        $sucess['OrderId'] = $OrderId;
        
        return $sucess;

    }

}
?>