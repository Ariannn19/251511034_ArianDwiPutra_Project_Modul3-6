<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Http\Requests\StoreActivityRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::with('category')->latest()->paginate(10);
        return view('activities.index', compact('activities'));
    }

    public function create(): View
    {
        $activity = new Activity();
        $categories = Category::all();
        return view('activities.create', compact('activity', 'categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);
        $data['category'] = $category ? $category->name : 'Umum';

        Activity::create($data);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Activity $activity): View
    {
        $activity->load('category');
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::all();
        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(StoreActivityRequest $request, Activity $activity): RedirectResponse
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);
        $data['category'] = $category ? $category->name : 'Umum';

        $activity->update($data);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
