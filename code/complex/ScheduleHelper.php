<?php

class ScheduleHelper
{
    /**
     * @param string $startDate
     * @param string $endDate
     * @param array $dates
     * @return array
     */
    public static function fillMissingDates(string $startDate, string $endDate, array $dates): array
    {
        $startDate = Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon\Carbon::parse($endDate)->startOfDay();

        while ($startDate <= $endDate) {
            $dateStr = Carbon\Carbon::parse($startDate)->format(DATE_FORMAT['DB_DATE']);
            if (!isset($dates[$dateStr])) {
                $dates[$dateStr] = [];
            }
            $startDate->addDays(1);
        }

        ksort($dates);

        return $dates;
    }

    /**
     * @param $schedules
     * @param $timezone
     * @return array[]
     */
    public static function currentAndFuture($schedules, $timezone): array
    {
        $current = [];
        $future = [];
        foreach ($schedules as $schedule) {
            if (is_null($schedule->next_session)) {
                $current[] = $schedule;
            } else {
                if (Carbon\Carbon::now($timezone)->gte(Carbon\Carbon::parse($schedule->next_session, $timezone))) {
                    $current[] = $schedule;
                } else {
                    $future[] = $schedule;
                }
            }
        }

        return ['current' => $current, 'future' => $future];
    }
}
