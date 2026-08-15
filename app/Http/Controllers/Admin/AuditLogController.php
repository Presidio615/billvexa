<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public static function record(
        string $activity,
        ?string $description = null
    ): void {
        $admin = auth('admin')->user();

        AuditLog::create([
            'admin_id' => $admin?->id,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    public function index(Request $request)
    {
        $query = AuditLog::with('admin')->latest();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('activity', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('admin', function ($admin) use ($search) {

                        $admin->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");

                    });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Activity Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('activity')) {
            $query->where('activity', $request->activity);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalLogs = AuditLog::count();

        $todayActivities = AuditLog::whereDate(
            'created_at',
            today()
        )->count();

        $adminLogins = AuditLog::whereDate(
            'created_at',
            today()
        )
        ->where('activity', 'Login')
        ->count();

        $settingsChanges = AuditLog::whereDate(
            'created_at',
            today()
        )
        ->where('activity', 'Settings Changed')
        ->count();

        return view('Admin.logs', compact(
            'logs',
            'totalLogs',
            'todayActivities',
            'adminLogins',
            'settingsChanges'
        ));
    }
}