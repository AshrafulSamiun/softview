<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcTransactionMaster extends Model
{
    protected $fillable = ['company_id','journal_type_id','ac_year_id', 'ac_period_id', 'journal_id_prefix','journal_code','journal_id','journal_date','manual_voucher_no',  'amount','bank_id','payment_type','cheque_no','recept_no', 'mst_narration','form_name','qc_passed','is_approved', 'inserted_by','updated_by'];

    public function company()
	{
		return $this->belongsTo('App\Models\Company','company_id', 'id');
	}
}
