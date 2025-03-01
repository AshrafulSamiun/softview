import Hello from '../components/Temporary/Hello.vue'
import Dashboard from '../components/Dashboard.vue';
import Building from '../components/Property/Building.vue';
import AccountPeriod from '../components/New/AccountPeriod.vue';
import OpenFile from '../components/OpenFiles.vue';
import Calendar from '../components/Calendar.vue';
import AlertCentres from '../components/AlertCenter.vue';

import Bank from '../components/Account_Holders/Bank.vue';
import BoardofDirector from '../components/Account_Holders/BoardofDirector.vue';
import Client from '../components/Account_Holders/Client.vue';

import TempAccountNo from '../components/Temporary/AccountNo.vue';
import tempCompanyProfile from '../components/Temporary/Company-Profile.vue';
import businessType from '../components/Temporary/Management-Type.vue';
import industryType from '../components/Temporary/Industry-Type.vue';

import tempContactPerson from '../components/Temporary/Contact-Person.vue';
import tempServicePlan from '../components/Temporary/Service-Plan.vue';
import tempServiceContact from '../components/Temporary/Service-Contact.vue';
import tempTermCondition from '../components/Temporary/Term-Condition.vue';
import tempdeclaration from '../components/Temporary/Declaration.vue';
//import ShopingCard from '../components/Temporary/Shoping-Card.vue';
//import tempActivationStatus from '../components/Temporary/Activation-Status.vue';


//===================Transaction==============================================================
import PurchaseOffer from '../components/Transactions/Purchase-Offer.vue';

export const routes = [

    //============================Temp user============================================================================================
   

    { name: 'Temp-AccountNo',                 path: '/Temp-AccountNo',                component: TempAccountNo },
    { name: 'Temp-BusinessType',              path: '/Temp-BusinessType',             component: businessType},
    { name: 'Temp-IndustryType',              path: '/Temp-IndustryType',             component: industryType},
    { name: 'Temp-CompanyProfile',            path: '/Temp-CompanyProfile',           component: tempCompanyProfile },
    { name: 'Temp-ContactsPersons',           path: '/Temp-ContactsPersons',          component: tempContactPerson },
    { name: 'Temp-ServicePlan',               path: '/Temp-ServicePlan',              component: tempServicePlan },
    { name: 'Temp-ServiceContract',           path: '/Temp-ServiceContract',          component: tempServiceContact },
    { name: 'Temp-TermsOfAgreement',          path: '/Temp-TermsOfAgreement',         component: tempTermCondition},
    { name: 'Temp-Declaration',               path: '/Temp-Declaration',              component: tempServicePlan },
    { name: 'Temp-ShoppingCard',              path: '/Temp-ShoppingCard',             component: tempServicePlan },
    { name: 'Temp-ActivationStatus',          path: '/Temp-ActivationStatus',         component: tempServicePlan },

    // ============================New=============================================================================
    { name: '/',                              path: '/',                              component: Dashboard },
    { name: 'Calendar',                       path: '/Calendar',                      component: Calendar },
    { name: 'Company-Profile',                path: '/Company-Profile',               component: Hello },
    { name: 'Customer-Property',              path: '/Customer-Property',             component: Hello },
    { name: 'Application-Form',               path: '/Application-Form',              component: Hello },
    { name: 'Customer-Seller',                path: '/Customer-Seller',               component: Hello },
    { name: 'Customer-Service',               path: '/Customer-Service',              component: Hello },
    { name: 'Rule-Policy',                    path: '/Rule-Policy',                   component: Hello },
    { name: 'Procudure-Instruction',          path: '/Procudure-Instruction',         component: Hello },
    { name: 'Account-Holder',                 path: '/Account-Holder',               component: Hello },
    { name: 'Coa-Setting',                    path: '/Coa-Setting',                  component: Hello },
    { name: 'Chart-Accounts',                 path: '/Chart-Accounts',               component: Hello },
    { name: 'Taxes',                          path: '/Taxes',                        component: Hello },
    { name: 'Service-Item',                   path: '/Service-Item',                 component: Hello },
    { name: 'Inventory-Item',                 path: '/Inventory-Item',               component: Hello },
    { name: 'Fixed-Asset',                    path: '/Fixed-Asset',                  component: Hello },
    { name: 'Project',                        path: '/Project',                      component: Hello },
    { name: 'Utilities',                      path: '/Utilities',                    component: Hello },

    //================================Property===========================================================================================================
    { name: 'Building',                       path: '/Building',                      component: Building },
    { name: 'Floors',                         path: '/Floors',                        component: Hello },
    { name: 'ResidentalSuites',               path: '/ResidentalSuites',              component: Hello },
    { name: 'CommercialUnit',                 path: '/CommercialUnit',                component: Hello },
    { name: 'CommonArea',                     path: '/CommonArea',                    component: Hello },
    { name: 'SupportingRoom',                 path: '/SupportingRoom',                component: Hello },
    { name: 'ParkingLot',                     path: '/ParkingLot',                    component: Hello },
    { name: 'Bike-Lot',                       path: '/Bike-Lot',                      component: Hello },
    { name: 'Storage-Lot',                    path: '/Storage-Lot',                   component: Hello },
    { name: 'Mail-Room',                      path: '/Mail-Room',                     component: Hello },
    { name: 'Property-Attrebution',           path: '/Property-Attrebution',          component: Hello },
    { name: 'NewPostingJobs',                 path: '/NewPostingJobs',                component: Hello },
    { name: 'PostingHousingRental',           path: '/PostingHousingRental',          component: Hello },
    { name: 'Modules',                        path: '/Modules',                       component: Hello },
    { name: 'Menus',                          path: '/Menus',                         component: Hello },
    { name: 'Open-File',                      path: '/Open-File',                     component: OpenFile },
    { name: 'AlertCentres',                   path: '/AlertCentres',                  component: AlertCentres },
    //=======================================Transaction=================================================================================
    { name: 'Purchase-Offer',                 path: '/Purchase-Offer',                component: PurchaseOffer },
    { name: 'Purchase',                       path: '/Purchase',                      component: Hello },
    { name: 'Sales',                          path: '/Sales',                         component: Hello },
    { name: 'Forms',                          path: '/Forms',                         component: Hello },

    //============================Account Holder=========================================
    { name: 'Bank',                           path: '/Bank',                          component: Bank },
    { name: 'BoardofDirector',                path: '/BoardofDirector',               component: BoardofDirector },
    { name: 'Client',                         path: '/Client',                        component: Client },
    { name: 'CreditCardCompany',              path: '/CreditCardCompany',             component: Hello },
    { name: 'Customer',                       path: '/Customer',                      component: Hello },
    { name: 'Donor',                          path: '/Donor',                         component: Hello },
    { name: 'Employee',                       path: '/Employee',                      component: Hello },
    { name: 'Government',                     path: '/Government',                    component: Hello },
    { name: 'Investor',                       path: '/Investor',                      component: Hello },
    { name: 'Landlord',                       path: '/Landlord',                      component: Hello },
    { name: 'Leaseholder',                    path: '/Leaseholder',                   component: Hello },
    { name: 'PrivateLoanLender',              path: '/PrivateLoanLender',             component: Hello },
    { name: 'ServiceProvider',                path: '/ServiceProvider',               component: Hello},
    { name: 'Shareholder',                    path: '/Shareholder',                   component: Hello },
    { name: 'Student',                        path: '/Student',                       component: Hello },
    { name: 'Seller',                         path: '/Seller',                        component: Hello },
    { name: 'Tenant',                         path: '/Tenant',                        component: Hello },
    { name: 'Visitor',                        path: '/Visitor',                       component: Hello },
    { name: 'Volunteer',                      path: '/Volunteer',                     component: Hello },
    //===========================Account Holder finish================================================

    { name: 'Users',                          path: '/Users',                         component: Hello },
    { name: 'User-Privilige',                 path: '/User-Privilige',                component: Hello },
    { name: 'User-Info',                      path: '/User-Info',                     component: Hello },
    { name: 'Company-Info',                   path: '/Company-Info',                  component: Hello },
    { name: 'Countries',                      path: '/Countries',                     component: Hello },
    { name: 'Proviences',                     path: '/Proviences',                    component: Hello },
    { name: 'ServicePlans',                   path: '/ServicePlans',                  component: Hello },
    { name: 'Account-Floor',                  path: '/Account-Floor',                 component: Hello },
    { name: 'Account-Suites',                 path: '/Account-Suites',                component: Hello },
    { name: 'Account-Maintenance-Room',       path: '/Account-Maintenance-Room',      component: Hello },
    { name: 'Account-Parking',                path: '/Account-Parking',               component: Hello },
    { name: 'Account-Lockers',                path: '/Account-Lockers',               component: Hello },
    { name: 'FireExtinguisher-Locations',     path: '/FireExtinguisher-Locations',    component: Hello },
    { name: 'TowerInspection-Checklist',      path: '/TowerInspection-Checklist',     component: Hello },
    { name: 'Account-Sprinkler',              path: '/Account-Sprinkler',             component: Hello },
    { name: 'Account-Breakers',               path: '/Account-Breakers',              component: Hello },
    { name: 'Account-EmergencyExits',         path: '/Account-EmergencyExits',        component: Hello },
    { name: 'EmergencyWater-ShutDown',        path: '/EmergencyWater-ShutDown',       component: Hello },
    { name: 'Account-ServicesContractors',    path: '/Account-ServicesContractors',   component: Hello },
    { name: 'Account-FirePanel',              path: '/Account-FirePanel',             component: Hello },
    { name: 'Account-GymEquipments',          path: '/Account-GymEquipments',         component: Hello },
    { name: 'Account-SwimmingPool ',          path: '/Account-SwimmingPool ',         component: Hello },
    { name: 'Account-Compactor ',             path: '/Account-Compactor ',            component: Hello },
    { name: 'Account-Elevator',               path: '/Account-Elevator',              component: Hello },
    { name: 'Account-AED',                    path: '/Account-AED',                   component: Hello },
    { name: 'Account-SecurityCamera ',        path: '/Account-SecurityCamera ',       component: Hello },
    { name: 'Account-FOB',                    path: '/Account-FOB',                   component: Hello },
    { name: 'Account-ScheduledInspection',    path: '/Account-ScheduledInspection',   component: Hello },
    { name: 'Account-ScheduledServices',      path: '/Account-ScheduledServices',     component: Hello },
    { name: 'Account-SafeBox',                path: '/Account-SafeBox',               component: Hello },
    { name: 'Account-PhoneCable',             path: '/Account-PhoneCable',            component: Hello },
    { name: 'General-Info',                   path: '/General-Info',                  component: Hello },
    { name: 'Account-period',                 path: '/Account-period',                component: AccountPeriod }
];