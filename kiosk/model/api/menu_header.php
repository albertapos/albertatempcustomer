<?php
class ModelApiMenuHeader extends Model {
    public function getMenuHeaders($db2) {
       
        $query = $db2->query("SELECT MenuId,Title,StartTime,Status,SID,LastUpdate,EndTime,RowSize,ColumnSize,Sequence,TO_BASE64(ImageLoc) as image_string FROM kiosk_menu_header ORDER BY Sequence");

        return $query->rows;
    }

}
?>