<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\User;

class BillService{

    public function getBillByUser(User $user){
        return Bill::where('user_id', $user->id)->select('id','title','description','value','number_installment','payment_method','responsible','status')->get();
    }
}
