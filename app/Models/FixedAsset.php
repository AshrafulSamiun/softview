<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    protected $fillable = [ 'project_id','company_id', 'asset_category','sub_category', 'system_prefix','system_no',  'asset_name',  'asset_description', 'manufacturar', 'size', 'serial_no', 'uom', 'condition', 'model','color', 'barcode','comments','length_uom', 'item_length', 'width_uom','item_width', 'height_uom', 'item_height','weight', 'weight_scale','warranty_expire_date', 'uses_status','service_location',  'cost_center', 'income_center', 'project', 'depriciation_method', 'insurance_coverage_period', 'insurance_company', 'insurance_expiry_date', 'insurance_policy_number', 'purchase_invoice', 'sales_invoice', 'dispose', 'write_off', 'warranty_documents', 'maintenance_records', 'service_contracts', 'insurance_policies', 'seller_invoice_date', 'write_off_reason', 'write_off_date', 'write_off_reason', 'write_off_comments', 'service_provider_id', 'customer_id', 'customer_invoice_amount', 'customer_invoice_date', 'customer_invoice_number', 'customer_delivery_date', 'customer_payment_method', 'customer_paid_amount', 'customer_receipt_no', 'customer_receipt_date' , 'customer_transaction_no', 'customer_transaction_date', 'seller_invoice_amount', 'seller_invoice_date', 'seller_invoice_number', 'seller_delivery_date', 'seller_payment_method', 'seller_paid_amount', 'seller_payment_no', 'seller_payment_date', 
    	'seller_transaction_no', 'seller_transaction_date', 'seller_id', 'inserted_by', 'updated_by', 'status_active', 'is_deleted',
	];
}
