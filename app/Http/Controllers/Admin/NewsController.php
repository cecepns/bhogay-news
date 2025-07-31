<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index(Request $request): View
    {
        $query = News::with('category')->latest();

        // Handle search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created news in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('news-thumbnails', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }

    /**
     * Display the specified news.
     */
    public function show(News $news): View
    {
        $news->load('category');
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit(News $news): View
    {
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('news-thumbnails', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy(News $news): RedirectResponse
    {
        // Delete thumbnail
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News deleted successfully.');
    }

    /**
     * Handle Trix Editor attachment upload.
     */
    public function uploadTrixAttachment(Request $request)
    {
        $request->validate([
            'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            // Store the attachment
            $path = $request->file('attachment')->store('trix-attachments', 'public');
            
            // Get file info
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $filesize = $file->getSize();
            $url = asset('storage/' . $path);

            return response()->json([
                'attachment' => [
                    'url' => $url,
                    'filename' => $filename,
                    'filesize' => $filesize,
                    'content_type' => $file->getMimeType()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload attachment: ' . $e->getMessage()
            ], 500);
        }
    }
}
