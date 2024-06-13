<?php
/*
* Workday - A time clock application for employees
* Support: official.codefactor@gmail.com
* Version: 1.6
* Author: Brian Luna
* Copyright 2020 Codefactor
*/
namespace App\Classes;

use DB;

Class table {

    public static function people() 
    {
      $people = DB::table('people');
      return $people;
    }

    public static function companydata() 
    {
      $companydata = DB::table('company_data');
      return $companydata;
    }

    public static function attendance() 
    {
      $attendance = DB::table('people_attendance');
      return $attendance;
    }

    public static function leaves() 
    {
      $leaves = DB::table('people_leaves');
      return $leaves;
    }

    public static function schedules() 
    {
      $schedules = DB::table('people_schedules');
      return $schedules;
    }

    public static function reportviews() 
    {
      $reportviews = DB::table('report_views');
      return $reportviews;
    }

    public static function permissions() 
    {
      $permissions = DB::table('users_permissions');
      return $permissions;
    }

    public static function roles() 
    {
      $roles = DB::table('users_roles');
      return $roles;
    }

    public static function users() 
    {
      $users = DB::table('users')->select('id', 'reference', 'idno', 'name', 'email', 'role_id', 'acc_type', 'status');
      return $users;
    }

    public static function company() 
    {
      $company = DB::table('form_company');
      return $company;
    }

    public static function department() 
    {
      $department = DB::table('form_department');
      return $department;
    }

    public static function jobtitle() 
    {
      $jobtitle = DB::table('form_jobtitle');
      return $jobtitle;
    }

    public static function leavetypes() 
    {
      $leavetypes = DB::table('form_leavetype');
      return $leavetypes;
    }

    public static function leavegroup() 
    {
      $leavegroup = DB::table('form_leavegroup');
      return $leavegroup;
    }

    public static function settings() 
    {
      $settings = DB::table('settings');
      return $settings;
    }

}