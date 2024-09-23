<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# Define pages here URL, View Folder::method without php extension



# Language Switcher
$routes->get('lang/{locale}', 'Language::index');

# Home
$routes->get('/', 'Home::index');
$routes->match(['get', 'post'],'/attendances/add-attendances', 'Attendances::addAttendances', []);
$routes->match(['get', 'post'],'/attendances/check_barcode', 'Attendances::check_barcode', []);

# Calendar
$routes->match(['get', 'post'],'/calendar/add-calendar', 'Calendar::addCalendar', ['filter' => 'permission:admin.access']);
$routes->get('/calendar/list', 'Calendar::list', []);
$routes->post('/calendar/list', 'Calendar::list', []);
$routes->match(['get', 'post'],'/calendar/add-calendar', 'Calendar::addCalendar', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/calendar/edit-calendar', 'Calendar::editCalendar', ['filter' => 'permission:production.super']);
$routes->post('/calendar/delete-calendar', 'Calendar::deleteCalendar', ['filter' => 'permission:production.super']);
$routes->get('/calendar/detail', 'Calendar::detail', []);

# Employees Task
$routes->match(['get', 'post'],'/employees_task/add-employees_task', 'EmployeesTask::addEmployeesTask', []);
$routes->get('/employees_task/list', 'EmployeesTask::list', []);
$routes->post('/employees_task/list', 'EmployeesTask::list', []);
$routes->match(['get', 'post'],'/employees_task/add-employees_leave', 'EmployeesTask::addEmployeesTask', []);
$routes->match(['get', 'post'], '/employees_task/edit-employees_leave', 'EmployeesTask::editEmployeesTask', []);
$routes->post('/employees_task/delete-employees_task', 'EmployeesTask::deleteEmployeesTask', []);
$routes->match(['get'],'/employees_task/add-start_end', 'EmployeesTask::addStartEnd', []);

# Employees Leave
$routes->get('/employees_leave/log_list', 'EmployeesLeave::loglist', []);
$routes->get('/employees_leave/list', 'EmployeesLeave::list', ['filter' => 'permission:admin.access']);
$routes->post('/employees_leave/list', 'EmployeesLeave::list', ['filter' => 'permission:admin.access']);
$routes->match(['get', 'post'],'/employees_leave/add-employees_leave', 'EmployeesLeave::addEmployeesLeave', []);
$routes->match(['get', 'post'], '/employees_leave/edit-employees_leave', 'EmployeesLeave::editEmployeesLeave', ['filter' => 'permission:production.super']);
$routes->post('/employees_leave/delete-employees_leave', 'EmployeesLeave::deleteEmployeesLeave', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/employees_leave/history-employees_leave', 'EmployeesLeave::ViewEmployeesLeavehistory', ['filter' => 'permission:production.super']);
$routes->post('/employees_leave/check-employees_leave', 'EmployeesLeave::checkEmployeesLeave', []);

$routes->get('/employees_leave/leave_total_list', 'EmployeesLeave::LeaveTotallist', []);
$routes->match(['get', 'post'],'/employees_leave/add-leave_total', 'EmployeesLeave::addEmployeesLeaveTotal', []);
$routes->post('/employees_leave/delete-leave_total', 'EmployeesLeave::deleteEmployeesLeaveTotal', ['filter' => 'permission:production.super']);


# Leave
$routes->match(['get', 'post'],'/leave/add-leave', 'Leave::addLeave', ['filter' => 'permission:employees.access']);
$routes->get('/leave/list', 'Leave::list', ['filter' => 'permission:employees.access']);
$routes->post('/leave/list', 'Leave::list', ['filter' => 'permission:employees.access']);
$routes->match(['get', 'post'],'/leave/add-leave', 'Leave::addLeave', ['filter' => 'permission:employees.access']);
$routes->match(['get', 'post'], '/leave/edit-leave', 'Leave::editLeave', ['filter' => 'permission:employees.access']);
$routes->post('/leave/delete-leave', 'Leave::deleteLeave', ['filter' => 'permission:employees.access']);

# Task
$routes->match(['get', 'post'],'/task/add-task', 'Task::addTask', ['filter' => 'permission:employees.access']);
$routes->get('/task/list', 'Task::list', ['filter' => 'permission:employees.access']);
$routes->post('/task/list', 'Task::list', ['filter' => 'permission:employees.access']);
$routes->match(['get', 'post'],'/task/add-leave', 'Task::addTask', ['filter' => 'permission:employees.access']);
$routes->match(['get', 'post'], '/task/edit-leave', 'Task::editTask', ['filter' => 'permission:employees.access']);
$routes->post('/task/delete-task', 'Task::deleteTask', ['filter' => 'permission:employees.access']);
$routes->match(['get'],'/task/add-start_end', 'Task::addStartEnd', ['filter' => 'permission:employees.access']);

# Calendar
$routes->get('/employeescalendar/list', 'Calendaremployees::list', ['filter' => 'permission:employees.access']);
# Department
$routes->match(['get', 'post'],'/department/add-department', 'Department::addDepartment', []);
$routes->get('/department/list', 'Department::list', []);
$routes->post('/department/list', 'Department::list', []);
$routes->match(['get', 'post'],'/department/add-department', 'Department::addDepartment', []);
$routes->match(['get', 'post'], '/department/edit-department', 'Department::editDepartment', []);
$routes->post('/department/delete-department', 'Department::deleteDepartment', []);

# Employee
$routes->match(['get', 'post'],'/employees/add-employee', 'Employees::addEmployee', []);
$routes->get('/employee/list', 'Employees::list', []);
$routes->post('/employee/list', 'Employees::list', []);
$routes->match(['get', 'post'],'/employee/view-attendances', 'Employees::viewattendances', []);
$routes->post('/employee/delete-attendances', 'Employees::delete_attendances', []);
$routes->match(['get', 'post'],'/employee/add-employee', 'Employees::addEmployee', []);
$routes->match(['get', 'post'], '/employee/edit-employee', 'Employees::editEmployee', []);
$routes->match(['get', 'post'], '/employee/holiday-employee', 'Employees::holidayEmployee', []);
$routes->post('/employee/delete-employee', 'Employees::deleteEmployee', []);
$routes->get('/employee/permission_list', 'Employees::permission_list', []);
$routes->post('/employee/permission_list', 'Employees::permission_list', []);
$routes->post('/employee/check-permission', 'Employees::checkEmployeespermission', []);
# Admin
$routes->match(['get', 'post'],'/admin/add-unit', 'Admin::addUnit', []);
$routes->get('/admin/units', 'Admin::units', []);
$routes->post('/admin/units', 'Admin::searchUnits', []);

# Design
$routes->match(['get', 'post'],'/design/add-unit', 'Design::addUnit', []);
$routes->get('/design/units', 'Design::units', []);
$routes->get('/design/units/unallocated', 'Design::unallocatedUnits', ['filter' => 'permission:design.super']);
$routes->post('/design/units', 'Design::searchUnits', []);
$routes->post('/design/allocate', 'Design::allocateDesigner', ['filter' => 'permission:design.super']);
$routes->post('/design/setstatus', 'Design::setStatus', []);
$routes->post('/design/complete', 'Design::designComplete', []);
$routes->get('/design/lookupModifications', 'Design::lookupModifications', []);
$routes->post('/design/modificationcomplete', 'Design::completeModification', []);
$routes->get('/design/setPhase', 'Design::setPhase', []);
$routes->get('/design/filterPhase', 'Design::filterPhaseUnits', ['filter' => 'permission:design.super']);
$routes->get('/design/filterDesignersUnits', 'Design::filterDesignersUnits', ['filter' => 'permission:design.super']);
$routes->get('/design/designerDaily', 'Design::designerDaily', ['filter' => 'permission:design.super']);
$routes->get('/design/addUnitHistory', 'Design::addUnitHistory', []);

# Design - CAD
$routes->get('/design/cad', 'Design::cadunits', []);





# Dashboard
$routes->get('/dashboard/airquee-dashboard', 'AQDashboard::index', ['filter' => 'permission:airqueedashboard.access']);
$routes->get('/dashboard/airparx-dashboard', 'AirparxsalesDashboard::index', ['filter' => 'permission:airparxdashboard.access']);
$routes->get('/dashboard/production-dashboard', 'ProductionDashboard::index', []);
$routes->get('/dashboard/production-dashboard/recalc/', 'ProductionDashboard::ReCalcSelectedMonth/', ['filter' => 'permission:production.super']);



# Production
$routes->get('/production/teams', 'Production::teams', []);
$routes->get('/production/units', 'Production::units', []);
$routes->post('/production/units', 'Production::searchUnits', ['filter' => 'permission:production.access']);
$routes->get('/production/view-team-daily-output', 'Production::viewTeamDailyOutput', ['filter' => 'permission:production.access']);
$routes->get('/production/view-unit-progress', 'Production::viewUnitProgressHistory', ['filter' => 'permission:production.access']);

$routes->match(['get', 'post'],'/production/add-unit', 'Production::addUnit', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/edit-unit', 'Production::editUnit', ['filter' => 'permission:production.super']);
$routes->post('/production/delete-unit', 'Production::deleteUnit', ['filter' => 'permission:production.super']);

$routes->get('/production/recently-added', 'Production::recentlyAdded', ['filter' => 'permission:production.super']);
$routes->get('/production/daily', 'Production::daily', []);
$routes->get('/production/team-daily', 'Production::teamDaily', ['filter' => 'permission:production.access']);
$routes->post('/production/set-expected', 'Production::setExpected', ['filter' => 'permission:production.super']);
$routes->post('/production/submit-progress', 'Production::submitProgress', ['filter' => 'permission:production.access']);
$routes->match(['get', 'post'], '/production/modifications-report', 'Production::viewModifications', []);
$routes->get('/production/modification-report-export', 'Production::ExportModificaitonsReport', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/team-output-report', 'Production::viewTeamsOuput', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/event-log', 'Production::eventLog', []);


$routes->match(['get', 'post'], '/production/add-split', 'Production::splitPNo', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/edit-progress', 'Production::editProductProgress', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/add-product-mod', 'Production::addProductModification', ['filter' => 'permission:production.super']);
$routes->match(['get', 'post'], '/production/edit-product-mod', 'Production::editProductModification', ['filter' => 'permission:production.super']);

$routes->get('/production/log', 'Admin::eventLog', ['filter' => 'permission:production.super']);

# Product Catalogue
$routes->get('/catalogue/products', 'Catalogue::index', []);
$routes->get('/catalogue/create',   'catalogue::create');
$routes->post('/catalogue/store', 'catalogue::store');
$routes->get('catalogue/edit/(:num)', 'catalogue::edit/$1');
$routes->post('catalogue/update/(:num)', 'catalogue::update/$1');
$routes->get('/catalogue/delete/(:num)', 'catalogue::delete/$1');



# Example from training 
/*
$routes->get("example", "Example::index");
$routes->get("example/(:num)", "Example::show/$1"); # Wild card for get clause
$routes->get("example/new", "Example::new");
$routes->post("example/create", "Example::create");
$routes->get("example/edit/(:num)", "Example::edit/$1");
*/

# Encryption Test
$routes->get('/encryption-test', 'Home::EncryptionTest', ['filter' => 'permission:users.create']);

#Staff
$routes->get('/staff/list', 'Hr::listStaff', []);
$routes->post('/staff/list', 'Hr::addStaff', []);


service('auth')->routes($routes);

# User Management
$routes->get('/user-management', 'UserManagement::index', ['filter' => 'permission:users.create']);
$routes->get('/user-management/add-user', 'UserManagement::addUser', ['filter' => 'permission:users.edit']);
$routes->post('/user-management/add-user', 'UserManagement::addUser', ['filter' => 'permission:users.edit']);
$routes->match(['get', 'post'], '/user-management/get-user/(:num)', 'UserManagement::getUser/$1', ['filter' => 'permission:users.edit']);
$routes->get('/user-management/deactivate-user/(:num)', 'UserManagement::disableUser/$1', ['filter' => 'permission:users.edit']);
$routes->get('/user-management/activate-user/(:num)', 'UserManagement::enableUser/$1', ['filter' => 'permission:users.edit']);
$routes->get('/user-management/delete-user/(:num)', 'UserManagement::deleteUser/$1', ['filter' => 'permission:users.edit']);
# Password
$routes->get('/user-management/password-reset', 'UserManagement::resetPassword');
$routes->post('/user-management/password-reset', 'UserManagement::setPassword');
$routes->get('/user-management/force-password-reset/(:num)', 'UserManagement::forcePasswordChange/$1', ['filter' => 'permission:users.edit']);




# Categories Routing
$routes->get('/category/index', 'Category::index');
$routes->get('/category/create', 'Category::create');
$routes->post('/category/store', 'Category::store');
$routes->get('/category/edit/(:num)', 'Category::edit/$1');
$routes->post('/category/update/(:num)', 'Category::update/$1');
$routes->get('/category/delete/(:num)', 'Category::delete/$1');


