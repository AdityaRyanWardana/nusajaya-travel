<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Armada;
use App\Models\Tour;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Monthly Growth Calculation
        $currentMonthBookings = Booking::where('status', '!=', 'unpaid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $lastMonthBookings = Booking::where('status', '!=', 'unpaid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $growth = 0;
        if ($lastMonthBookings > 0) {
            $growth = (($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100;
        } elseif ($currentMonthBookings > 0) {
            $growth = 100;
        }

        // Chart Data (Last 6 Months)
        $chartLabels = [];
        $tourChartData = [];
        $transportChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M');
            
            $tourChartData[] = Booking::where('status', '!=', 'unpaid')
                ->where('type', 'tour')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
                
            $transportChartData[] = Booking::where('status', '!=', 'unpaid')
                ->where('type', 'transport')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // Revenue & Balance Stats
        $totalRevenue = Booking::where('status', 'paid')->sum('amount');
        $lastMonthRevenue = Booking::where('status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('amount');
        $pendingRevenue = Booking::where('status', 'pending')->sum('amount');

        $stats = [
            'total_bookings' => Booking::where('status', '!=', 'unpaid')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_armada' => Armada::sum('total_units'),
            'available_armada' => Armada::sum('total_units') - Armada::sum('maintenance_units'),
            'maintenance_armada' => Armada::sum('maintenance_units'),
            'total_tours' => Tour::count(),
            'booking_growth' => round($growth, 1),
            'total_revenue' => $totalRevenue,
            'last_month_revenue' => $lastMonthRevenue,
            'pending_revenue' => $pendingRevenue,
            'chart_labels' => $chartLabels,
            'tour_chart_data' => $tourChartData,
            'transport_chart_data' => $transportChartData,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'csv');
        $bookings = Booking::with('user')
            ->where('status', '!=', 'unpaid')
            ->latest()
            ->get();

        if ($type === 'csv') {
            $fileName = 'bookings_report_' . date('Ymd') . '.csv';
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Order Number', 'Customer', 'Service', 'Type', 'Amount', 'Travel Date', 'Status');

            $callback = function() use($bookings, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($bookings as $booking) {
                    fputcsv($file, array(
                        $booking->order_number,
                        $booking->user->name,
                        $booking->service_name,
                        $booking->type,
                        $booking->amount,
                        $booking->travel_date ? $booking->travel_date->format('Y-m-d') : '-',
                        $booking->status
                    ));
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // For PDF, we'll just redirect to a printable view or similar
        return back()->with('error', 'PDF Export currently uses browser print. Click Export > Print PDF on the dashboard.');
    }
    public function scheduling(Request $request)
    {
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $daysToShow = 14;
        $dates = [];
        for ($i = 0; $i < $daysToShow; $i++) {
            $dates[] = now()->addDays($i)->format('Y-m-d');
        }

        $armadas = Armada::all();
        $scheduleData = [];

        foreach ($dates as $date) {
            $dailyStats = [];
            foreach ($armadas as $armada) {
                $bookedCount = Booking::where('armada_id', $armada->id)
                    ->whereDate('travel_date', $date)
                    ->whereIn('status', ['pending', 'paid', 'completed'])
                    ->count();

                $dailyStats[$armada->id] = [
                    'booked' => $bookedCount,
                    'ready' => max(0, $armada->total_units - $armada->maintenance_units - $bookedCount),
                    'maintenance' => $armada->maintenance_units,
                    'total' => $armada->total_units,
                ];
            }
            $scheduleData[$date] = $dailyStats;
        }

        return view('admin.scheduling', compact('dates', 'armadas', 'scheduleData', 'selectedDate'));
    }
}
