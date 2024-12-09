<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountContactPerson extends Model
{
     protected $fillable = [
        'head_office_legal_name', 'authorize_person_legal_name','account_payable_legal_name','contact_person_legal_name',
        'system_admin_legal_name',
        'head_office_country', 'authorize_person_country','account_payable_country','contact_person_country','system_admin_country',
        'head_office_provience', 'authorize_person_provience','account_payable_provience','contact_person_provience',
        'system_admin_provience',
        'head_office_city', 'authorize_person_city','account_payable_city','contact_person_city','system_admin_city',
        'head_office_street_no', 'authorize_person_street_no','account_payable_street_no','contact_person_street_no',
        'system_admin_street_no',
        'head_office_postal_code', 'authorize_person_postal_code','account_payable_postal_code','contact_person_postal_code',
        'system_admin_postal_code',
        'head_office_po_box', 'authorize_person_po_box','account_payable_po_box','contact_person_po_box','system_admin_po_box',
        'head_office_bussiness_no', 'authorize_person_bussiness_no','account_payable_bussiness_no','contact_person_bussiness_no',
        'system_admin_bussiness_no',
        'head_office_office_phone', 'authorize_person_office_phone','account_payable_office_phone','contact_person_office_phone',
        'system_admin_office_phone',
        'head_office_cell_phone', 'authorize_person_cell_phone','account_payable_cell_phone','contact_person_cell_phone',
        'system_admin_cell_phone',
        'head_office_fax_no', 'authorize_person_fax_no','account_payable_fax_no','contact_person_fax_no','system_admin_fax_no',
        'head_office_email', 'authorize_person_email','account_payable_email','contact_person_email','system_admin_email',
        'head_office_website', 'authorize_person_website','account_payable_website','contact_person_website','system_admin_website',
       
        'project_id', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}
