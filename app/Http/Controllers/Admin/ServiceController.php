<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\AuditLog;
use App\Models\Service;
use App\Models\Setting;
use App\Services\VTpassService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display all services
     */
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('provider', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {

            if ($request->status == 'enabled') {
                $query->where('status', 1);
            }

            if ($request->status == 'disabled') {
                $query->where('status', 0);
            }
        }

        $services = $query->latest()->paginate(10);

        $totalServices = Service::count();

        $activeServices = Service::where('status',1)->count();

        $connectedApis = Service::whereNotNull('api_provider')->count();

        // $connectedApis = Service::whereNotNull('api_name')->count();

        $disabledServices = Service::where('status',0)->count();

        $averageProfit = Service::avg('profit');

            return view('Admin.service', [

            'services' => $services,
        
            'totalServices' => $totalServices,
        
            'activeServices' => $activeServices,
        
            'connectedApis' => $connectedApis,
        
            'disabledServices' => $disabledServices,
        
            'averageProfit' => $averageProfit,
        
        ]);
    }

    /**
     * Create service
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'=>'required|string|max:255',

            'provider'=>'required|string|max:255',

            'charge'=>'required|numeric|min:0',

            'profit'=>'required|numeric|min:0',

            'minimum'=>'required|numeric|min:0',

            'maximum'=>'required|numeric|gte:minimum',

            'api_name'      => 'nullable|string|max:255',
            'api_provider'  => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|url',
            'service_code'  => 'nullable|string|max:255',
            'api_key'       => 'nullable|string',
            'api_secret'    => 'nullable|string',

        ]);

        $service = Service::create([

        'name'=>$request->name,
        'provider'=>$request->provider,
        'charge'=>$request->charge,
        'profit'=>$request->profit,
        'minimum'=>$request->minimum,
        'maximum'=>$request->maximum,
    
        'api_name'=>$request->api_name,
        'api_provider'=>$request->api_provider,
        'api_endpoint'=>$request->api_endpoint,
        'service_code'=>$request->service_code,
        'api_key' => $request->filled('api_key')
        ? Crypt::encryptString($request->api_key)
        : null,

    'api_secret' => $request->filled('api_secret')
        ? Crypt::encryptString($request->api_secret)
        : null,
        'sandbox'=>$request->has('sandbox'),
    
        'status'=>1
    
    ]);
        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Created Service',
            'description' => 'Created '.$service->name,
        ]);
        return back()->with('success','Service added successfully.');
    }

    /**
     * Update service
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([

            'name'=>'required',

            'provider'=>'required',

            'charge'=>'required|numeric',

            'profit'=>'required|numeric',

            'minimum'=>'required|numeric',

            'maximum'=>'required|numeric|gte:minimum',

            'api_name'      => 'nullable|string|max:255',
            'api_provider'  => 'nullable|string|max:255',
            'api_endpoint'  => 'nullable|string',
            'service_code'  => 'nullable|string|max:255',
            'api_key'       => 'nullable|string',
            'api_secret'    => 'nullable|string',

        ]);

        $data = $request->only([
            'name',
            'provider',
            'charge',
            'profit',
            'minimum',
            'maximum',
            'api_name',
            'api_provider',
            'api_endpoint',
            'service_code',
            'api_key',
            'api_secret',
        ]);
        
        $data['sandbox'] = $request->has('sandbox');
        
        $service->update($data);

            AuditLog::create([

            'admin_id' => auth('admin')->id(),

            'action' => 'Updated Service',

            'description' => 'Updated '.$service->name,

        ]);

        return back()->with('success','Service updated.');
    }

    /**
     * Enable service
     */
    public function enable(Service $service)
    {
        $service->update([
            'status'=>1
        ]);

        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Enabled Service',
            'description' => 'Enabled '.$service->name,
        ]);

        return back()->with('success','Service enabled.');
    }

    /**
     * Disable service
     */
    public function disable(Service $service)
    {
        $service->update([
            'status'=>0
        ]);

        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Disabled Service',
            'description' => 'Disabled '.$service->name,
        ]);
    

        return back()->with('success','Service disabled.');
    }

    /**
     * Update Profit
     */
    public function profit(Request $request, Service $service)
    {
        $request->validate([
            'profit'=>'required|numeric|min:0'
        ]);

        $service->update([
            'profit'=>$request->profit
        ]);

        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Updated Profit',
            'description' => 'Updated profit for '.$service->name,
        ]);

        return back()->with('success','Profit updated.');
    }

    /**
     * Update Charge
     */
    public function charge(Request $request, Service $service)
    {
        $request->validate([
            'charge'=>'required|numeric|min:0'
        ]);

        $service->update([
            'charge'=>$request->charge
        ]);

        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Updated Charge',
            'description' => 'Updated charge for '.$service->name,
        ]);

        return back()->with('success','Charge updated.');
    }

    /**
     * Update Limits
     */
    public function limit(Request $request, Service $service)
    {
        $request->validate([

            'minimum'=>'required|numeric|min:0',

            'maximum'=>'required|numeric|gte:minimum'

        ]);

        $service->update([

            'minimum'=>$request->minimum,

            'maximum'=>$request->maximum

        ]);

        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Updated Limits',
            'description' => 'Updated transaction limits for '.$service->name,
        ]);

        return back()->with('success','Limits updated.');
    }

    /**
     * Configure API
     */
    public function api(Request $request, Service $service)
    {
        $request->validate([
            'api_name'      => 'required|string|max:255',
            'api_provider'  => 'nullable|string|max:255',
            'api_endpoint'  => 'nullable|url',
            'service_code'  => 'nullable|string|max:255',
            'api_key'       => 'nullable|string',
            'api_secret'    => 'nullable|string|max:500',
        ]);
    
        $service->api_name = $request->api_name;
        $service->api_provider = $request->api_provider;
        $service->api_endpoint = $request->api_endpoint;
        $service->service_code = $request->service_code;
        
    
        if ($request->filled('api_key')) {
            $service->api_key = Crypt::encryptString($request->api_key);
        }

        if ($request->filled('api_secret')) {
    $service->api_secret = Crypt::encryptString($request->api_secret);
}
    
        $service->sandbox = $request->has('sandbox');
    
        $service->save();
    
        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Updated API',
            'description' => 'Updated API settings for ' . $service->name,
        ]);
    
        return back()->with('success', 'API configuration updated successfully.');
    }

    /**
     * Delete service
     */
    public function destroy(Service $service)
    {
        $name = $service->name;
    
        $service->delete();
    
        AuditLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'Deleted Service',
            'description' => 'Deleted '.$name,
        ]);
    
        return back()->with('success','Service deleted.');
    }

    /**
     * Test API Connection
     */
    public function test(Service $service, VTpassService $vtpass)
    {
        $response = $vtpass->verify();
    
        if ($response->successful()) {
    
            return back()->with(
                'success',
                'API Connected Successfully.'
            );
    
        }
    
        return back()->with(
            'error',
            'Unable to connect to API.'
        );
    }

    public function updateSecurity(Request $request)
{
    $validated = $request->validate([
        'two_factor' => ['nullable', 'boolean'],
        'maintenance_mode' => ['nullable', 'boolean'],
        'login_attempts' => ['required', 'integer', 'min:1', 'max:20'],
        'lockout_duration' => ['required', 'integer', 'min:1', 'max:1440'],
        'session_timeout' => ['required', 'integer', 'min:1', 'max:1440'],
    ]);

    $settings = Setting::first();

    if (!$settings) {
        return back()->withErrors([
            'settings' => 'System settings record was not found.',
        ]);
    }

    $settings->update([
        'two_factor' => $request->boolean('two_factor'),
        'maintenance_mode' => $request->boolean('maintenance_mode'),
        'login_attempts' => $validated['login_attempts'],
        'lockout_duration' => $validated['lockout_duration'],
        'session_timeout' => $validated['session_timeout'],
    ]);

    return back()->with('success', 'Security settings updated successfully.');
}
}