<?php
class ModelApiItemDeleteVoidReport extends Model {

	public function getItemReport($data = array()){

        $sql = "SELECT trn_sd.isalesid as isalesid, trn_sd.idettrnid as idettrnid, trn_sd.vitemcode as vitemcode, trn_sd.vitemname as vitemname,trn_sd.ndebitqty as ndebitqty,trn_sd.nunitprice as nunitprice, trn_sd.nextunitprice as nextunitprice, trn_s.iuserid as iuserid, trn_s.vusername as vusername, trn_s.vtrntype as vtrntype, date_format(trn_s.dtrandate,'%m-%d-%Y %H:%i:%s') as trn_date_time FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE  date_format(trn_s.dtrandate,'%m-%d-%Y') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%m-%d-%Y') <= '".$data['end_date']."' AND trn_s.isalesid=trn_sd.isalesid AND (trn_s.vtrntype='Void' OR trn_s.vtrntype='Delete')";

        $query = $this->db2->query($sql);

        $return_data =array();

        $return_data['voids'] = $query->rows;

        $sql1 = "SELECT mdi.barcode as vitemcode, mdi.itemname as vitemname, mdi.qty as ndebitqty, mdi.unitprice as nunitprice, mdi.extprice as nextunitprice, 'Delete' as vtrntype, CONCAT(mu.vfname,' ',mu.vlname) as vusername, date_format(mdi.LastUpdate,'%m-%d-%Y %H:%i:%s') as trn_date_time FROM mst_deleteditem mdi LEFT JOIN mst_user mu ON(mu.iuserid=mdi.userid) WHERE date_format(mdi.LastUpdate,'%m-%d-%Y') >= '".$data['start_date']."' AND date_format(mdi.LastUpdate,'%m-%d-%Y') <= '".$data['end_date']."'";

        $query1 = $this->db2->query($sql1);

        $return_data['deletes'] = $query1->rows;

        return $return_data;
	}
}
