<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SettingAdminController extends Controller
{
    /**
     * @var list<string>
     */
    private const ALLOWED_KEYS = [
        'site.about.en',
        'site.about.fr',
        'site.training.en',
        'site.training.fr',
    ];

    public function index(): AnonymousResourceCollection
    {
        return SettingResource::collection(
            Setting::query()->whereIn('key', self::ALLOWED_KEYS)->orderBy('key')->get()
        );
    }

    public function update(Request $request, Setting $setting): SettingResource
    {
        abort_unless(in_array($setting->key, self::ALLOWED_KEYS, true), 404);

        $validated = $request->validate([
            'value' => ['required', 'array'],
        ]);

        $setting->update(['value' => $validated['value']]);

        return SettingResource::make($setting->fresh());
    }
}
