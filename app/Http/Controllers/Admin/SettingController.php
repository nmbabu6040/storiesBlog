<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();
        return view(
            'admin.settings.edit',
            compact('setting', 'categories')
        );
    }

    public function update(Request $request)
    {
        $request->validate([

            'site_name' => 'nullable|string|max:255',

            'author_name' => 'nullable|string|max:255',

            'author_description' => 'nullable|string',

            'hero_title' => 'nullable|string|max:255',

            'hero_subtitle' => 'nullable|string',

            'hero_type_text' => 'nullable|string',

            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'facebook_url' => 'nullable|string|max:255',

            'instagram_url' => 'nullable|string|max:255',

            'youtube_url' => 'nullable|string|max:255',

            'copyright_text' => 'nullable|string',

            'header_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg,webp|max:1024',

            'author_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'footer_title_1' => 'nullable|string|max:255',

            'footer_title_2' => 'nullable|string|max:255',

            'footer_title_3' => 'nullable|string|max:255',

            'footer_title_4' => 'nullable|string|max:255',

            'phone' => 'nullable|string|max:50',

            'email' => 'nullable|email|max:255',

            'address' => 'nullable|string',

            'google_map' => 'nullable|string',

            'travel_category_id' => 'nullable|exists:categories,id',
            'destination_category_id' => 'nullable|exists:categories,id',
            'lifestyle_category_id' => 'nullable|exists:categories,id',
            'photography_category_id' => 'nullable|exists:categories,id',

            'site_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',

        ]);

        $setting = Setting::first();

        $data = $request->only([

            'site_name',

            'author_name',

            'author_description',

            'hero_title',

            'hero_subtitle',

            'hero_type_text',

            'facebook_url',

            'instagram_url',

            'youtube_url',

            'copyright_text',

            'footer_title_1',

            'footer_title_2',

            'footer_title_3',

            'footer_title_4',

            'phone',

            'email',

            'address',

            'google_map',

            'travel_category_id',
            'destination_category_id',
            'lifestyle_category_id',
            'photography_category_id',

            'site_description',
            'meta_keywords',

        ]);

        foreach (['facebook_url', 'instagram_url', 'youtube_url'] as $field) {

            if (
                !empty($data[$field]) &&
                !str_starts_with($data[$field], 'http://') &&
                !str_starts_with($data[$field], 'https://')
            ) {

                $data[$field] = 'https://' . $data[$field];
            }
        }

        foreach (
            [
                'header_logo',
                'footer_logo',
                'favicon',
                'author_image',
                'hero_image',
            ] as $fileField
        ) {

            if ($request->hasFile($fileField)) {

                if (!empty($setting->$fileField)) {

                    Storage::disk('public')->delete($setting->$fileField);
                }

                $data[$fileField] = $request
                    ->file($fileField)
                    ->store('settings', 'public');
            }
        }

        $setting->update($data);

        return back()->with(
            'success',
            'Settings Updated Successfully'
        );
    }
}
