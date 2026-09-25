<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidStatusTransitionException;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityService $activityService
    ) {}

    public function index(Request $request): View
    {
        $validStatuses = ['Planned', 'Ongoing', 'Done'];
        $selectedStatus = $request->query('status');

        $activities = Activity::query()
            ->when(in_array($selectedStatus, $validStatuses, true), function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->orderBy('activity_date')
            ->get();

        return view('activities.index', compact('activities', 'selectedStatus'));
    }

    public function create(): View
    {
        return view('activities.create', [
            'activity' => new Activity(),
        ]);
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->createActivity($request->validated());

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        try {
            $this->activityService->updateActivity($activity, $request->validated());

            return redirect()
                ->route('activities.show', $activity)
                ->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (InvalidStatusTransitionException $e) {
            return back()
                ->withInput()
                ->withErrors(['status' => $e->getMessage()]);
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $this->activityService->deleteActivity($activity);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    
}


