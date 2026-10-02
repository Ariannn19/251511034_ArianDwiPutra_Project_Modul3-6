<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Http\Requests\StoreActivityRequest;
use App\Services\ActivityService;
use App\Exceptions\InvalidStatusTransitionException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $activities = Activity::with('category')
            ->filter($request->only(['search', 'category_id', 'status', 'sort']))
            ->paginate(10)
            ->withQueryString();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $activity = new Activity();
        $categories = Category::all();
        return view('activities.create', compact('activity', 'categories'));
    }

    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);
        $data['category'] = $category ? $category->name : 'Umum';

        $service->create($data);

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

    public function update(StoreActivityRequest $request, Activity $activity, ActivityService $service): RedirectResponse
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);
        $data['category'] = $category ? $category->name : 'Umum';

        try {
            $service->update($activity, $data);
        } catch (InvalidStatusTransitionException $e) {
            return back()->withInput()->withErrors(['status' => $e->getMessage()]);
        }

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
