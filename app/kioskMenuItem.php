<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class kioskMenuItem extends Model
{
   protected $connection = 'mysql2';
    protected $table = 'kiosk_menu_item';

   
    public function category()
    {
        return $this->belongsTo('pos2020\kioskCategory','CategoryId','CategoryId');
    }
    public function pages()
    {
        return $this->hasMany('pos2020\kioskPageFlowHeader','MenuDetailId','MenuDetailId');
    }
    public function menus()
    {
        return $this->hasMany('pos2020\kioskMenuHeader','MenuId','MenuId');
    }
   
     public function getProductImageAttribute(){
        return url('/api/admin/products/image/'. $this->attributes['iitemid']);
    }
}
