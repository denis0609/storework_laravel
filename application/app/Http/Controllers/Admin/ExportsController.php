<?php
/*
 * Workday - A time clock application for employees
 * Support: official.codefactor@gmail.com
 * Version: 1.6
 * Author: Brian Luna
 * Copyright 2020 Codefactor
 */
namespace App\Http\Controllers\admin;

use DB;
use App\Classes\Table;
use App\Classes\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Exports\EmployeesExport;
use App\Exports\LeavesExport;
use App\Exports\ScheduleExport;
use App\Exports\BirthdaysExport;
use App\Exports\AccountsExport;

class ExportsController extends Controller
{

	function company(Request $request)
	{
		if (permission::permitted('company') == 'fail') {
			return redirect()->route('denied');
		}

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'companies-' . $date . 'T' . $time . '.csv';

		$c = table::company()->get();

		Storage::put($file, '', 'private');

		foreach ($c as $d) {
			Storage::prepend($file, $d->id . ',' . $d->company);
		}

		Storage::prepend($file, '"ID"' . ',' . 'COMPANY');

		return Storage::download($file);
	}

	function department(Request $request)
	{
		if (permission::permitted('departments') == 'fail') {
			return redirect()->route('denied');
		}

		$d = table::department()->get();

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'departments-' . $date . 'T' . $time . '.csv';

		Storage::put($file, '', 'private');

		foreach ($d as $i) {
			Storage::prepend($file, $i->id . ',' . $i->department);
		}

		Storage::prepend($file, '"ID"' . ',' . 'DEPARTMENT');

		return Storage::download($file);
	}

	function jobtitle(Request $request)
	{
		if (permission::permitted('jobtitles') == 'fail') {
			return redirect()->route('denied');
		}

		$j = table::jobtitle()->get();

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'jobtitles-' . $date . 'T' . $time . '.csv';

		Storage::put($file, '', 'private');

		foreach ($j as $d) {
			Storage::prepend($file, $d->id . ',' . $d->jobtitle . ',' . $d->dept_code);
		}

		Storage::prepend($file, '"ID"' . ',' . 'DEPARTMENT' . ',' . 'DEPARTMENT CODE');

		return Storage::download($file);
	}

	function leavetypes(Request $request)
	{
		if (permission::permitted('leavetypes') == 'fail') {
			return redirect()->route('denied');
		}

		$l = table::leavetypes()->get();

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'leavetypes-' . $date . 'T' . $time . '.csv';

		Storage::put($file, '', 'private');

		foreach ($l as $d) {
			Storage::prepend($file, $d->id . ',' . $d->leavetype . ',' . $d->limit . ',' . $d->percalendar);
		}

		Storage::prepend($file, '"ID"' . ',' . 'LEAVE TYPE' . ',' . 'LIMIT' . ',' . 'TYPE');

		return Storage::download($file);
	}

	public function employeeList()
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'employee-lists-' . $date . 'T' . $time . '.xlsx';

		$query = Table::people()->get(["id", "lastname", "firstname", "age", "gender", "civilstatus", "mobileno", "emailaddress", "employmenttype", "employmentstatus"]);

		return Excel::download(new EmployeesExport($query), $file);
	}

	function attendanceReport(Request $request)
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$id = $request->emp_id;
		$datefrom = $request->datefrom;
		$dateto = $request->dateto;

		// Determine the query based on input parameters
		$query = table::attendance();

		if ($id !== null) {
			$query->where('idno', $id);
		}

		if ($datefrom !== null && $dateto !== null) {
			$query->whereBetween('date', [$datefrom, $dateto]);
		}

		$data = $query->get(['date', 'employee', 'timein', 'timeout', 'breaktimein', 'breaktimeout', 'launchtimein', 'launchtimeout', 'totalhours']);

		if ($data->isEmpty()) {
			return redirect('reports/employee-attendance')->with('error', trans("Invalid request! Please select an employee or choose a date range"));
		}

		$fileName = 'attendance-reports-' . date('Y-m-d') . 'T' . date('h-i-sa') . '.xlsx';

		return Excel::download(new AttendanceExport($data), $fileName);
	}

	function leavesReport(Request $request)
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$id = $request->emp_id;
		$datefrom = $request->datefrom;
		$dateto = $request->dateto;

		$query = table::leaves();

		if ($id !== null) {
			$query->where('idno', $id);
		}

		if ($datefrom !== null && $dateto !== null) {
			$query->whereBetween('leavefrom', [$datefrom, $dateto]);
		}

		$data = $query->get();

		if ($data->isEmpty()) {
			return redirect('reports/employee-leaves')->with('error', trans("Invalid request! Please select an employee or choose a date range"));
		}

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'leave-reports-' . $date . 'T' . $time . '.xlsx';

		return Excel::download(new LeavesExport($data), $file);
	}

	function birthdaysReport()
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$data = table::people()->join('company_data', 'people.id', '=', 'company_data.reference')->get();

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'employee-birthdays-' . $date . 'T' . $time . '.xlsx';

		return Excel::download(new BirthdaysExport($data), $file);
	}

	function accountReport()
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$users = table::users()->get();

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'employee-accounts-' . $date . 'T' . $time . '.xlsx';

		return Excel::download(new AccountsExport($users), $file);
	}

	function scheduleReport(Request $request)
	{
		if (permission::permitted('reports') == 'fail') {
			return redirect()->route('denied');
		}

		$id = $request->emp_id;

		$query = table::schedules();

		if ($id !== null) {
			$query->where('idno', $id);
		}

		$data = $query->get(["idno", "employee", "intime", "outime", "datefrom", "dateto", "hours", "restday", "archive"]);

		if ($data->isEmpty()) {
			return redirect('reports/employee-schedule')->with('error', trans("Invalid request! Please select an employee"));
		}

		$date = date('Y-m-d');
		$time = date('h-i-sa');
		$file = 'schedule-reports-' . $date . 'T' . $time . '.xlsx';

		return Excel::download(new ScheduleExport($data), $file);
	}
}
