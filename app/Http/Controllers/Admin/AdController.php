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
    public function index(Request $request): View
    {
        $query = Ad::latest();

        // Handle search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('size', 'like', "%{$search}%");
            });
        }

        $ads = $query->paginate(15);

        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new ad.
     */
    public function create(): View
    {
        $sizes = ['468x60', '160x300', '320x50', '300x250', '160x600', '728x90'];
        $positions = ['header', 'sidebar', 'footer', 'content-top', 'content-bottom'];
        
        return view('admin.ads.create', compact('sizes', 'positions'));
    }

    /**
     * Store a newly created ad in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
            'size' => 'required|in:468x60,160x300,320x50,300x250,160x600,728x90',
            'position' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('ads', 'public');
        }

        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active', true);

        Ad::create($validated);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad created successfully.');
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
        $sizes = ['468x60', '160x300', '320x50', '300x250', '160x600', '728x90'];
        $positions = ['header', 'sidebar', 'footer', 'content-top', 'content-bottom'];
        
        return view('admin.ads.edit', compact('ad', 'sizes', 'positions'));
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
            'size' => 'required|in:468x60,160x300,320x50,300x250,160x600,728x90',
            'position' => 'required|string|max:255',
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

    /**
     * Remove the specified ad from storage.
     */
    public function destroy(Ad $ad): RedirectResponse
    {
        // Delete image
        if ($ad->image_url) {
            Storage::disk('public')->delete($ad->image_url);
        }
        
        $ad->delete();

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad deleted successfully.');
    }
}
