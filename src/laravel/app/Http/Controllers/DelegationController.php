<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelegationController extends Controller
{
    public function add(Request $req): JsonResponse
    {
        $jsonFields = JsonValidator::getJsonFields($req);
        $startDate = $jsonFields['start_date'];
        $endDate = $jsonFields['end_date'];
        $startDateFmt = $jsonFields['start_date_fmt'];
        $endDateFmt = $jsonFields['end_date_fmt'];
        $country = $jsonFields['country'];
        $employeeId = $jsonFields['employee_id'];

        if (self::delegationExists($employeeId, $startDate, $endDate))
            return response()->json(['msg' => "Employee is already on delegation for the given date range"]);

        DB::insert("INSERT INTO `delegations` (employee_id, country, start_date, end_date)
                            VALUES (?, ?, ?, ?)",
                            [$employeeId, $country, $startDateFmt, $endDateFmt]);

        return response()->json(['msg' => 'Delegation added successfully']);
    }

    public function get(Request $reg): JsonResponse
    {
        $employeeId = $reg->integer('employee_id');
        if ($employeeId < 1)
            return response()->json(['msg' => 'Incorrect employee id']);
        return response()->json(PerDiemCalculator::calculatePerDiemForDelegations($employeeId));
    }

    private static function delegationExists($employeeId, $startDate, $endDate): object|null
    {
        return DB::table('delegations')
        ->where('employee_id', $employeeId)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })
        ->first();
    }
}
