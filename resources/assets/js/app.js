
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform';

import VueProgressBar from 'vue-progressbar';


Vue.component(HasError.name,HasError);
Vue.component(AlertError.name, AlertError);

import objectToFormData from "./objectToFormData";
 window.objectToFormData = objectToFormData;
//import { objectToFormData } from 'object-to-formdata';
//const objectToFormData = window.objectToFormData

//import objectToFormData from "objectToFormData"; 
//window.objectToFormData = objectToFormData;

import Swal from 'sweetalert2';
window.Swal=Swal;

const toast = Swal.mixin({
  toast: true,
  position: 'center',
  showConfirmButton: false,
  timer: 3000
});

window.toast=toast;


window.Form=Form;
import VueRouter from 'vue-router' 

Vue.use(VueRouter);


//import VeeValidate from 'vee-validate';
//window.VeeValidate=VeeValidate;
//Vue.use(window.VeeValidate);

Vue.use(VueProgressBar, {
  color: '#d908a5',
  failedColor: '#874b4b',
  thickness: '45px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 500
  },
  autoRevert: true,
  position:'absolute',
  top:'400px',

  inverse: false
});


let routes = [

//============================Temp user============================================================================================
 { name: 'Temp-Management-Type',           path: '/Temp-Management-Type',          component: require('./components/Temporary/Management-Type.vue') },
 { name: 'Temp-CompanyProfile',            path: '/Temp-CompanyProfile',           component: require('./components/Temporary/Company-Profile.vue') },
 { name: 'Temp-ContactsPersons',           path: '/Temp-ContactsPersons',          component: require('./components/Temporary/Contact-Person.vue') },
 { name: 'Temp-ServicePlan',               path: '/Temp-ServicePlan',              component: require('./components/Temporary/Service-Plan.vue') },
 { name: 'Temp-ServiceContract',           path: '/Temp-ServiceContract',          component: require('./components/Temporary/Service-Contact.vue') },
 { name: 'Temp-TermsOfAgreement',          path: '/Temp-TermsOfAgreement',         component: require('./components/Temporary/Term-Condition.vue') },
 { name: 'Temp-DocumentsSubmission',       path: '/Temp-DocumentsSubmission',      component: require('./components/Temporary/Document-Submition.vue') },
 { name: 'Temp-ActivationStatus',          path: '/Temp-ActivationStatus',         component: require('./components/Temporary/Activation-Status.vue') },

// ============================New============================================================================= 
 { name: 'Company-Profile',                path: '/Company-Profile',               component: require('./components/New/Company-Profile.vue') },
 { name: 'Customer-Property',              path: '/Customer-Property',             component: require('./components/New/Customer-Property.vue') },
 { name: 'Application-Form',               path: '/Application-Form',              component: require('./components/Application-Form.vue') },
 { name: 'Customer-Seller',                path: '/Customer-Seller',               component: require('./components/New/Customer-Seller.vue') },
 { name: 'Customer-Service',               path: '/Customer-Service',              component: require('./components/New/Customer-Service.vue') },
 { name: 'Rule-Policy',                    path: '/Rule-Policy',                   component: require('./components/New/Rule-Policy.vue') },
 { name: 'Procudure-Instruction',          path: '/Procudure-Instruction',         component: require('./components/New/Procudure-Instruction.vue') },
 { name: 'Account-Holder',                 path: '/Account-Holder',               component: require('./components/New/AccountHolder.vue') },
 { name: 'Coa-Setting',                    path: '/Coa-Setting',                  component: require('./components/New/CoaSetting.vue') },
 { name: 'Chart-Accounts',                 path: '/Chart-Accounts',               component: require('./components/New/Coa.vue') },



 { name: 'Taxes',                          path: '/Taxes',                        component: require('./components/New/Taxs.vue') },

 { name: 'Service-Item',                   path: '/Service-Item',                 component: require('./components/New/ServiceItems.vue') },

 { name: 'Inventory-Item',                 path: '/Inventory-Item',               component: require('./components/New/InventoryItems.vue') },

 { name: 'Fixed-Asset',                    path: '/Fixed-Asset',                  component: require('./components/New/FixedAsset.vue') },
 { name: 'Project',                        path: '/Project',                      component: require('./components/New/Project.vue') },
 { name: 'Utilities',                      path: '/Utilities',                    component: require('./components/New/Utilities.vue') },


//================================Property===========================================================================================================

 { name: 'Building',                       path: '/Building',                      component: require('./components/Property/Building.vue') },
 { name: 'Floors',                         path: '/Floors',                        component: require('./components/Property/Floor.vue') },
 { name: 'ResidentalSuites',               path: '/ResidentalSuites',              component: require('./components/Property/ResidentalSuite.vue') },
 { name: 'CommercialUnit',                 path: '/CommercialUnit',                component: require('./components/Property/CommericalUnit.vue') },
 { name: 'CommonArea',                     path: '/CommonArea',                    component: require('./components/Property/CommonArea.vue') },
 { name: 'SupportingRoom',                 path: '/SupportingRoom',                component: require('./components/Property/SupportingRoom.vue') },
 { name: 'ParkingLot',                     path: '/ParkingLot',                    component: require('./components/Property/ParkingLot.vue') },
 { name: 'Bike-Lot',                       path: '/Bike-Lot',                      component: require('./components/Property/BikeLot.vue') },
 { name: 'Storage-Lot',                    path: '/Storage-Lot',                   component: require('./components/Property/StorageLot.vue') },

 { name: 'Mail-Room',                      path: '/Mail-Room',                     component: require('./components/Property/MailRoom.vue') },
 { name: 'Property-Attrebution',           path: '/Property-Attrebution',          component: require('./components/Property/PropertyAttrebution.vue') },  




   
 { name: 'NewPostingJobs',                 path: '/NewPostingJobs',                component: require('./components/market_place/NewPostingJobs.vue') },
 { name: 'PostingHousingRental',           path: '/PostingHousingRental',          component: require('./components/market_place/NewPostingJobshosing.vue') },
  

 { name: 'Modules',                        path: '/Modules',                       component: require('./components/Module.vue') },
 { name: 'Menus',                          path: '/Menus',                         component: require('./components/Menu.vue') },
 
 { name: 'Open-File',                      path: '/Open-File',                     component: require('./components/OpenFiles.vue') },
//=======================================Transaction=================================================================================
 { name: 'Purchase',                       path: '/Purchase',                      component: require('./components/Operating_Module/Purchase.vue') },
 { name: 'Sales',                          path: '/Sales',                         component: require('./components/Operating_Module/Sales.vue') },

 { name: 'Forms',                          path: '/Forms',                         component: require('./components/Operating_Module/Forms.vue') },


//============================Account Holder=========================================

{ name: 'Bank',                           path: '/Bank',                          component: require('./components/Account_Holders/Bank.vue') },
{ name: 'BoardofDirector',                path: '/BoardofDirector',               component: require('./components/Account_Holders/BoardofDirector.vue') },

  
{ name: 'Client',                         path: '/Client',                        component: require('./components/Account_Holders/Client.vue') },
{ name: 'CreditCardCompany',              path: '/CreditCardCompany',             component: require('./components/Account_Holders/CreditCardCompany.vue') },
{ name: 'Customer',                       path: '/Customer',                      component: require('./components/Account_Holders/Customer.vue') },
{ name: 'Donor',                          path: '/Donor',                         component: require('./components/Account_Holders/Donor.vue') },
{ name: 'Employee',                       path: '/Employee',                      component: require('./components/Account_Holders/Employee.vue') },
{ name: 'Government',                     path: '/Government',                    component: require('./components/Account_Holders/Government.vue') },
{ name: 'Investor',                       path: '/Investor',                      component: require('./components/Account_Holders/Investor.vue') },
{ name: 'Landlord',                       path: '/Landlord',                      component: require('./components/Account_Holders/Landlord.vue') },
{ name: 'Leaseholder',                    path: '/Leaseholder',                   component: require('./components/Account_Holders/Leaseholder.vue') },
{ name: 'PrivateLoanLender',              path: '/PrivateLoanLender',             component: require('./components/Account_Holders/PrivateLoanLender.vue') },
{ name: 'ServiceProvider',                path: '/ServiceProvider',               component: require('./components/Account_Holders/ServiceProvider.vue') },
{ name: 'Shareholder',                    path: '/Shareholder',                   component: require('./components/Account_Holders/Shareholder.vue') },

{ name: 'Student',                        path: '/Student',                       component: require('./components/Account_Holders/Student.vue') },
{ name: 'Seller',                         path: '/Seller',                        component: require('./components/Account_Holders/Seller.vue') },
{ name: 'Tenant',                         path: '/Tenant',                        component: require('./components/Account_Holders/Tenant.vue') },
{ name: 'Visitor',                        path: '/Visitor',                       component: require('./components/Account_Holders/Visitor.vue') },
{ name: 'Volunteer',                      path: '/Volunteer',                     component: require('./components/Account_Holders/Volunteer.vue') },

//===========================Account Holder finish================================================


 { name: 'Users',                          path: '/Users',                         component: require('./components/User.vue') },
 { name: 'User-Privilige',                 path: '/User-Privilige',                component: require('./components/UserPrivilige.vue') },
 { name: 'User-Info',                      path: '/User-Info',                     component: require('./components/UserProfile.vue') },
 { name: 'Company-Info',                   path: '/Company-Info',                  component: require('./components/Account_Setup/CompanyInfo.vue') },
 { name: 'Countries',                      path: '/Countries',                     component: require('./components/Setting/Coutry.vue') },
 { name: 'Proviences',                     path: '/Proviences',                    component: require('./components/Setting/Provience.vue') },
 { name: 'ServicePlans',                   path: '/ServicePlans',                  component: require('./components/Setting/ServicePlan.vue') },


 { name: 'Account-Floor',                  path: '/Account-Floor',                 component: require('./components/Account_Setup/floor.vue') },
 { name: 'Account-Suites',                 path: '/Account-Suites',                component: require('./components/Account_Setup/suits.vue') },
 { name: 'Account-Maintenance-Room',       path: '/Account-Maintenance-Room',      component: require('./components/Account_Setup/maintainanceRoom.vue') },
 { name: 'Account-Parking',                path: '/Account-Parking',               component: require('./components/Account_Setup/Parking.vue') },
 { name: 'Account-Lockers',                path: '/Account-Lockers',               component: require('./components/Account_Setup/lockers.vue') },
 { name: 'FireExtinguisher-Locations',     path: '/FireExtinguisher-Locations',    component: require('./components/Account_Setup/fireexLocation.vue') },
 { name: 'TowerInspection-Checklist',      path: '/TowerInspection-Checklist',     component: require('./components/Account_Setup/TowerInspectionCheckList.vue') },
 { name: 'Account-Sprinkler',              path: '/Account-Sprinkler',             component: require('./components/Account_Setup/SprinkLer.vue') },
 { name: 'Account-Breakers',               path: '/Account-Breakers',              component: require('./components/Account_Setup/Breakers.vue') },

 { name: 'Account-EmergencyExits',         path: '/Account-EmergencyExits',        component: require('./components/Account_Setup/EmergencyExist.vue') },
 { name: 'EmergencyWater-ShutDown',        path: '/EmergencyWater-ShutDown',       component: require('./components/Account_Setup/EmergencyWaterShutDown.vue') },
 { name: 'Account-ServicesContractors',    path: '/Account-ServicesContractors',   component: require('./components/Account_Setup/ServicesAndControctor.vue') },
 { name: 'Account-FirePanel',              path: '/Account-FirePanel',             component: require('./components/Account_Setup/FirePanel.vue') },
 { name: 'Account-GymEquipments',          path: '/Account-GymEquipments',         component: require('./components/Account_Setup/gymEquipments.vue') },
 { name: 'Account-SwimmingPool ',          path: '/Account-SwimmingPool ',         component: require('./components/Account_Setup/SwimingPool.vue') },
 { name: 'Account-Compactor ',             path: '/Account-Compactor ',            component: require('./components/Account_Setup/compactor.vue') },
 { name: 'Account-Elevator',               path: '/Account-Elevator',              component: require('./components/Account_Setup/Elevator.vue') },
 { name: 'Account-AED',                    path: '/Account-AED',                   component: require('./components/Account_Setup/AED.vue') },



 { name: 'Account-SecurityCamera ',        path: '/Account-SecurityCamera ',       component: require('./components/Account_Setup/securityCamera.vue') },
 { name: 'Account-FOB',                    path: '/Account-FOB',                   component: require('./components/Account_Setup/fobSystem.vue') },
 { name: 'Account-ScheduledInspection',    path: '/Account-ScheduledInspection',   component: require('./components/Account_Setup/seduleInspection.vue') },
 { name: 'Account-ScheduledServices',      path: '/Account-ScheduledServices',     component: require('./components/Account_Setup/seduleService.vue') },
 { name: 'Account-SafeBox',                path: '/Account-SafeBox',               component: require('./components/Account_Setup/safeBox.vue') },
 { name: 'Account-PhoneCable',             path: '/Account-PhoneCable',            component: require('./components/Account_Setup/phoneAndCable.vue') },
 { name: 'General-Info',                   path: '/General-Info',                  component: require('./components/Account_Setup/GeneralInfo.vue') },

{ name: 'Account-period',           path: '/Account-period',          component: require('./components/New/AccountPeriod.vue') },






  //{ name: 'Account-Elevator',              path: '/Account-Elevator',             component: require('./components/Account_Setup/SprinkLervue.vue') },
  //{ name: 'Account-AED',               path: '/Account-AED',              component: require('./components/Account_Setup/Breakers.vue') },

  //{ name: 'Groups',                 path: '/Groups',                  component: require('./components/Groups.vue') },
  //{ name: 'Divisions',              path: '/Divisions',               component: require('./components/Divisions.vue') },
  //{ name: 'Departments',            path: '/Departments',             component: require('./components/Departments.vue') },
  //{ name: 'Sections',               path: '/Sections',                component: require('./components/Sections.vue') },
  //{ name: 'Jurnal',                 path: '/Jurnal',                  component: require('./components/Jurnal.vue') },
  //{ name: 'Location-Profile',       path: '/Location-Profile',        component: require('./components/Location.vue') },
  //{ name: 'Suppliers',              path: '/Suppliers',               component: require('./components/Suppliers.vue') },
  //{ name: 'Buyers',                 path: '/Buyers',                  component: require('./components/Buyers.vue') },
  //{ name: 'Banks',                  path: '/Banks',                   component: require('./components/Banks.vue') },
  //{ name: 'Company',                path: '/Company',                 component: require('./components/Companies.vue') },
  //{ name: 'Jornal-Prifix',          path: '/Jornal-Prifix',           component: require('./components/Jurnal.vue') },
  
  //{ name: 'Chart-Accounts',         path: '/Chart-Accounts',          component: require('./components/ChartOfAccounts.vue') },
  //{ name: 'Journal-Entry',          path: '/Journal-Entry',           component: require('./components/JournalEntry.vue') },


  //{ name: 'Balance-Sheet',          path: '/Balance-Sheet',           component: require('./components/BalanceSheet.vue') },
  //{ name: 'Synconization-Process',  path: '/Synconization-Process',   component: require('./components/SynconizationProcess.vue') },
  //{ name: 'Trial-Balance',          path: '/Trial-Balance',           component: require('./components/TrialBalance.vue') },
  //{ name: 'Synconization-Process',  path: '/Synconization-Process',   component: require('./components/SynconizationProcess.vue') },
  //{ name: 'Income-Statement',       path: '/Income-Statement',        component: require('./components/IncomeStatement.vue') },
  //{ name: 'Supplier-Ledger',        path: '/Supplier-Ledger',         component: require('./components/SupplierLedger.vue') },
  //{ name: 'Customer-Ledger',        path: '/Customer-Ledger',         component: require('./components/CustomerLedger.vue') },


  

]



/**SupplierProfile
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
//Vue.component('data-viewer', require('./components/DataViewer.vue'));

const router = new VueRouter({
  history: true,
  routes // short for `routes: routes`

})

const app = new Vue({
    el: '#app',
    router
});
