<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\ReportHistory;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $histories = ReportHistory::with('admin')
        ->latest()
        ->paginate(10);

        return view('admin.report',[

            'totalRevenue'=>Transaction::where('status','Successful')->sum('amount'),

            'totalTransactions'=>Transaction::count(),

            'totalUsers'=>User::count(),

            'totalDeposits'=>Deposit::count(),

            'totalServices'=>Service::count(),

            'totalReferrals'=>User::whereNotNull('referred_by')->count(),

            'pendingKyc' => 0,

            'histories' => $histories,

        ]);
    }

    public function history()
{
    $histories = ReportHistory::latest()->paginate(10);

    return view('admin.report-history', compact('histories'));
}

    public function generate($type)
    {
        switch($type){

            case 'revenue':

                $data=Transaction::where('status','Successful')->latest()->get();

                break;

            case 'transactions':

                $data=Transaction::latest()->get();

                break;

            case 'users':

                $data=User::latest()->get();

                break;

            case 'deposits':

                $data=Deposit::latest()->get();

                break;

            case 'referrals':

                $data=User::whereNotNull('referred_by')->get();

                break;

            case 'kyc':

                $data=User::select(
                    'name',
                    'email',
                    'nin_status'
                )->get();

                break;

            case 'services':

                $data=Service::all();

                break;

            default:

                abort(404);

        }

        return view('admin.report-view',compact(
            'data',
            'type'
        ));
    }

    public function export($type, $format)
    {
        $data = $this->getReportData($type);
    
        switch ($format) {
    
            case 'pdf':
    
                $pdf = Pdf::loadView('admin.exports', [
                    'data' => $data,
                    'type' => $type,
                ])->setPaper('a4', 'landscape');
    
                return $pdf->download($type . '-report.pdf');
    
            case 'excel':
    
                return Excel::download(
                    new ReportExport($data),
                    $type . '-report.xlsx'
                );
    
            case 'csv':
    
                return Excel::download(
                    new ReportExport($data),
                    $type . '-report.csv',
                    \Maatwebsite\Excel\Excel::CSV
                );
    
            default:
    
                abort(404);
        }
    }
    
    private function getReportData($type)
{
    switch ($type) {

        case 'revenue':
            return Transaction::where('status', 'Successful')->get();

        case 'transactions':
            return Transaction::latest()->get();

        case 'users':
            return User::latest()->get();

        case 'deposits':
            return Deposit::latest()->get();

        case 'services':
            return Service::latest()->get();

        case 'referrals':
            return User::whereNotNull('referred_by')->get();

        default:
            abort(404);
    }
}

}