<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHolderSeller extends Model
{
    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','seller_name','seller_photo','seller_office_phone','seller_cell_phone','seller_email','seller_fax_no','seller_website', 'seller_house_number', 'seller_street_number','seller_city', 'seller_state','seller_country','seller_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','professional_license_associate_name', 'professional_license_title', 'professional_license_house_number', 'professional_license_street_number','professional_license_city',  'professional_license_state', 'professional_license_country','professional_license_zip_code','professional_license_email', 'professional_license_fax_no', 'professional_office_phone','professional_license_cell_phone','professional_license_website','professional_license_no','professional_license_expire_date','professional_license_renewal_date','company_id','professional_license_validation_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name','item_for_sale','industry_type']; 


    // ALTER TABLE `account_holder_service_providers` ADD `emergency_contact_company_name` VARCHAR(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD `emergency_contact_logo` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD `emergency_contact_house_number` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD `emergency_contact_street_number` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD `emergency_contact_city` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD`emergency_contact_state` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, ADD `emergency_contact_country` INT(10) NULL DEFAULT '0', ADD `emergency_contact_zip_code` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci


     
}
