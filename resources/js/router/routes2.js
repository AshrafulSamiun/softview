import ManagementType from '../components/Temporary/Management-Type.vue'
import TaxCompanyProfile from '../components/Temporary/Company-Profile.vue'
import ContactPerson from '../components/Temporary/Contact-Person.vue'
import ServicePlan from '../components/Temporary/Service-Plan.vue'
import ServiceContact from '../components/Temporary/Service-Contact.vue'
import TermCondition from '../components/Temporary/Term-Condition.vue'
import DocumentSubmission from '../components/Temporary/Document-Submition.vue'
import ActivationStatus from '../components/Temporary/Activation-Status.vue'
import CompanyProfile from '../components/New/Company-Profile.vue';
import CustomerProperty from '../components/New/Customer-Property.vue';
import ApplicationForm from '../components/Application-Form.vue';
import CustomerSeller from '../components/New/Customer-Seller.vue';
import CustomerService from '../components/New/Customer-Service.vue';
import RulePolicy from '../components/New/Rule-Policy.vue';
import ProcedureInstruction from '../components/New/Procudure-Instruction.vue';
import AccountHolder from '../components/New/AccountHolder.vue';
import CoaSetting from '../components/New/CoaSetting.vue';
import ChartAccounts from '../components/New/Coa.vue';
import Taxes from '../components/New/Taxs.vue';
import ServiceItem from '../components/New/ServiceItems.vue';
import InventoryItem from '../components/New/InventoryItems.vue';
import FixedAsset from '../components/New/FixedAsset.vue';
import Project from '../components/New/Project.vue';
import Utilities from '../components/New/Utilities.vue';
import Building from '../components/Property/Building.vue';
import Floors from '../components/Property/Floor.vue';
import ResidentalSuites from '../components/Property/ResidentalSuite.vue';
import CommercialUnit from '../components/Property/CommericalUnit.vue';
import CommonArea from '../components/Property/CommonArea.vue';
import SupportingRoom from '../components/Property/SupportingRoom.vue';
import ParkingLot from '../components/Property/ParkingLot.vue';
import BikeLot from '../components/Property/BikeLot.vue';
import StorageLot from '../components/Property/StorageLot.vue';
import MailRoom from '../components/Property/MailRoom.vue';
import PropertyAttrebution from '../components/Property/PropertyAttrebution.vue';
import NewPostingJobs from '../components/market_place/NewPostingJobs.vue';
import NewPostingJobshosing from '../components/market_place/NewPostingJobshosing.vue';
import Modules from '../components/Module.vue';
import Menus from '../components/menu.vue';
import OpenFile from '../components/OpenFiles.vue';
import Purchase from '../components/Operating_Module/Purchase.vue';
import Sales from '../components/Operating_Module/Sales.vue';
import Forms from '../components/Operating_Module/Forms.vue';

import Bank from '../components/Account_Holders/Bank.vue';
import BoardofDirector from '../components/Account_Holders/BoardofDirector.vue';
import Client from '../components/Account_Holders/Client.vue';
import CreditCardCompany from '../components/Account_Holders/CreditCardCompany.vue';
import Customer from '../components/Account_Holders/Customer.vue';
import Donor from '../components/Account_Holders/Donor.vue';
import Employee from '../components/Account_Holders/Employee.vue';
import Government from '../components/Account_Holders/Government.vue';
import Investor from '../components/Account_Holders/Investor.vue';
import Landlord from '../components/Account_Holders/Landlord.vue';
import Leaseholder from '../components/Account_Holders/Leaseholder.vue';
import PrivateLoanLender from '../components/Account_Holders/PrivateLoanLender.vue';
import ServiceProvider from '../components/Account_Holders/ServiceProvider.vue';
import Shareholder from '../components/Account_Holders/Shareholder.vue';
import Student from '../components/Account_Holders/Student.vue';
import Seller from '../components/Account_Holders/Seller.vue';
import Tenant from '../components/Account_Holders/Tenant.vue';
import Visitor from '../components/Account_Holders/Visitor.vue';
import Volunteer from '../components/Account_Holders/Volunteer.vue';
import Users from '../components/User.vue';
import UserPrivilige from '../components/UserPrivilige.vue';
import UserProfile from '../components/UserProfile.vue';
import CompanyInfo from '../components/Account_Setup/CompanyInfo.vue';
import Countries from '../components/Setting/Coutry.vue';
import Proviences from '../components/Setting/Provience.vue';
import ServicePlans from '../components/Setting/ServicePlan.vue';
import AccountFloor from '../components/Account_Setup/floor.vue';
import AccountSuites from '../components/Account_Setup/suits.vue';
import AccountMaintenanceRoom from '../components/Account_Setup/maintainanceRoom.vue';
import AccountParking from '../components/Account_Setup/parking.vue';
import AccountLockers from '../components/Account_Setup/lockers.vue';
import FireExtinguisherLocations from '../components/Account_Setup/fireexLocation.vue';
import TowerInspectionChecklist from '../components/Account_Setup/TowerInspectionCheckList.vue';
import AccountSprinkler from '../components/Account_Setup/SprinkLer.vue';
import AccountBreakers from '../components/Account_Setup/Breakers.vue';
import AccountEmergencyExits from '../components/Account_Setup/EmergencyExist.vue';
import EmergencyWaterShutDown from '../components/Account_Setup/EmergencyWaterShutDown.vue';
import AccountServicesContractors from '../components/Account_Setup/ServicesAndControctor.vue';
import AccountFirePanel from '../components/Account_Setup/FirePanel.vue';
import AccountGymEquipments from '../components/Account_Setup/gymEquipments.vue';
import AccountSwimmingPool from '../components/Account_Setup/SwimingPool.vue';
import AccountCompactor from '../components/Account_Setup/compactor.vue';
import AccountElevator from '../components/Account_Setup/Elevator.vue';
import AccountAED from '../components/Account_Setup/AED.vue';
import AccountSecurityCamera from '../components/Account_Setup/securityCamera.vue';
import AccountFOB from '../components/Account_Setup/fobSystem.vue';
import AccountScheduledInspection from '../components/Account_Setup/seduleInspection.vue';
import AccountScheduledServices from '../components/Account_Setup/seduleService.vue';
import AccountSafeBox from '../components/Account_Setup/safeBox.vue';
import AccountPhoneCable from '../components/Account_Setup/phoneAndCable.vue';
import GeneralInfo from '../components/Account_Setup/GeneralInfo.vue';
import AccountPeriod from '../components/New/AccountPeriod.vue';

export const routes = [

    //============================Temp user============================================================================================
    { name: 'Temp-Management-Type',           path: '/Temp-Management-Type',          component: ManagementType },
    { name: 'Temp-CompanyProfile',            path: '/Temp-CompanyProfile',           component: TaxCompanyProfile },
    { name: 'Temp-ContactsPersons',           path: '/Temp-ContactsPersons',          component: ContactPerson },
    { name: 'Temp-ServicePlan',               path: '/Temp-ServicePlan',              component: ServicePlan },
    { name: 'Temp-ServiceContract',           path: '/Temp-ServiceContract',          component: ServiceContact },
    { name: 'Temp-TermsOfAgreement',          path: '/Temp-TermsOfAgreement',         component: TermCondition },
    { name: 'Temp-DocumentsSubmission',       path: '/Temp-DocumentsSubmission',      component: DocumentSubmission },
    { name: 'Temp-ActivationStatus',          path: '/Temp-ActivationStatus',         component: ActivationStatus },

    // ============================New=============================================================================
    { name: 'Company-Profile',                path: '/Company-Profile',               component: CompanyProfile },
    { name: 'Customer-Property',              path: '/Customer-Property',             component: CustomerProperty },
    { name: 'Application-Form',               path: '/Application-Form',              component: ApplicationForm },
    { name: 'Customer-Seller',                path: '/Customer-Seller',               component: CustomerSeller },
    { name: 'Customer-Service',               path: '/Customer-Service',              component: CustomerService },
    { name: 'Rule-Policy',                    path: '/Rule-Policy',                   component: RulePolicy },
    { name: 'Procudure-Instruction',          path: '/Procudure-Instruction',         component: ProcedureInstruction },
    { name: 'Account-Holder',                 path: '/Account-Holder',               component: AccountHolder },
    { name: 'Coa-Setting',                    path: '/Coa-Setting',                  component: CoaSetting },
    { name: 'Chart-Accounts',                 path: '/Chart-Accounts',               component: ChartAccounts },
    { name: 'Taxes',                          path: '/Taxes',                        component: Taxes },
    { name: 'Service-Item',                   path: '/Service-Item',                 component: ServiceItem },
    { name: 'Inventory-Item',                 path: '/Inventory-Item',               component: InventoryItem },
    { name: 'Fixed-Asset',                    path: '/Fixed-Asset',                  component: FixedAsset },
    { name: 'Project',                        path: '/Project',                      component: Project },
    { name: 'Utilities',                      path: '/Utilities',                    component: Utilities },

    //================================Property===========================================================================================================
    { name: 'Building',                       path: '/Building',                      component: Building },
    { name: 'Floors',                         path: '/Floors',                        component: Floors },
    { name: 'ResidentalSuites',               path: '/ResidentalSuites',              component: ResidentalSuites },
    { name: 'CommercialUnit',                 path: '/CommercialUnit',                component: CommercialUnit },
    { name: 'CommonArea',                     path: '/CommonArea',                    component: CommonArea },
    { name: 'SupportingRoom',                 path: '/SupportingRoom',                component: SupportingRoom },
    { name: 'ParkingLot',                     path: '/ParkingLot',                    component: ParkingLot },
    { name: 'Bike-Lot',                       path: '/Bike-Lot',                      component: BikeLot },
    { name: 'Storage-Lot',                    path: '/Storage-Lot',                   component: StorageLot },
    { name: 'Mail-Room',                      path: '/Mail-Room',                     component: MailRoom },
    { name: 'Property-Attrebution',           path: '/Property-Attrebution',          component: PropertyAttrebution },
    { name: 'NewPostingJobs',                 path: '/NewPostingJobs',                component: NewPostingJobs },
    { name: 'PostingHousingRental',           path: '/PostingHousingRental',          component: NewPostingJobshosing },
    { name: 'Modules',                        path: '/Modules',                       component: Modules },
    { name: 'Menus',                          path: '/Menus',                         component: Menus },
    { name: 'Open-File',                      path: '/Open-File',                     component: OpenFile },

    //=======================================Transaction=================================================================================
    { name: 'Purchase',                       path: '/Purchase',                      component: Purchase },
    { name: 'Sales',                          path: '/Sales',                         component: Sales },
    { name: 'Forms',                          path: '/Forms',                         component: Forms },

    //============================Account Holder=========================================
    { name: 'Bank',                           path: '/Bank',                          component: Bank },
    { name: 'BoardofDirector',                path: '/BoardofDirector',               component: BoardofDirector },
    { name: 'Client',                         path: '/Client',                        component: Client },
    { name: 'CreditCardCompany',              path: '/CreditCardCompany',             component: CreditCardCompany },
    { name: 'Customer',                       path: '/Customer',                      component: Customer },
    { name: 'Donor',                          path: '/Donor',                         component: Donor },
    { name: 'Employee',                       path: '/Employee',                      component: Employee },
    { name: 'Government',                     path: '/Government',                    component: Government },
    { name: 'Investor',                       path: '/Investor',                      component: Investor },
    { name: 'Landlord',                       path: '/Landlord',                      component: Landlord },
    { name: 'Leaseholder',                    path: '/Leaseholder',                   component: Leaseholder },
    { name: 'PrivateLoanLender',              path: '/PrivateLoanLender',             component: PrivateLoanLender },
    { name: 'ServiceProvider',                path: '/ServiceProvider',               component: ServiceProvider},
    { name: 'Shareholder',                    path: '/Shareholder',                   component: Shareholder },
    { name: 'Student',                        path: '/Student',                       component: Student },
    { name: 'Seller',                         path: '/Seller',                        component: Seller },
    { name: 'Tenant',                         path: '/Tenant',                        component: Tenant },
    { name: 'Visitor',                        path: '/Visitor',                       component: Visitor },
    { name: 'Volunteer',                      path: '/Volunteer',                     component: Volunteer },
    //===========================Account Holder finish================================================

    { name: 'Users',                          path: '/Users',                         component: Users },
    { name: 'User-Privilige',                 path: '/User-Privilige',                component: UserPrivilige },
    { name: 'User-Info',                      path: '/User-Info',                     component: UserProfile },
    { name: 'Company-Info',                   path: '/Company-Info',                  component: CompanyInfo },
    { name: 'Countries',                      path: '/Countries',                     component: Countries },
    { name: 'Proviences',                     path: '/Proviences',                    component: Proviences },
    { name: 'ServicePlans',                   path: '/ServicePlans',                  component: ServicePlans },
    { name: 'Account-Floor',                  path: '/Account-Floor',                 component: AccountFloor },
    { name: 'Account-Suites',                 path: '/Account-Suites',                component: AccountSuites },
    { name: 'Account-Maintenance-Room',       path: '/Account-Maintenance-Room',      component: AccountMaintenanceRoom },
    { name: 'Account-Parking',                path: '/Account-Parking',               component: AccountParking },
    { name: 'Account-Lockers',                path: '/Account-Lockers',               component: AccountLockers },
    { name: 'FireExtinguisher-Locations',     path: '/FireExtinguisher-Locations',    component: FireExtinguisherLocations },
    { name: 'TowerInspection-Checklist',      path: '/TowerInspection-Checklist',     component: TowerInspectionChecklist },
    { name: 'Account-Sprinkler',              path: '/Account-Sprinkler',             component: AccountSprinkler },
    { name: 'Account-Breakers',               path: '/Account-Breakers',              component: AccountBreakers },
    { name: 'Account-EmergencyExits',         path: '/Account-EmergencyExits',        component: AccountEmergencyExits },
    { name: 'EmergencyWater-ShutDown',        path: '/EmergencyWater-ShutDown',       component: EmergencyWaterShutDown },
    { name: 'Account-ServicesContractors',    path: '/Account-ServicesContractors',   component: AccountServicesContractors },
    { name: 'Account-FirePanel',              path: '/Account-FirePanel',             component: AccountFirePanel },
    { name: 'Account-GymEquipments',          path: '/Account-GymEquipments',         component: AccountGymEquipments },
    { name: 'Account-SwimmingPool ',          path: '/Account-SwimmingPool ',         component: AccountSwimmingPool },
    { name: 'Account-Compactor ',             path: '/Account-Compactor ',            component: AccountCompactor },
    { name: 'Account-Elevator',               path: '/Account-Elevator',              component: AccountElevator },
    { name: 'Account-AED',                    path: '/Account-AED',                   component: AccountAED },
    { name: 'Account-SecurityCamera ',        path: '/Account-SecurityCamera ',       component: AccountSecurityCamera },
    { name: 'Account-FOB',                    path: '/Account-FOB',                   component: AccountFOB },
    { name: 'Account-ScheduledInspection',    path: '/Account-ScheduledInspection',   component: AccountScheduledInspection },
    { name: 'Account-ScheduledServices',      path: '/Account-ScheduledServices',     component: AccountScheduledServices },
    { name: 'Account-SafeBox',                path: '/Account-SafeBox',               component: AccountSafeBox },
    { name: 'Account-PhoneCable',             path: '/Account-PhoneCable',            component: AccountPhoneCable },
    { name: 'General-Info',                   path: '/General-Info',                  component: GeneralInfo },
    { name: 'Account-period',                 path: '/Account-period',                component: AccountPeriod }
];