<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * ANCHOR: Display a listing of tags
     */
    public function index()
    {
        $tags = Tag::withCount('news')
            ->latest()
            ->paginate(15);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * ANCHOR: Show the form for creating a new tag
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * ANCHOR: Store a newly created tag in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dibuat.');
    }

    /**
     * ANCHOR: Display the specified tag
     */
    public function show(Tag $tag)
    {
        $tag->load(['news' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.tags.show', compact('tag'));
    }

    /**
     * ANCHOR: Show the form for editing the specified tag
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * ANCHOR: Update the specified tag in storage
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui.');
    }

    /**
     * ANCHOR: Remove the specified tag from storage
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }
}
