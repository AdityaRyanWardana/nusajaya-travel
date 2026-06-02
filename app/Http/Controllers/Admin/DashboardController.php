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
        $currentMonthBookings = Booking::where('type', 'tour')
            ->where('status', '!=', 'unpaid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $lastMonthBookings = Booking::where('type', 'tour')
            ->where('status', '!=', 'unpaid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $growth = 0;
        if ($lastMonthBookings > 0) {
            $growth = (($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100;
        } elseif ($currentMonthBookings > 0) {
            $growth = 100;
        }

        // Chart Data (Last 6 Months - Tours Only)
        $chartLabels = [];
        $tourChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M');
            
            $tourChartData[] = Booking::where('status', '!=', 'unpaid')
                ->where('type', 'tour')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // Revenue & Balance Stats (Tours Only)
        $totalRevenue = Booking::where('type', 'tour')->where('status', 'paid')->sum('amount');
        $lastMonthRevenue = Booking::where('type', 'tour')
            ->where('status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('amount');
        $pendingRevenue = Booking::where('type', 'tour')->where('status', 'pending')->sum('amount');

        $rescheduledBookings = Booking::with('user')
            ->where('type', 'tour')
            ->where('reschedule_notified', false)
            ->latest('rescheduled_at')
            ->get();

        $recentBookings = Booking::with('user')
            ->where('type', 'tour')
            ->where('status', '!=', 'unpaid')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_bookings' => Booking::where('type', 'tour')->where('status', '!=', 'unpaid')->count(),
            'pending_bookings' => Booking::where('type', 'tour')->where('status', 'pending')->count(),
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
            'rescheduled_bookings' => $rescheduledBookings,
            'recent_bookings' => $recentBookings,
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

        $tours = Tour::all();
        $armadas = Armada::all();
        
        $tourSchedule = [];
        $fleetSchedule = [];

        foreach ($dates as $date) {
            // Tour Schedule Data
            $tourDaily = [];
            foreach ($tours as $tour) {
                $tourDaily[$tour->id] = [
                    'booked' => Booking::where('type', 'tour')->where('service_slug', $tour->slug)->whereDate('travel_date', $date)->whereIn('status', ['pending', 'paid', 'completed'])->count()
                ];
            }
            $tourSchedule[$date] = $tourDaily;

            // Fleet Schedule Data
            $fleetDaily = [];
            foreach ($armadas as $armada) {
                $bookedCount = Booking::where('armada_id', $armada->id)->whereDate('travel_date', $date)->whereIn('status', ['pending', 'paid', 'completed'])->count();
                $fleetDaily[$armada->id] = [
                    'booked' => $bookedCount,
                    'ready' => max(0, $armada->total_units - $armada->maintenance_units - $bookedCount),
                    'total' => $armada->total_units,
                    'maintenance' => $armada->maintenance_units,
                ];
            }
            $fleetSchedule[$date] = $fleetDaily;
        }

        return view('admin.scheduling', compact('dates', 'tours', 'armadas', 'tourSchedule', 'fleetSchedule', 'selectedDate'));
    }

    public function notifications()
    {
        // Mocking some rich notifications since there's no DB table for it yet.
        $notifications = [
            [
                'id' => 1,
                'type' => 'booking',
                'title' => 'New Booking: Batam City Tour',
                'description' => 'A new booking has been made by John Doe for 4 people on the Batam City Tour package. Please review the customer details and assign an armada if needed.',
                'time' => '2 minutes ago',
                'icon' => 'shopping-cart',
                'color' => 'sky',
                'link' => route('admin.bookings.index')
            ],
            [
                'id' => 2,
                'type' => 'reschedule',
                'title' => 'Reschedule Request: VIP Bus',
                'description' => 'Customer Jane Smith has requested to reschedule their VIP Bus booking from Oct 12 to Oct 15. Check fleet availability for the new dates.',
                'time' => '1 hour ago',
                'icon' => 'refresh-cw',
                'color' => 'amber',
                'link' => route('admin.scheduling')
            ],
            [
                'id' => 3,
                'type' => 'payment',
                'title' => 'Payment Confirmed: #BOK-9921',
                'description' => 'Payment of Rp 2,500,000 for booking #BOK-9921 has been successfully verified by the payment gateway. The booking status is now Paid.',
                'time' => '5 hours ago',
                'icon' => 'check-circle',
                'color' => 'emerald',
                'link' => route('admin.bookings.index')
            ],
            [
                'id' => 4,
                'type' => 'system',
                'title' => 'System Maintenance Scheduled',
                'description' => 'A routine server maintenance is scheduled for tonight at 02:00 AM. The application might be briefly unavailable for 15 minutes.',
                'time' => '1 day ago',
                'icon' => 'server',
                'color' => 'indigo',
                'link' => '#'
            ]
        ];

        return view('admin.notifications', compact('notifications'));
    }

    public function markRescheduleAsNoticed(Booking $booking)
    {
        if (auth()->user()->role === 'superadmin') {
            abort(403, 'Superadmin has Audit Only access and cannot modify bookings.');
        }

        $booking->update(['reschedule_notified' => true]);
        return back()->with('success', 'Rescheduling notification cleared.');
    }
}
