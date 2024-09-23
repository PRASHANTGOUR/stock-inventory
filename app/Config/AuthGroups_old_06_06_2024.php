<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'director' => [
            'title'       => 'Director',
            'description' => 'Director of company, top level overview.',
        ],
        'developer' => [
            'title'       => 'Developer',
            'description' => 'Site programmers.',
        ],

        'designer' => [
            'title'       => 'Designer',
            'description' => 'Designer.',
        ],

        'productionsuper' => [
            'title'       => 'Production Tracking Super User',
            'description' => 'Production Super User.',
        ],

        'productionuser' => [
            'title'       => 'Production Tracking User',
            'description' => 'Production User.',
        ],

        'user' => [
            'title'       => 'AQ Admin User',
            'description' => 'General users of the site.',
        ],
        'sales' => [
            'title'       => 'AQ Admin User',
            'description' => 'General users of the site.',
        ],
        'employees' => [
            'title'       => 'Employees User',
            'description' => 'General users of the site.',
        ],


        /* 
        Ant would like to use Permissions list from template

        Director = Mark, also Rob for Airparx
        Logisitics Tim (Tebe) + Sales
        AQ Admin inc Airparx Orsi etc.view and edit customer
        Designers = Rob & Ryan etc. Poss some readonly cust data for orders
        Sales = Own sales
        Sales Manager = All sales
        HR = Employee + Some readonly like bank details
        HR Admins =Employee + Full access
        Accounts = Access to customer + 
        Testers = Cert DB + Product List (View Only)
        Marketing = Change price etc
        Marketing Admin = Edit products fully
        Production Administrator = Edit record 
        Production Manager = Edina - full access for production + adding new etc
        Super Admin = User Managment + Full Access to everything
        Worker = Factory worker - stitcher - limited to there output etc and there team stats
        Cutting = View scheduled jobs readonly and update progress with notes



        Additional persmissions
        Roli Sales + Logistics
        */

    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        # Super 
        'super.access'              => 'Super User Access',

        # Developer 
        'developer.access'          => 'Developer User Access',

        # Admininstration
        'admin.access'              => 'Can access Admin',

        # Catalogue
        'catalogue.access'          => 'Can access product catalogue',

        # CRM
        'crm.access'                => 'Can access CRM',
        'crm.edit'                  => 'Can edit CRM',
        'crm.delete'                => 'Can delete CRM',

        # Dashboard 
        'productiondashboard.access'    => 'Can View the Production Dashboard',
        'airqueedashboard.access'       => 'Can View the AQ Sales Dashboard',
        'airparxdashboard.access'       => 'Can View the AirparxSales Dashboard',

        # Design
        'design.access'             => 'Can access Design',
        
        # Finance 
        'finance.acces'             => 'Cam access Fiance',

        # Log
        'log.access'                => 'Can access logs',

        # Logistics
        'logisitics.access'         => 'Can access Logisitics',

        # Production
        'production.access'         => 'Access to Production Tracking',
        'production.super'          => 'Super User to Production Tracking',

        # Projects
        'projects.access'           => 'Can access Projecsts',

        # Reporting
        'reporting.access'          => 'Can access Reporting',

        # User Management
        'users.create'              => 'Can create new non-admin users',
        'users.edit'                => 'Can edit existing non-admin users',
        'users.delete'              => 'Can delete existing non-admin users',
        'users.manage-admins'       => 'Can manage other admins',
    
        # employees
        'employees.access'         => 'Access to Employees',

    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        # Super Users
        'superadmin' => [
            'admin.*',
            'users.*',
            'production.*',
            'productiondashboard.*',
            'catalogue.*',
            'design.*',
        ],
        # Web Developer
        'developer' => [
            'productiondashboard.*',
            'production.*',
            'users.*',
            'admin.*',
            'catalogue.*',
            'design.*',
        ],
        # Directors
        'director' => [
            'productiondashboard.view',
            'salesdashboard.view',
        ],
        # AQ Admin
        'aqadmin' => [
        ],

        # Designer 
        'designer' => [
            'design.access',
        ],

        # Production
        'productionsuper' => [
            'production.access',
            'productiondashboard.access',
            'production.super',  
            'admin.access',
        ],
        'productionuser' => [
            'production.access',
            'productiondashboard.access',
        ],

        'airqueeuser' => [],
        'airparxuser' => [],


        'user' => [],
        'employees' => [
            'employees.access',
        ],
    ];
}
