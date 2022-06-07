<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapters\BullhornAdapter;
use App\Builders\BullhornHttpQueryBuilder;
use App\Repositories\KpiRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GuzzleHttp\Exception\GuzzleException;

class BullhornKpiService
{
    public function __construct(
        public BullhornAdapter $bullhornAdapter,
        public KpiRepository $kpiRepository,
        public BullhornHttpQueryBuilder $bullhornHttpQueryBuilder
    ) {
    }

    protected function getData(int $kpi, Carbon $fromData, Carbon $toDate, ?string $status): int
    {
        //gets the data from the database
        $result = $this->getDataFromDatabase($kpi, $fromData->format('Y-m-d'));

        if (!$result) {
            if ($toDate < Carbon::now()) {
                $result = $this->getDataFromBullhorn($fromData, $toDate, $status);
                //Save the data from Bullhorn in the database
                $this->kpiRepository->insertKpiValue($kpi, $result['count'], $fromData->format('Y-m-d'));
                return $result['count'];
            }
            return 0;
        }
        return $result[0]->values;
    }

    protected function getDataFromDatabase(int $kpi, string $date): array
    {
        return $this->kpiRepository->getDataByKpiAndDate($kpi, $date);
    }

    protected function getDataFromBullhorn(Carbon $fromDate, Carbon $toDate, ?string $status): array|null
    {
        return $this->bullhornAdapter->executeQuery(
            $this->bullhornHttpQueryBuilder->buildJobOrdersQuery(
                $fromDate,
                $toDate,
                $status
            )
        );
    }

    public function loadsMonthlyJobOrderByYear(?int $yearNr): array
    {
        $now = Carbon::now();
        if ($yearNr == null) {
            $yearNr = $now->yearIso;
        }
        $months = [];
        // For every month in the year(12)
        for ($x = 1; $x<=12; $x++) {
            $day = Carbon::createFromDate($yearNr, $x, 1);

            $result = $this->getData(
                2,
                $day,
                Carbon::parse($day)->lastOfMonth(),
                null
            );
            //Array months is filled with first the result and second the date on when the record needs to be saved
            $months[] = [$result, $day->format('M')];
        }

        return $months;
    }

    public function loadsDailyJobOrderByWeek(?int $weekNr): array
    {
        $now = Carbon::now();
        //If weekNr is not set take the week number of this current week
        if ($weekNr == null) {
            $weekNr = $now->weekOfYear;
        }
        $now->setISODate($now->yearIso, $weekNr);

        $weekStartDate = $now->startOfWeek()->format('Y-m-d');

        $days = [];
        // Iterate over the period
        for ($x = 1; $x<=5; $x++) {
            $result = $this->getData(
                1,
                Carbon::parse($weekStartDate)->addDays($x-1),
                Carbon::parse($weekStartDate)->addDays($x),
                null
            );
            //Array days is filled with first the result and second the date on when the record needs to be saved
            $days[] = [$result, Carbon::parse($weekStartDate)->addDays($x-1)->format('d-m')];
        }
        return $days;
    }

    public function getYears(): array
    {
        $now = Carbon::now();

        $year = $now->yearIso;
        $years= [];
        for ($x = $year; $x >= 2019; $x--) {
            $years[] = $x;
        }
        return $years;
    }

    /**
     * create an array with al the week numbers up until now
     * @return array
     */
    public function getWeekNumbers(): array
    {
        // Get the data and current week number
        $date = Carbon::today();
        $weekNumber = $date->weekOfYear;

        $weekNrs = [];
        // Takes the current week number and adds all previous week numbers
        for ($i = $weekNumber; $i >= 1; $i--) {
            $weekNrs[] = $i;
        }
        return $weekNrs;
    }

    public function loadOpenJobOrdersForCurrentMonth(): array
    {
        $now = Carbon::today();
        $dateFrom = Carbon::parse($now)->startOfMonth()->format('Y-m-d');
        $dateTo = Carbon::parse($now)->endOfMonth()->format('Y-m-d');

        return $this->bullhornAdapter->executeQuery(
            $this->bullhornHttpQueryBuilder->buildJobOrdersQuery(
                Carbon::parse($dateFrom),
                Carbon::parse($dateTo),
                BullhornHttpQueryBuilder::JOB_ORDER_STATUS_PROFFER
            )
        );
    }

    public function loadOpenJobOrdersForToday(): array
    {
        $dateFrom = Carbon::today()->format('Y-m-d');
        $dateTo = Carbon::today()->addDay();

        return $this->bullhornAdapter->executeQuery(
            $this->bullhornHttpQueryBuilder->buildJobOrdersQuery(
                Carbon::parse($dateFrom),
                Carbon::parse($dateTo),
                BullhornHttpQueryBuilder::JOB_ORDER_STATUS_PROFFER
            )
        );
    }
}
