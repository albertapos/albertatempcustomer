<?php
class ModelKioskTableAction extends Model {
	public function checkProductSku($data) {


		try {

			$i = 0;
			foreach($data as $key=>$value){

				$que= $this->db2->query("SELECT * FROM mst_item where vbarcode = $value");
				
				if(count($que->rows) > 0){
					$i++;
				}
			}
		}
		catch (MySQLDuplicateKeyException $e) {
		    // echo $e;
		    // exit;

		}
		catch (MySQLException $e) {
		    // echo $e;
		    // exit;
		}
		catch (Exception $e) {
		  // echo $e;
		  // exit;
		}

		return $i;
	}
}
