<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class KpiRepository
{
    private const TABLE_NAME = 'kpi_values';

    /** Geen string values, maak een KPI model en gebruik dat, zie ORM in Laravel */
    public function getDataByKpiAndDate(int $kpiId, string $date): array
    {
        return DB::select(
            "SELECT values, value_date FROM public.".static::TABLE_NAME."
                                     WHERE value_date = :date AND
                                           kpi_id = :kpiId",
            ['date' => $date, 'kpiId' => $kpiId]
        );
    }

    public function insertKpiValue(int $kpiId, int $value, string $date): void
    {
        DB::insert(
            "INSERT INTO public.".static::TABLE_NAME."
                                         (kpi_id, values, value_date)
                                         VALUES
                                         (:kpi_id, :value, :date )",
            ['kpi_id' => $kpiId, 'value' => $value, 'date' => $date]
        );
    }
}
