<?php

namespace App\Http\Controllers;

use App\Service\BullhornKpiService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoadDashboardDataController extends Controller
{
    public function __construct(
        protected BullhornKpiService $bullhornKpiService
    ) {
    }

    /**
     * load the different kpi data and send it to the view
     * @param Request $request
     * @return Factory|View|Application
     */
    public function index(Request $request): Factory|View|Application
    {
        //Get optional parameters
        $cWeek = $request->input('weekNrSelect');
        $cYear = $request->input('yearsSelect');
        $dayOrMonthSelector = $request->input('selectDayMonth');
        $weekMonth = $request->input('selectWeekMonth');

        if ($dayOrMonthSelector == 'on') {
            $response =  $this->bullhornKpiService->loadOpenJobOrdersForCurrentMonth();
        } else {
            $response =  $this->bullhornKpiService->loadOpenJobOrdersForToday();
        }

        $weekData = $this->bullhornKpiService->loadsDailyJobOrderByWeek($cWeek);

        $yearData = $this->bullhornKpiService->loadsMonthlyJobOrderByYear($cYear);

        $weekNrs = $this->bullhornKpiService->getWeekNumbers();
        $yearNrs = $this->bullhornKpiService->getYears();

        return view('dashboard', ['vacancyCount' => $response['count'],
                                        'weekData' => $weekData,
                                        'yearData' => $yearData,
                                        'weekNr' => $weekNrs,
                                        'years' => $yearNrs,
                                        'currentWeek' => $cWeek,
                                        'currentYear' => $cYear,
                                        'dayMonth' => $dayOrMonthSelector,
                                        'weekMonth' => $weekMonth]);
    }
}
