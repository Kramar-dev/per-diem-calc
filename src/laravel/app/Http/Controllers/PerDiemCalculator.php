<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PerDiemCalculator
{
    public static function calculatePerDiemForDelegations($employeeId): array
    {
         $delegationRecords = DB::table('delegations')
            ->where('employee_id', $employeeId)
            ->get();

        $result = [];

        foreach ($delegationRecords as $record) {
            $startDate = Carbon::parse($record->start_date);
            $endDate = Carbon::parse($record->end_date);

            $totalPerDiem = 0;

            while ($startDate <= $endDate) {
                if (!$startDate->isWeekend()) {
                    if (self::isMoreThanEightHours($startDate, $record->end_date)) {
                        $perDiemAmount = self::calculatePerDiemAmount($record->country, $startDate);
                        if ($startDate->diffInDays($record->end_date) > 7)
                            $perDiemAmount *= 2;
                        $totalPerDiem += $perDiemAmount;
                    }
                }
                $startDate->addDay();
            }

            $delegationEntry = [
                'start' => $record->start_date,
                'end' => $record->end_date,
                'country' => $record->country,
                'amount_due' => $totalPerDiem,
                'currency' => 'PLN',
            ];

            $result[] = $delegationEntry;
        }
        return $result;
    }

    public static function isMoreThanEightHours($startDate, $endDate): bool
    {
        $startDateTime = Carbon::parse($startDate);
        $endDateTime = Carbon::parse($endDate);
        $totalWorkingHours = 0;

        while ($startDateTime <= $endDateTime) {
            if ($startDateTime->isWeekday())
                $totalWorkingHours++;

            $startDateTime->addHour();
        }
        return $totalWorkingHours > 8;
    }

    public static function calculatePerDiemAmount($country, $date)
    {
        $perDiemAmounts = self::getPerDiemAmounts();
        $dayOfWeek = $date->dayOfWeek;

        if (array_key_exists($country, $perDiemAmounts)) {
            if ($dayOfWeek == 0 || $dayOfWeek == 6)
                return 0;
            return $perDiemAmounts[$country];
        }
        return 0;
    }

    public static function getPerDiemAmounts(): array
    {
        return DB::table('countries')->pluck('perdiem_amount', 'country')->toArray();
    }
}
