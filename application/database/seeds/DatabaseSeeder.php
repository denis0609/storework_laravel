<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// default values for settings table
        DB::table('settings')->insert([
            'id' => 1,
            'country' => 'United States of America',
            'timezone' => 'America/New_York',
            'time_format' => 1,
        ]);

        // default values for company_data table
        DB::table('company_data')->insert([
            ['id' => 1,'reference' => 1,'idno' => '001122','startdate' => '2020-02-01','dateregularized' => '2020-02-01'],
            ['id' => 2,'reference' => 2,'idno' => '001133','startdate' => '2020-02-01','dateregularized' => '2020-02-01']
        ]);

        // default values for people table
        DB::table('people')->insert([
            ['id' => 1,'firstname' => 'MANAGER','lastname' => 'DEMO','emailaddress' => 'manager@example.com','birthday' => '2020-02-01','employmentstatus' => 'Active'],
            ['id' => 2,'firstname' => 'EMPLOYEE','lastname' => 'DEMO','emailaddress' => 'employee@example.com','birthday' => '2020-02-01','employmentstatus' => 'Active']
        ]);

        // default values for report_views table
        DB::table('report_views')->insert([
            ['id' => 1,'report_id' => 1,'last_viewed' => '','title' => 'Employee List Report'],
            ['id' => 2,'report_id' => 2,'last_viewed' => '','title' => 'Employee Attendance Report'],
            ['id' => 3,'report_id' => 3,'last_viewed' => '','title' => 'Employee Leaves Report'],
            ['id' => 4,'report_id' => 4,'last_viewed' => '','title' => 'Employee Schedule Report'],
            ['id' => 5,'report_id' => 5,'last_viewed' => '','title' => 'Organizational Profile'],
            ['id' => 6,'report_id' => 6,'last_viewed' => '','title' => 'User Accounts Report'],
            ['id' => 7,'report_id' => 7,'last_viewed' => '','title' => 'Employee Birthdays']
        ]);

        // default values for users tables
        DB::table('users')->insert([
            ['id' => '1','reference' => '1','idno' => '001122','name' => 'DEMO, MANAGER','email' => 'manager@example.com','role_id' => '1','acc_type' => '2','status' => '1','password' => '$2y$10$mDAH.R8JG5ThPelt4zRXc.8sxizt.tqXQfndx5s/W/3j0Sq6xS3LG','remember_token' => '','created_at' => '2018-10-31 20:10:04','updated_at' => '2018-10-31 20:10:04'],
            ['id' => '2','reference' => '2','idno' => '001133','name' => 'DEMO, EMPLOYEE','email' => 'employee@example.com','role_id' => '2','acc_type' => '1','status' => '1','password' => '$2y$10$3qjhKES39RmTl4k7PQWJ.OfG4uFzzF/iYJI8A1BLgYs2uDEfe5pry','remember_token' => '','created_at' => '2018-12-21 13:20:18','updated_at' => '2018-12-21 13:20:18']
        ]);

        // default values for users_permissions table
        DB::table('users_permissions')->insert([
            ['id' => '1','role_id' => '1','perm_id' => '1'],
            ['id' => '2','role_id' => '1','perm_id' => '2'],
            ['id' => '3','role_id' => '1','perm_id' => '22'],
            ['id' => '4','role_id' => '1','perm_id' => '21'],
            ['id' => '5','role_id' => '1','perm_id' => '23'],
            ['id' => '6','role_id' => '1','perm_id' => '24'],
            ['id' => '7','role_id' => '1','perm_id' => '25'],
            ['id' => '8','role_id' => '1','perm_id' => '3'],
            ['id' => '9','role_id' => '1','perm_id' => '31'],
            ['id' => '10','role_id' => '1','perm_id' => '32'],
            ['id' => '11','role_id' => '1','perm_id' => '4'],
            ['id' => '12','role_id' => '1','perm_id' => '41'],
            ['id' => '13','role_id' => '1','perm_id' => '42'],
            ['id' => '14','role_id' => '1','perm_id' => '43'],
            ['id' => '15','role_id' => '1','perm_id' => '44'],
            ['id' => '16','role_id' => '1','perm_id' => '5'],
            ['id' => '17','role_id' => '1','perm_id' => '52'],
            ['id' => '18','role_id' => '1','perm_id' => '53'],
            ['id' => '19','role_id' => '1','perm_id' => '9'],
            ['id' => '20','role_id' => '1','perm_id' => '91'],
            ['id' => '21','role_id' => '1','perm_id' => '7'],
            ['id' => '22','role_id' => '1','perm_id' => '8'],
            ['id' => '23','role_id' => '1','perm_id' => '81'],
            ['id' => '24','role_id' => '1','perm_id' => '82'],
            ['id' => '25','role_id' => '1','perm_id' => '83'],
            ['id' => '26','role_id' => '1','perm_id' => '10'],
            ['id' => '27','role_id' => '1','perm_id' => '101'],
            ['id' => '28','role_id' => '1','perm_id' => '102'],
            ['id' => '29','role_id' => '1','perm_id' => '103'],
            ['id' => '30','role_id' => '1','perm_id' => '104'],
            ['id' => '31','role_id' => '1','perm_id' => '11'],
            ['id' => '32','role_id' => '1','perm_id' => '111'],
            ['id' => '33','role_id' => '1','perm_id' => '112'],
            ['id' => '34','role_id' => '1','perm_id' => '12'],
            ['id' => '35','role_id' => '1','perm_id' => '121'],
            ['id' => '36','role_id' => '1','perm_id' => '122'],
            ['id' => '37','role_id' => '1','perm_id' => '13'],
            ['id' => '38','role_id' => '1','perm_id' => '131'],
            ['id' => '39','role_id' => '1','perm_id' => '132'],
            ['id' => '40','role_id' => '1','perm_id' => '14'],
            ['id' => '41','role_id' => '1','perm_id' => '141'],
            ['id' => '42','role_id' => '1','perm_id' => '142'],
            ['id' => '43','role_id' => '1','perm_id' => '15'],
            ['id' => '44','role_id' => '1','perm_id' => '151'],
            ['id' => '45','role_id' => '1','perm_id' => '152'],
            ['id' => '46','role_id' => '1','perm_id' => '153']
        ]);

        // default values for users_roles table
        DB::table('users_roles')->insert([
            ['id' => '1','role_name' => 'MANAGER','state' => 'Active'],
            ['id' => '2','role_name' => 'EMPLOYEE','state' => 'Active']
        ]);
    }
}
