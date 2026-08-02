<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([]);
        }

        return view('admin.settings', compact('setting'));
    }

    public function update(Request $request)
    {
        
        $setting = Setting::first();

        $request->validate([

        'site_name'=>'required|string|max:255',

        'logo'=>'nullable|image|mimes:png,jpg,jpeg|max:2048',

        'contact_information'=>'nullable|string',

        'currency'=>'required',

        'timezone'=>'required',

        'login_attempts'=>'required|integer|min:1',

        'session_timeout'=>'required|integer|min:5',

        'minimum_deposit'=>'required|numeric',

        'minimum_withdrawal'=>'required|numeric',

        'discount' => 'required|numeric|min:0|max:100',

        'profit_percentage'=>'required|numeric',

        'airtime_api'=>'nullable|string',

        'data_api'=>'nullable|string',

        'electricity_api'=>'nullable|string',

        'cable_api'=>'nullable|string',

        'betting_api'=>'nullable|string',

        'smtp_server'=>'nullable|string',

        'sender_name'=>'nullable|string',

        'sms_provider'=>'nullable|string',

        'sms_api_key'=>'nullable|string',

        ]);

        
        $data = $request->except('logo');

        $data['two_factor']=$request->has('two_factor');

        $data['maintenance_mode']=$request->has('maintenance_mode');


        if ($request->hasFile('logo')) {

            if($setting->logo){

                Storage::disk('public')->delete($setting->logo);

            }

            $data['logo']=$request->file('logo')
            ->store('logos','public');
        }

        $setting->update($data);

        return back()->with('success','Settings updated successfully.');
    }
}