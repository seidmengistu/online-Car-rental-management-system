<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemSettingController extends Controller
{
    /**
     * Display system settings
     */
    public function index()
    {
        $settings = SystemSetting::orderBy('group')->orderBy('key')->get();

        // Group settings by their group
        $groupedSettings = $settings->groupBy('group');

        return view('admin.settings.index', compact('groupedSettings'));
    }

    /**
     * Show edit form for a setting
     */
    public function edit(SystemSetting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update a setting
     */
    public function update(Request $request, SystemSetting $setting)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting->update([
            'value' => $request->value,
            'description' => $request->description,
        ]);

        \App\Models\ActivityLog::log(
            'update_setting',
            "Updated system setting: {$setting->key}",
            $setting,
            ['old_value' => $setting->getOriginal('value'), 'new_value' => $request->value]
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting updated successfully!');
    }

    /**
     * Create a new setting
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a new setting
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|unique:system_settings,key',
            'value' => 'required',
            'type' => 'required|in:string,number,boolean,json',
            'group' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting = SystemSetting::create($request->all());

        \App\Models\ActivityLog::log(
            'create_setting',
            "Created system setting: {$setting->key}",
            $setting
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully!');
    }

    /**
     * Delete a setting
     */
    public function destroy(SystemSetting $setting)
    {
        $key = $setting->key;
        $setting->delete();

        \App\Models\ActivityLog::log(
            'delete_setting',
            "Deleted system setting: {$key}"
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully!');
    }
}
