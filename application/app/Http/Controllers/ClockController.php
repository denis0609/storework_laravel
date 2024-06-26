<?php
/*
 * Workday - A time clock application for employees
 * Support: official.codefactor@gmail.com
 * Version: 1.6
 * Author: Brian Luna
 * Copyright 2020 Codefactor
 */
namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Classes\Table;
use App\Classes\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClockController extends Controller
{

    public function clock()
    {
        $data = table::settings()->where('id', 1)->first();
        $cc = $data->clock_comment;
        $tz = $data->timezone;
        $tf = $data->time_format;
        $rfid = $data->rfid;

        return view('clock', compact('cc', 'tz', 'tf', 'rfid'));
    }

    public function add(Request $request)
    {

        if ($request->idno == NULL || $request->type == NULL) {
            return response()->json([
                "error" => trans("Invalid request! Please enter the ID")
            ]);
        }

        if (strlen($request->idno) >= 20 || strlen($request->type) >= 20) {
            return response()->json([
                "error" => trans("Invalid request!")
            ]);
        }

        $idno = strtoupper($request->idno);
        $type = $request->type;
        $date = date('Y-m-d');
        $time = date('h:i:s A');
        $comment = strtoupper($request->clockin_comment);
        $ip = $request->ip();

        // clock-in comment feature
        $clock_comment = table::settings()->value('clock_comment');
        $tf = table::settings()->value('time_format');
        $time_val = ($tf == 1) ? $time : date("H:i:s", strtotime($time));

        if ($clock_comment == "on") {
            if ($comment == NULL) {
                return response()->json([
                    "error" => trans("Invalid request! Please enter a comment")
                ]);
            }
        }

        // ip resriction
        $iprestriction = table::settings()->value('iprestriction');
        if ($iprestriction != NULL) {
            $ips = explode(",", $iprestriction);

            if (in_array($ip, $ips) == false) {
                $msge = trans("Invalid request! Your device it not registered");
                return response()->json([
                    "error" => $msge,
                ]);
            }
        }

        $employee_id = table::companydata()->where('idno', $idno)->value('reference');

        if ($employee_id == null) {
            return response()->json([
                "error" => trans("Invalid request! Wrong ID format")
            ]);
        }

        $emp = table::people()->where('id', $employee_id)->first();
        $lastname = $emp->lastname;
        $firstname = $emp->firstname;
        $mi = $emp->mi;
        $employee = mb_strtoupper($lastname . ', ' . $firstname . ' ' . $mi);

        if ($request->timetype == "worktime") {
            $timeTypeTimeIn = 'timein';
            $timeTypeTimeOut = 'timeout';
        } else {
            if ($request->timetype == "breaktime") {
                $timeTypeTimeIn = 'breaktimein';
                $timeTypeTimeOut = 'breaktimeout';
            } else {
                $timeTypeTimeIn = 'launchtimein';
                $timeTypeTimeOut = 'launchtimeout';
            }
        }

        if ($type == 'timein') {
            $has = table::attendance()->where([['idno', $idno], ['date', $date]])->exists();
            if ($has == 1) {
                $hti = table::attendance()->where([['idno', $idno], ['date', $date]])->value($timeTypeTimeIn);
                if (!$hti) {
                    $intime = date("Y-m-d h:i:s A", strtotime($date . " " . $time));
                    table::attendance()->where([['idno', $idno], ['date', $date]])->update(
                        array(
                            $timeTypeTimeIn => $intime
                        )
                    );
                    return response()->json([
                        "type" => $type,
                        "time" => $time_val,
                        "date" => $date,
                        "lastname" => $lastname,
                        "firstname" => $firstname,
                        "mi" => $mi,
                    ]);
                }
                $hti = date('h:i A', strtotime($hti));
                $hti_24 = ($tf == 1) ? $hti : date("H:i", strtotime($hti));

                return response()->json([
                    "employee" => $employee,
                    "error" => trans("Are you sure? You were clocked-in today at") . " " . $hti_24,
                ]);

            } else {
                $last_in_notimeout = table::attendance()->where([['idno', $idno], [$timeTypeTimeOut, NULL]])->count();
                if ($last_in_notimeout >= 1) {
                    return response()->json([
                        "error" => trans("Invalid request! You are not allowed to clock in twice or more in a day")
                    ]);

                } else {
                    $sched_in_time = table::schedules()->where([['idno', $idno], ['archive', 0]])->value('intime');

                    if ($sched_in_time == NULL) {
                        $status_in = "Ok";
                    } else {
                        $sched_clock_in_time_24h = date("H.i", strtotime($sched_in_time));
                        $time_in_24h = date("H.i", strtotime($time));

                        if ($time_in_24h <= $sched_clock_in_time_24h) {
                            $status_in = 'In Time';
                        } else {
                            $status_in = 'Late In';
                        }
                    }

                    if ($clock_comment == "on" && $comment != NULL) {
                        table::attendance()->insert([
                            [
                                'idno' => $idno,
                                'reference' => $employee_id,
                                'date' => $date,
                                'employee' => $employee,
                                $timeTypeTimeIn => $date . " " . $time,
                                'status_timein' => $status_in,
                                'comment' => $comment,
                            ],
                        ]);
                    } else {
                        table::attendance()->insert([
                            [
                                'idno' => $idno,
                                'reference' => $employee_id,
                                'date' => $date,
                                'employee' => $employee,
                                $timeTypeTimeIn => $date . " " . $time,
                                'status_timein' => $status_in,
                            ],
                        ]);
                    }

                    return response()->json([
                        "type" => $type,
                        "time" => $time_val,
                        "date" => $date,
                        "lastname" => $lastname,
                        "firstname" => $firstname,
                        "mi" => $mi,
                    ]);
                }
            }
        }

        if ($type == 'timeout') {
            if ($request->timetype == "worktime") {
                $timeTypeTimeIn = 'timein';
                $timeTypeTimeOut = 'timeout';
            } else {
                if ($request->timetype == "breaktime") {
                    $timeTypeTimeIn = 'breaktimein';
                    $timeTypeTimeOut = 'breaktimeout';
                } else {
                    $timeTypeTimeIn = 'launchtimein';
                    $timeTypeTimeOut = 'launchtimeout';
                }
            }
            $timeIN = table::attendance()->where([['idno', $idno], ['date', $date], [$timeTypeTimeOut, NULL]])->value($timeTypeTimeIn);
            $clockInDate = table::attendance()->where([['idno', $idno], ['date', $date], [$timeTypeTimeOut, NULL]])->value('date');
            $hasout = table::attendance()->where([['idno', $idno], ['date', $date]])->value($timeTypeTimeOut);
            $timeOUT = date("Y-m-d h:i:s A", strtotime($date . " " . $time));

            if ($timeIN == NULL) {
                return response()->json([
                    "error" => trans("Invalid request! You are not clocked-in")
                ]);
            }
            if ($hasout != NULL) {
                $hto = table::attendance()->where([['idno', $idno], ['date', $date]])->value($timeTypeTimeOut);
                $hto = date('h:i A', strtotime($hto));
                $hto_24 = ($tf == 1) ? $hto : date("H:i", strtotime($hto));

                return response()->json([
                    "employee" => $employee,
                    "error" => trans("Are you sure? You were clocked-out today at") . " " . $hto_24,
                ]);

            } else {
                $sched_out_time = table::schedules()->where([['idno', $idno], ['archive', 0]])->value('outime');

                if ($sched_out_time == NULL) {
                    $status_out = "Ok";
                } else {
                    $sched_clock_out_time_24h = date("H.i", strtotime($sched_out_time));
                    $time_out_24h = date("H.i", strtotime($timeOUT));

                    if ($time_out_24h >= $sched_clock_out_time_24h) {
                        $status_out = 'On Time';
                    } else {
                        $status_out = 'Early Out';
                    }
                }

                $time1 = Carbon::createFromFormat("Y-m-d h:i:s A", $timeIN);
                $time2 = Carbon::createFromFormat("Y-m-d h:i:s A", $timeOUT);
                $th = $time1->diffInHours($time2);
                $tm = floor(($time1->diffInMinutes($time2) - (60 * $th)));
                $totalhour = $th . "." . $tm;

                if ($timeTypeTimeOut !== "timeout") {
                    table::attendance()->where([['idno', $idno], ['date', $clockInDate]])->update(
                        array(
                            $timeTypeTimeOut => $timeOUT,
                        )
                    );
                } else {
                    table::attendance()->where([['idno', $idno], ['date', $clockInDate]])->update(
                        array(
                            'timeout' => $timeOUT,
                            'totalhours' => $totalhour,
                            'status_timeout' => $status_out
                        )
                    );
                }

                return response()->json([
                    "type" => $type,
                    "time" => $time_val,
                    "date" => $date,
                    "lastname" => $lastname,
                    "firstname" => $firstname,
                    "mi" => $mi,
                ]);
            }
        }
    }
}
