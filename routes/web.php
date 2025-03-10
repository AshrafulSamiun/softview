<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//========================Test Link===================================
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
Route:: get ('/email', function () {
	Mail::to('a.i.bhouiyan@gmail.com')->send(new WelcomeMail());
   return new WelcomeMail();
});

//===========================End Test Link=============================

Route::middleware('web')->group(function () {
   // Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'create']);
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('user/activation/{user_id}', 'Auth\RegisterController@userActivation');


Route:: get ('/about-us', function () {
   return view('about_us');
});
Route::get('/', 'HomeRouteController@home_menu');
Route::get('/about-us', 'HomeRouteController@about_us')->name('about-us');
Route::get('/plan', 'HomeRouteController@plan')->name('plan');
Route::get('/contact-us', 'HomeRouteController@contact_us')->name('contact-us');


Route:: get ('/multiform', function () {
   return view('multiform');
});
Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::get('send/message', 'SendMessageController@getVerify');
Route::post('send/message', 'SendMessageController@postVerify');
Route::get('all-chart', 'ChartController@all_chart');

// Forget User name routes
Route::get('username/request', 'Auth\SendsUserNameController@showLinkRequestForm')->name('username.request');
Route::post('username/email', 'Auth\SendsUserNameController@sendUsernameEmail')->name('username.email');
Route::get('pinCode/request', 'Auth\SendsUserNameController@showPinRequestForm')->name('pincode.request');
Route::post('pinCode/email', 'Auth\SendsUserNameController@sendPinCodeEmail')->name('pincode.email');

//=========================Captcha=====================================================
Route::get('refresh_captcha', 'Auth\RegisterController@refresh_captcha')->name('refresh_captcha');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['auth', 'twofactor']], function () { 

	Route::resource('userDashboards','userDashboardController');
	Route::get('/userIncubate','AccountCrospondentController@userIncubate');
	Route::resource('AccountCrospondents','AccountCrospondentController');
	Route::get('/userIncubate','DashboardController@userIncubate');
	Route::get('OpenFiles','OpenFileController@index');
	Route::post('OpenFiles','OpenFileController@open_files');
	Route::resource('Users','UserController');
	Route::get('UserTypeData/{user_type}','UserController@UserTypeData');
	Route::resource('UserPrivileges','UserPrivilegeController');
	Route::get('UserPrivilegeList','UserPrivilegeController@UserPrivilegeList');
	Route::post('UserPrivilegePost/{id}','UserPrivilegeController@post');
	Route::post('UserPrivilegeVoid/{id}','UserPrivilegeController@void');
	Route::post('UserPrivilegeReject/{id}','UserPrivilegeController@reject');
	Route::post('adjustUserPrivilege/{id}','UserPrivilegeController@adjust');
	Route::post('UserPrivilegeRepost/{id}','UserPrivilegeController@repost');

	Route::resource('UserProfiles','UserProfileController');
	Route::get('UserPermission/{menu_name}','UserPrivilegeController@UserPermission');
	Route::get('/ProjectUser','UserController@project_user');
	Route::get('loadMenuByModule/{moule_id}','MenuController@loadMenuByModule');

	Route::post('/image/store', 'ImageController@store');
	Route::post('/image/update', 'ImageController@update');
	Route::post('/upload-photo', 'ImageController@photo_upload');



	//Route::get('all-chart', 'ChartController@all_chart');
	Route::resource('AccountSetups','AccountSetupController');
	
	Route::resource('Calendars','CalendarController');
	//Route::get('CalendarData/{year}','CalendarController@Calendar');
	Route::get('CalendarList/{year}','CalendarController@CalendarLists');
 	Route::post('CalendarPost/{id}','CalendarController@post');
	Route::post('adjustCalendar/{id}','CalendarController@adjust');
	Route::post('CalendarRepost/{id}','CalendarController@repost');

	Route::resource('AllertCentres','AllertCentreController');
	Route::resource('SiteDashboards','SiteDashboardController');

 	Route::resource('JobSites','profile\JobSiteController');
 	Route::get('JobSiteList','profile\JobSiteController@JobSiteLists');
 	Route::post('JobSitePost/{id}','profile\JobSiteController@post');
	Route::post('adjustJobSite/{id}','profile\JobSiteController@adjust');
	Route::post('JobSiteRepost/{id}','profile\JobSiteController@repost');



	Route::resource('CustomerPropertys','CustomerPropertyController');
	Route::get('loadCustomerByCompany/{company_id}','CustomerPropertyController@loadCustomerByCompany');
	Route::get('loadFloorByBuilding/{building_id}','FloorController@loadFloorByBuilding');
	Route::get('loadBuildingByCustomer/{company_id}/{customer_id}','BuildingInfoController@loadBuildingByCustomer');

	Route::resource('CompanyProfiles','CompanyProfileController');
	Route::resource('ApplicationForms','ApplicationFormController');
	Route::resource('CustomerSellers','CustomerSellerController');
	Route::resource('CustomerServiceProviders','CustomerServiceProviderController');
	Route::resource('RulesPolicys','RulesPolicyController');
	Route::resource('ProcedureInstructions','ProcedureInstructionController');
	Route::resource('CoaSettings','CoaSettingController');
	Route::resource('ChartOfAccounts','ChartOfAccountController');

	Route::resource('PostingJobs','PostingJobsController');
	Route::resource('PostingHousingRental','PostingHousingRentalController');

	

	Route::get('provience_by_country/{country}', 'provienceController@get_provience_by_country');
	Route::get('Dashboard/', 'DashboardController@index')->name('dashboard');
	Route::get('Dashboard/Module/{module_id}','DashboardController@user_module')->name('user_module');
	Route::resource('UserCompanies','UserCompanyController');
	Route::resource('BuildingInfos','BuildingInfoController');
	Route::get('BuildingInfoLits','BuildingInfoController@BuildingInfoLits');


	Route::resource('PropertyManagementTypes','PropertyManagementTypeController');
	Route::resource('IndustryType','IndustryTypeController');
	Route::resource('UserServicePlans','UserServicePlanController');
	Route::resource('userServiceContacts','userServiceContactController');
	Route::resource('TermsOfAggrements','TermsOfAggrementController');
	Route::resource('DocumentSubmitions','DocumentSubmitionController');
	Route::resource('DocumentSubmitions','DocumentSubmitionController');
	Route::resource('AccountActivations','AccountActivationController');
	Route::resource('AccountContactPersons','AccountContactPersonController');
	

	Route::post('RegistrationInstruction','AccountActivationController@registration_instruction');

	Route::resource('Countries','CountryController');
	Route::resource('proviences','provienceController');
	Route::resource('Menus','MenuController');
	Route::resource('Modules','ModuleController');
	Route::resource('ServicePlans','ServicePlanController');

			
	Route::resource('Companies','CompanyController');
	Route::resource('CustomFields','CustomFieldController');
	Route::post('AddCustomContacts','CustomFieldController@customContactStor');





	Route::resource('Floors','FloorController');
	Route::get('FloorLists','FloorController@FloorLists');

	Route::resource('ResidentialSuites','ResidentialSuiteController');
	Route::get('ResidentialSuitesLists','ResidentialSuiteController@ResidentialSuitesLists');
	Route::get('loadSuiteByFloor/{floor_id}/{suite_no}','ResidentialSuiteController@loadSuiteByFloor');
	Route::get('FloorDataByBuilding/{building_id}','ResidentialSuiteController@FloorDataByBuilding');
	Route::get('UnitFloorDataByBuilding/{building_id}','CommercialUnitController@FloorDataByBuilding');

	Route::get('loadUnitByFloor/{floor_id}/{unit_no}','CommercialUnitController@loadUnitByFloor');

	Route::resource('CommercialUnits','CommercialUnitController');
	Route::get('CommercialUnitLits','CommercialUnitController@CommercialUnitLits');


	Route::resource('SupportingRooms','SupportingRoomController');
	Route::get('SupportingRoomLists','SupportingRoomController@SupportingRoomLists');
	Route::get('subroomFloorByBuilding/{building_id}','SupportingRoomController@subroomFloorByBuilding');
	Route::get('loadSubroomsByFloor/{building_id}','SupportingRoomController@loadSubroomsByFloor');

	Route::resource('MailRooms','MailRoomController');
	Route::get('MailRoomLits','MailRoomController@MailRoomLits');
	//Route::get('CommercialUnitLits','MailRoomController@CommercialUnitLits');
	Route::get('MailRoomFloorByBuilding/{building_id}','MailRoomController@MailRoomFloorByBuilding');
	Route::get('loadMailBoxByFloor/{floor_id}/{room_no}','MailRoomController@loadMailBoxByFloor');

	Route::resource('ParkingLots','ParkingLotController');
	Route::get('ParkingFloorDataByBuilding/{building_id}','ParkingLotController@ParkingFloorDataByBuilding');
	Route::get('loadParkingLotByFloor/{floor_id}','ParkingLotController@loadParkingLotByFloor');
	Route::get('ParkingLotsList','ParkingLotController@ParkingLotsList');


	Route::resource('BikeLots','BikeLotController');
	Route::get('BikeFloorDataByBuilding/{building_id}','BikeLotController@BikeFloorDataByBuilding');
	Route::get('loadBikeLotByFloor/{floor_id}','BikeLotController@loadBikeLotByFloor');
	Route::get('BikeLotsList','BikeLotController@BikeLotsList');

	Route::resource('StorageLots','StorageLotController');
	Route::get('StorageFloorDataByBuilding/{building_id}','StorageLotController@StorageFloorDataByBuilding');
	Route::get('loadStorageLotByFloor/{floor_id}','StorageLotController@loadStorageLotByFloor');
	Route::get('StorageLotsList','StorageLotController@StorageLotsList');

	Route::resource('PropertyAttributions','PropertyAttributionController');
	Route::get('PropertyAttributionsList','PropertyAttributionController@PropertyAttributionsList');
	Route::get('loadPropertyByCompany/{company_id}','PropertyAttributionController@loadPropertyByCompany');
	Route::get('PropertyAttBuilding/{company}/{customer}/{building_type}','PropertyAttributionController@property_building');
	Route::get('SuiteByBuilding/{building_id}/{suite_type}','PropertyAttributionController@suite_by_building');
	Route::get('UnitByBuilding/{building_id}/{unit_type}','PropertyAttributionController@unit_by_building');
	Route::get('PropertyByBuilding/{building_id}','PropertyAttributionController@property_by_building');

	Route::resource('CommonAreas','CommonAreaController');
	Route::get('CommonAreaList','CommonAreaController@CommonAreaList');
	Route::get('CommonAreaFloorDataByBuilding/{building_id}','CommonAreaController@FloorDataByBuilding');
	Route::get('loadCommonAreaByFloor/{floor_id}','CommonAreaController@loadCommonAreaByFloor');

	Route::resource('AccountHolders','AccountHolderController');
	Route::get('AccountHolderLists','AccountHolderController@AccountHolderLists');
	Route::post('AddCustomCoa','CoaSettingController@customCoaStore');
	Route::resource('TaxTypes','TaxTypeController');
	Route::get('TaxTypesList','TaxTypeController@TaxTypesList');
	Route::resource('inventoryItems','inventoryItemController');
	Route::get('inventoryItemList','inventoryItemController@inventoryItemList');
	Route::get('inventoryItemData','inventoryItemController@inventoryItemData');

	Route::resource('ServiceItems','ServiceItemController');
	Route::get('serviceItemList','ServiceItemController@serviceItemList');
	Route::post('AddServiceCategory','CustomFieldController@AddServiceCategory');
	Route::resource('FixedAssets','FixedAssetController');
	Route::get('fixedAssetList','FixedAssetController@fixed_asset_List');
	Route::get('account_holder_by_type/{type}','AccountHolderController@account_holder_by_type');
	

	Route::resource('PropertyProjects','PropertyProjectController');
	Route::get('PropertyProjectsList','PropertyProjectController@PropertyProjectsList');

    Route::get('ProjectByBuilding/{building_id}','PropertyProjectController@property_by_building');
    //Route::get('suiteByFloor/{floor_id}','PropertyProjectController@suite_by_floor');



   Route::resource('PurchaseOffers','Purchase\PurchaseOfferController');
	Route::get('PurchaseOfferList','Purchase\PurchaseOfferController@PurchaseOfferList');
	Route::post('PurchaseOfferPost/{id}','Purchase\PurchaseOfferController@post');
	Route::post('adjustPurchaseOffer/{id}','Purchase\PurchaseOfferController@adjust');
	Route::post('PurchaseOfferRepost/{id}','Purchase\PurchaseOfferController@repost');
	Route::resource('PurchaseOfferAcceptances','Purchase\PurchaseOfferAcceptanceController');
	Route::get('PurchaseOfferAcceptanceList','Purchase\PurchaseOfferAcceptanceController@PurchaseOfferAcceptanceList');
	Route::resource('PurchaseOrders','Purchase\PurchaseOrderController');
	Route::get('PurchaseOrderList','Purchase\PurchaseOrderController@PurchaseOrderList');
	Route::resource('PurchasePackingSlips','Purchase\PurchasePackingSlipController');
	Route::get('PurchasePackingSlipList','Purchase\PurchasePackingSlipController@PurchasePackingSlipList');
	Route::resource('PurchaseReturns','Purchase\PurchaseReturnController');
	Route::get('PurchaseReturnList','Purchase\PurchaseReturnController@PurchaseReturnList');
	Route::resource('PurchaseDebitNotes','Purchase\PurchaseDebitNoteController');
	Route::get('PurchaseDebitList','Purchase\PurchaseDebitNoteController@PurchaseDebitList');
	Route::resource('PurchaseCreditNotes','Purchase\PurchaseCreditNoteController');
	Route::get('PurchaseCreditList','Purchase\PurchaseCreditNoteController@PurchaseCreditList');
	Route::resource('PurchaseInvoices','Purchase\PurchaseInvoiceController');
	Route::get('PurchaseInvoiceList','Purchase\PurchaseInvoiceController@PurchaseInvoiceList');
	Route::get('PurchaseSummery','Purchase\PurchaseInvoiceController@PurchaseSummery');
	Route::resource('DirectPayments','Purchase\DirectPaymentController');
	Route::get('DirectPaymentList','Purchase\DirectPaymentController@DirectPaymentList');



   /*=========================Sales ===================================================================*/
	Route::resource('SalesOffers','Sales\SalesOfferController');
	Route::get('SalesOfferList','Sales\SalesOfferController@SalesOfferList');
	Route::post('SalesOfferPost/{id}','Sales\SalesOfferController@post');
	Route::post('adjustSalesOffer/{id}','Sales\SalesOfferController@adjust');
	Route::post('SalesOfferRepost/{id}','Sales\SalesOfferController@repost');
	Route::resource('SalesOfferAcceptances','Sales\SalesOfferAcceptanceController');
	Route::get('SalesOfferAcceptanceList','Sales\SalesOfferAcceptanceController@SalesOfferAcceptanceList');
	Route::resource('SalesOrders','Sales\SalesOrderController');
	Route::get('SalesOrderList','Sales\SalesOrderController@SalesOrderList');
	Route::resource('SalesPackingSlips','Sales\SalesPackingSlipController');
	Route::get('SalesPackingSlipList','Sales\SalesPackingSlipController@SalesPackingSlipList');
	Route::resource('SalesReturns','Sales\SalesReturnController');
	Route::get('SalesReturnList','Sales\SalesReturnController@SalesReturnList');
	Route::resource('SalesDebitNotes','Sales\SalesDebitNoteController');
	Route::get('SalesDebitList','Sales\SalesDebitNoteController@SalesDebitList');
	Route::resource('SalesCreditNotes','Sales\SalesCreditNoteController');
	Route::get('SalesCreditList','Sales\SalesCreditNoteController@SalesCreditList');
	Route::resource('SalesInvoices','Sales\SalesInvoiceController');
	Route::get('SalesInvoiceList','Sales\SalesInvoiceController@SalesInvoiceList');
	Route::get('SalesSummery','Sales\SalesInvoiceController@SalesSummery');
	Route::resource('SaleDirectPayments','Sales\DirectPaymentController');
	Route::get('SaleDirectPaymentList','Sales\DirectPaymentController@DirectPaymentList');

	Route::resource('FormEntrys','OperatingModule\FormEntryController');
	Route::get('FormEntryList','OperatingModule\FormEntryController@FormEntryList');
	Route::post('FormEntrysrPost/{id}','OperatingModule\FormEntryController@post');
	Route::post('FormEntrysOffer/{id}','OperatingModule\FormEntryController@adjust');
	Route::post('FormEntrysRepost/{id}','OperatingModule\FormEntryController@repost');

	Route::resource('MaintenanceRooms','MaintenanceRoomController');




	//=========================Message============================================

	Route::get('AdminMessages', 'MessageAdminController@index')->name('AdminMessages'); 
	Route::get('UserMessages', 'MessageAdminController@index')->name('UserMessages');  
	Route::get('AdminInbox', 'MessageAdminInboxController@index')->name('AdminInbox'); 
	Route::post('/adminDelete/{id}', 'MessageAdminInboxController@adminDelete'); 
	Route::resource('AdminNew','MessageAdminNewController');
	Route::get('AdminMessageView', 'MessageAdminMessageViewController@index')->name('AdminMessageView'); 

	//=========================Announcement=======================================================

   Route::resource('Announcements','Information\AnnouncementController');
	Route::get('AnnouncementList/{type}','Information\AnnouncementController@AnnouncementList');
	Route::post('AnnouncementPost/{id}','Information\AnnouncementController@post');
	Route::post('adjustAnnouncement/{id}','Information\AnnouncementController@adjust');
	Route::post('AnnouncementRepost/{id}','Information\AnnouncementController@repost');


	//======================Account Holder===============================================

	Route::resource('AccountHoldersBank','AccountHolder\AccountHolderBankController');
	Route::get('AccountHolderBankLists','AccountHolder\AccountHolderBankController@AccountHolderBankLists');
	Route::post('AccountHoldersBankPost/{id}','AccountHolder\AccountHolderBankController@post');
	Route::post('adjustAccountHoldersBank/{id}','AccountHolder\AccountHolderBankController@adjust');
	Route::post('AccountHoldersBankRepost/{id}','AccountHolder\AccountHolderBankController@repost');
	Route::post('AccountHoldersBankVoid/{id}','AccountHolder\AccountHolderBankController@void');
	Route::post('AccountHoldersBankReject/{id}','AccountHolder\AccountHolderBankController@reject');
	Route::get('AccountHolderBankPostingType/{id}','AccountHolder\AccountHolderBankController@list_by_posting_type');
	Route::get('AccountHolderBankPostingStatus','AccountHolder\AccountHolderBankController@posting_status');
	Route::get('AccountHoldersBankPrintPdf/{id}','AccountHolder\AccountHolderBankController@pdf_print');
	Route::get('AccountHoldersBankPrintAll/{type}/{style}','AccountHolder\AccountHolderBankController@pdf_print_all');




	Route::resource('AccountHolderBoardOfDirector','AccountHolder\AccountHolderBoardOfDirectorController');
	Route::get('AccountHolderBoardOfDirectorLists','AccountHolder\AccountHolderBoardOfDirectorController@AccountHolderBoardOfDirectorLists');
	Route::post('BoardOfDirectorPost/{id}','AccountHolder\AccountHolderBoardOfDirectorController@post');
	Route::post('adjustBoardOfDirector/{id}','AccountHolder\AccountHolderBoardOfDirectorController@adjust');
	Route::post('BoardOfDirectorRepost/{id}','AccountHolder\AccountHolderBoardOfDirectorController@repost');
	Route::post('BoardOfDirectorVoid/{id}','AccountHolder\AccountHolderBoardOfDirectorController@void');
	Route::post('BoardOfDirectorReject/{id}','AccountHolder\AccountHolderBoardOfDirectorController@reject');
	Route::get('BoardOfDirectorPostingType/{id}','AccountHolder\AccountHolderBoardOfDirectorController@list_by_posting_type');
	Route::get('BoardOfDirectorPostingStatus','AccountHolder\AccountHolderBoardOfDirectorController@posting_status');
	Route::get('BoardOfDirectorPrintPdf/{id}','AccountHolder\AccountHolderBoardOfDirectorController@pdf_print');
	Route::get('AccountHoldersBoardOfDirectorPrintAll/{type}/{style}','AccountHolder\AccountHolderBoardOfDirectorController@pdf_print_all');
	

	Route::resource('AccountHoldersClient','AccountHolder\AccountHolderClientController');
	Route::get('AccountHolderClientLists','AccountHolder\AccountHolderClientController@AccountHolderClientLists');
	Route::post('AccountHoldersClientPost/{id}','AccountHolder\AccountHolderClientController@post');
	Route::post('adjustAccountHoldersClient/{id}','AccountHolder\AccountHolderClientController@adjust');
	Route::post('AccountHoldersClientRepost/{id}','AccountHolder\AccountHolderClientController@repost');
	Route::post('AccountHoldersClientVoid/{id}','AccountHolder\AccountHolderClientController@void');
	Route::post('AccountHoldersClientReject/{id}','AccountHolder\AccountHolderClientController@reject');
	Route::get('AccountHoldersClientPostingType/{id}','AccountHolder\AccountHolderClientController@list_by_posting_type');
	Route::get('AccountHoldersClientPostingStatus','AccountHolder\AccountHolderClientController@posting_status');
	Route::get('AccountHoldersClientPrintPdf/{id}','AccountHolder\AccountHolderClientController@pdf_print');
	Route::get('AccountHoldersAccountHoldersClientPrintAll/{type}/{style}','AccountHolder\AccountHolderClientController@pdf_print_all');
	
	Route::resource('AccountHolderCreditCardCompany','AccountHolder\AccountHolderCreditCardCompanyController');
	Route::get('AccountHolderCreditCardCompanyLists','AccountHolder\AccountHolderCreditCardCompanyController@AccountHolderCreditCardCompanyLists');
	Route::post('PurchaseOfferPost/{id}','Purchase\PurchaseOfferController@post');
	Route::post('adjustPurchaseOffer/{id}','Purchase\PurchaseOfferController@adjust');
	Route::post('PurchaseOfferRepost/{id}','Purchase\PurchaseOfferController@repost');

	Route::resource('AccountHolderCustomer','AccountHolder\AccountHolderCustomerController');
	Route::get('AccountHolderCustomerLists','AccountHolder\AccountHolderCustomerController@AccountHolderCustomerLists');
	Route::post('PurchaseOfferPost/{id}','Purchase\PurchaseOfferController@post');
	Route::post('adjustPurchaseOffer/{id}','Purchase\PurchaseOfferController@adjust');
	Route::post('PurchaseOfferRepost/{id}','Purchase\PurchaseOfferController@repost');

	Route::resource('AccountHolderDonor','AccountHolder\AccountHolderDonorController');
	Route::get('AccountHolderDonorLists','AccountHolder\AccountHolderDonorController@AccountHolderDonorLists');
	Route::post('DonorPost/{id}','Purchase\AccountHolderDonorController@post');
	Route::post('adjustDonor/{id}','Purchase\AccountHolderDonorController@adjust');
	Route::post('DonorRepost/{id}','Purchase\AccountHolderDonorController@repost');

	Route::resource('AccountHolderEmployee','AccountHolder\AccountHolderEmployeeController');
	Route::get('AccountHolderEmployeeLists','AccountHolder\AccountHolderEmployeeController@AccountHolderEmployeeLists');
	Route::post('EmployeePost/{id}','Purchase\AccountHolderEmployeeController@post');
	Route::post('adjustEmployee/{id}','Purchase\AccountHolderEmployeeController@adjust');
	Route::post('EmployeeRepost/{id}','Purchase\AccountHolderEmployeeController@repost');

	Route::resource('AccountHolderGovernment','AccountHolder\AccountHolderGovernmentController');
	Route::get('AccountHolderGovernmentLists','AccountHolder\AccountHolderGovernmentController@AccountHolderGovernmentLists');
	Route::post('GovernmentPost/{id}','Purchase\AccountHolderGovernmentController@post');
	Route::post('adjustGovernment/{id}','Purchase\AccountHolderGovernmentController@adjust');
	Route::post('GovernmentRepost/{id}','Purchase\AccountHolderGovernmentController@repost');

	Route::resource('AccountHolderInvestor','AccountHolder\AccountHolderInvestorController');
	Route::get('AccountHolderInvestorLists','AccountHolder\AccountHolderInvestorController@AccountHolderInvestorLists');
	Route::post('InvestorPost/{id}','Purchase\AccountHolderInvestorController@post');
	Route::post('adjustInvestor/{id}','Purchase\AccountHolderInvestorController@adjust');
	Route::post('InvestorRepost/{id}','Purchase\AccountHolderInvestorController@repost');

	Route::resource('AccountHolderLandlord','AccountHolder\AccountHolderLandlordController');
	Route::get('AccountHolderLandlordLists','AccountHolder\AccountHolderLandlordController@AccountHolderLandlordLists');
	Route::post('LandlordPost/{id}','Purchase\AccountHolderLandlordController@post');
	Route::post('adjustLandlord/{id}','Purchase\AccountHolderLandlordController@adjust');
	Route::post('LandlordRepost/{id}','Purchase\AccountHolderLandlordController@repost');


	Route::resource('AccountHolderLeaseholder','AccountHolder\AccountHolderLeaseholderController');
	Route::get('AccountHolderLeaseholderLists','AccountHolder\AccountHolderLeaseholderController@AccountHolderLeaseholderLists');
	Route::post('LeaseholderPost/{id}','Purchase\AccountHolderLeaseholderController@post');
	Route::post('adjustLeaseholder/{id}','Purchase\AccountHolderLeaseholderController@adjust');
	Route::post('LeaseholderRepost/{id}','Purchase\AccountHolderLeaseholderController@repost');

	Route::resource('AccountHolderPrivateLoanLender','AccountHolder\AccountHolderPrivateLoanLenderController');
	Route::get('AccountHolderPrivateLoanLenderLists','AccountHolder\AccountHolderPrivateLoanLenderController@AccountHolderPrivateLoanLenderLists');
	Route::post('PrivateLoanPost/{id}','Purchase\AccountHolderPrivateLoanLenderController@post');
	Route::post('adjustPrivateLoan/{id}','Purchase\AccountHolderPrivateLoanLenderController@adjust');
	Route::post('PrivateLoanRepost/{id}','Purchase\AccountHolderPrivateLoanLenderController@repost');
	
	Route::resource('AccountHolderSeller','AccountHolder\AccountHolderSellerController');
	Route::get('AccountHolderSellerLists','AccountHolder\AccountHolderSellerController@AccountHolderSellerLists');
	Route::post('SellerPost/{id}','Purchase\AccountHolderSellerController@post');
	Route::post('adjustSeller/{id}','Purchase\AccountHolderSellerController@adjust');
	Route::post('SellerRepost/{id}','Purchase\AccountHolderSellerController@repost');

	Route::resource('AccountHolderServiceProvider','AccountHolder\AccountHolderServiceProviderController');
	Route::get('AccountHolderServiceProviderLists','AccountHolder\AccountHolderServiceProviderController@AccountHolderServiceProviderLists');
	Route::post('ServiceProviderPost/{id}','Purchase\AccountHolderServiceProviderController@post');
	Route::post('adjustServiceProvider/{id}','Purchase\AccountHolderServiceProviderController@adjust');
	Route::post('ServiceProviderRepost/{id}','Purchase\AccountHolderServiceProviderController@repost');


	Route::resource('AccountHolderShareholder','AccountHolder\AccountHolderShareholderController');
	Route::get('AccountHolderShareholderLists','AccountHolder\AccountHolderShareholderController@AccountHolderShareholderLists');
	Route::post('ShareholderPost/{id}','Purchase\AccountHolderShareholderController@post');
	Route::post('adjustShareholder/{id}','Purchase\AccountHolderShareholderController@adjust');
	Route::post('ShareholderRepost/{id}','Purchase\AccountHolderShareholderController@repost');


	Route::resource('AccountHolderStudent','AccountHolder\AccountHolderStudentController');
	Route::get('AccountHolderStudentLists','AccountHolder\AccountHolderStudentController@AccountHolderStudentLists');
	Route::post('StudentPost/{id}','Purchase\AccountHolderStudentController@post');
	Route::post('adjustStudent/{id}','Purchase\AccountHolderStudentController@adjust');
	Route::post('StudentRepost/{id}','Purchase\AccountHolderStudentController@repost');
	
	Route::resource('AccountHolderTenant','AccountHolder\AccountHolderTenantController');
	Route::get('AccountHolderTenantLists','AccountHolder\AccountHolderTenantController@AccountHolderTenantLists');
	Route::post('TenantPost/{id}','Purchase\AccountHolderTenantLists@post');
	Route::post('adjustTenant/{id}','Purchase\AccountHolderTenantLists@adjust');
	Route::post('TenantRepost/{id}','Purchase\AccountHolderTenantLists@repost');

	Route::resource('AccountHolderVisitor','AccountHolder\AccountHolderVisitorController');
	Route::get('AccountHolderVisitorLists','AccountHolder\AccountHolderVisitorController@AccountHolderVisitorLists');
	Route::post('VisitorPost/{id}','Purchase\AccountHolderVisitorController@post');
	Route::post('adjustVisitor/{id}','Purchase\AccountHolderVisitorController@adjust');
	Route::post('VisitorRepost/{id}','Purchase\AccountHolderVisitorController@repost');

	Route::resource('AccountHolderVolunteer','AccountHolder\AccountHolderVolunteerController');
	Route::get('AccountHolderVolunteerLists','AccountHolder\AccountHolderVolunteerController@AccountHolderVolunteerLists');
	Route::post('VolunteerPost/{id}','Purchase\AccountHolderVolunteerController@post');
	Route::post('adjustVolunteer/{id}','Purchase\AccountHolderVolunteerController@adjust');
	Route::post('VolunteerRepost/{id}','Purchase\AccountHolderVolunteerController@repost');













	Route::resource('Parkings','ParkingController');
	Route::resource('Lockers','LockersController');
	Route::resource('FireExtinguisherLocations','FireExtinguisherLocationsController');
	Route::resource('TowserInspectionChecklists','TowserInspectionChecklistController');
	Route::resource('Breakers','BreakersController');
	Route::resource('Sprinklers','SprinklerController');




	Route::resource('Elevators','ElevatorController');
	Route::resource('EmergencyExits','EmergencyExitsController');
	Route::resource('FirePanels','FirePanelController');
	//Route::resource('Floors','FloorController');
	Route::resource('FirstAidEquipments','FirstAidEquipmentController');
	Route::resource('FOBSystems','FOBSystemController');
	Route::resource('GymEquipments','GymEquipmentsController');
	Route::resource('PhoneAndCables','PhoneAndCableController');
	Route::resource('SafeBoxs','SafeBoxController');
	Route::resource('ScheduledInspections','ScheduledInspectionController');
	Route::resource('SecurityCameras','SecurityCameraController');
	Route::resource('ServiceContractors','ServiceContractorController');


	Route::resource('SwimmingPools','SwimmingPoolController');


});


Route::get('api/rootMenu-dropdown', 'ApiController@rootMenuDropDownData');
Route::get('api/left_menu_list', 'ApiController@rootLeftMenu');






