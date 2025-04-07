<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MlceIndentStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MlceIndent;
use App\Models\MlceRecommendation;
use App\Models\MlceType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request) {
        $data = $request->validate([
            "start_date" => ["nullable", "date_format:Y-m-d"],
            "end_date" => ["nullable", "date_format:Y-m-d"],
        ]);

        // Date ranges
        $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();
        $today = Carbon::now()->endOfDay();

        // Get custom date range if provided, otherwise use last 30 days
        $startDate = Carbon::parse($data["start_date"] ?? $thirtyDaysAgo)
            ->startOfDay();

        $endDate = Carbon::parse($data["end_date"] ?? $today)
            ->endOfDay();

        $customers = Customer::count();
        $users = User::count();

        // Summary counts for last 30 days (regardless of custom date range)
        $indentsSummary = [
            'total_indents' => MlceIndent::whereBetween('created_at', [$startDate, $endDate])->count(),
            'in_progress_indents' => MlceIndent::where('status', MlceIndentStatus::IN_PROGRESS->value)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'in_client_review_indents' => MlceIndent::where('status', MlceIndentStatus::IN_CLIENT_REVIEW->value)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];

        // Recommendations summary for last 30 days
        $recommendationsSummary = [
            'total_recommendations' => MlceRecommendation::whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending_recommendations' => MlceRecommendation::where('status', 'Pending')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];

        // Monthly indents data for line chart (last 12 months)
        $monthlyIndents = $this->getMonthlyIndentsData();

        // Indents by MLCE type for pie chart
        $indentsByType = $this->getIndentsByTypeData($startDate, $endDate);

        // Daily recommendations data for the specified range (or last 30 days by default)
        $dailyRecommendations = $this->getDailyRecommendationsData($startDate, $endDate);

        $indentsSummary["monthly"] = $monthlyIndents;
        $indentsSummary["by_type"] = $indentsByType;
        $recommendationsSummary["by_days"] = $dailyRecommendations;

        return response()->json([
            'customers' => $customers,
            'users' => $users,
            'indents' => $indentsSummary,
            'recommendations' => $recommendationsSummary,
        ]);
    }

    /**
     * Get monthly indents data for the last 12 months
     *
     * @return array
     */
    private function getMonthlyIndentsData() {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $monthlyData = MlceIndent::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Format data for chart
        $formattedData = [];
        $currentDate = $startDate->copy();

        // Create entries for all months, even if there's no data
        while ($currentDate <= $endDate) {
            $year = $currentDate->year;
            $month = $currentDate->month;
            $monthName = $currentDate->format('M Y');

            $count = 0;

            // Find if we have data for this month
            foreach ($monthlyData as $data) {
                if ($data->year == $year && $data->month == $month) {
                    $count = $data->count;
                    break;
                }
            }

            $formattedData[] = [
                'month' => $monthName,
                'count' => $count
            ];

            $currentDate->addMonth();
        }

        return $formattedData;
    }

    /**
     * Get indents by MLCE type for pie chart
     *
     * @return array
     */
    private function getIndentsByTypeData($startDate, $endDate) {
        return MlceType::select(
            'mlce_types.name',
            DB::raw('COALESCE(COUNT(mlce_indents.mlce_type_id), 0) as count')
        )
            ->leftJoin('mlce_indents', function ($join) use ($startDate, $endDate) {
                $join->on('mlce_types.id', '=', 'mlce_indents.mlce_type_id')
                    ->whereBetween('mlce_indents.created_at', [$startDate, $endDate]);
            })
            ->groupBy('mlce_types.name')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function getDailyRecommendationsData(Carbon $startDate, Carbon $endDate) {
        $dailyData = MlceRecommendation::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween("created_at", [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data for chart
        $formattedData = [];
        $currentDate = $startDate->copy();

        // Create entries for all days, even if there's no data
        while ($currentDate <= $endDate) {
            $date = $currentDate->format('Y-m-d');
            $displayDate = $currentDate->format('d M Y');

            $count = 0;

            // Find if we have data for this day
            foreach ($dailyData as $data) {
                if ($data->date == $date) {
                    $count = $data->count;
                    break;
                }
            }

            $formattedData[] = [
                'date' => $displayDate,
                'count' => $count
            ];

            $currentDate->addDay();
        }

        return $formattedData;
    }
}
