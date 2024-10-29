<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcTransactionDtls extends Model
{
    protected $fillable = [
        	'id','transaction_mst_id', 'account_code', 'ac_coa_mst_id','ac_description','sub_account_code', 'debit_amount', 'credit_amount','inserted_by','updated_by','currency_id','conversion_rate','debit_foreign_currency', 'credit_foreign_currency','cheque_no','recept_no', 'customer_id','customer_invoice','other_party_id','development_partner_id', 'supplier_id', 'supplier_invoice','instrument_number','instrument_date','instrument_type','division_id','department_id', 'section_id', 'location_id','export_lc_ref', 'import_ref', 'bank_ref','loan_ref','employee_id','employee_name','loan_type','narration','bank_id',
        ];

    public function accountcode()
	{
		return $this->belongsTo('App\AccountCode','ac_coa_mst_id', 'id');
	}
    public function division()
	{
		return $this->belongsTo('App\Division','division_id', 'id');
	}

    public function supplier()
	{
		return $this->belongsTo('App\Supplier','supplier_id', 'id');
	}
	public function location()
	{
		return $this->belongsTo('App\Location','location_id', 'id');
	}
	public function customer()
	{
		return $this->belongsTo('App\Buyer','customer_id', 'id');
	}
	public function department()
	{
		return $this->belongsTo('App\Department','department_id', 'id');
	}

	public function section()
	{
		return $this->belongsTo('App\Section','section_id', 'id');
	}

	public function bank()
	{
		return $this->belongsTo('App\Bank','bank_id', 'id');
	}

	public function otherParty()
	{
		return $this->belongsTo('App\OtherParty','other_party_id', 'id');
	}
	public function developmentPartner()
	{
		return $this->belongsTo('App\DevelopmentPartner','development_partner_id', 'id');
	}
}
