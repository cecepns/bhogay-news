<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Display a listing of the ads.
     */
    public function index(): View
    {
        $ads = Ad::latest()->paginate(15);

        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Display the specified ad.
     */
    public function show(Ad $ad): View
    {
        return view('admin.ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified ad.
     */
    public function edit(Ad $ad): View
    {
        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified ad in storage.
     */
    public function update(Request $request, Ad $ad): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($ad->image_url) {
                Storage::disk('public')->delete($ad->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('ads', 'public');
        }

        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active', $ad->is_active);

        $ad->update($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad updated successfully.');
    }
}
