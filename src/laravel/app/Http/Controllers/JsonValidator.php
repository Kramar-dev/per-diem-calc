<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class JsonValidator
{
    public static function getJsonFields(Request $req): JsonResponse|array
    {
        $req->validate([
            'start_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/'],
            'end_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/'],
            'country' => ['required', 'string', 'size:2'],
            'employee_id' => ['required', 'numeric', 'min:1'],
        ]);


        $employeeId = $req->input('employee_id');
        $country = $req->string('country');
        $countryCodes = Country::getCodes();
        if (!in_array($country, $countryCodes))
            return response()->json(['msg' => 'Incorrect country code']);

        try {
            $startDate = Carbon::parse($req->input('start_date'));
            $endDate = Carbon::parse($req->input('end_date'));
            $startDateFmt = $startDate->toDateTimeString();
            $endDateFmt = $endDate->toDateTimeString();
        } catch (Exception $e) {
            return response()->json(['msg' => "Invalid date format: $e"]);
        }

        if ($startDate->toDateTimeString() !== $req->input('start_date'))
            return response()->json(['msg' => 'Invalid start date']);

        if ($endDate->toDateTimeString() !== $req->input('end_date'))
            return response()->json(['msg' => 'Invalid end date']);

        if ($startDate->isAfter($endDate))
            return response()->json(['msg' => 'End date is before start date']);

        return array(
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_date_fmt' => $startDateFmt,
            'end_date_fmt' => $endDateFmt,
            'country' => $country,
            'employee_id' => $employeeId,
        );
    }
}
