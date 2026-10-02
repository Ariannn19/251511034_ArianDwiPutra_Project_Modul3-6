<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidStatusTransitionException;
use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ActivityController extends Controller
{

    public function __construct(
        protected ActivityService $activityService
    ) {}

    public function index(Request $request): View
    {
        $categories = Category::all();

        $activities = Activity::with('category')
            ->filter($request->only(['search', 'category_id', 'status', 'sort']))
            ->paginate(10)
            ->withQueryString();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $this->activityService->create($data);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dibuat!');
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

        if ($request->hasFile('poster')) {
            // Hapus file lama jika ada
            if ($activity->poster_path && Storage::disk('public')->exists($activity->poster_path)) {
                Storage::disk('public')->delete($activity->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        try {
            $this->activityService->update($activity, $data);
        } catch (InvalidStatusTransitionException $e) {
            return back()->withInput()->withErrors(['status' => $e->getMessage()]);
        }

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus (Soft Delete)!');
    }

    public function trash(): View
    {
        $trashedActivities = Activity::onlyTrashed()->with('category')->latest()->get();
        return view('activities.trash', compact('trashedActivities'));
    }

    public function restore(int $id): RedirectResponse
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()->route('activities.trash')->with('success', 'Kegiatan berhasil dipulihkan!');
    }

    public function register(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ]);

        try {
            $this->activityService->registerParticipant($activity, $validated);
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'UNIQUE constraint failed') || str_contains($e->getMessage(), 'Duplicate entry')) {
                return back()->withInput()->withErrors(['email' => 'Email ini sudah terdaftar pada kegiatan tersebut.']);
            }
            throw $e;
        }

        return back()->with('success', 'Pendaftaran berhasil! Kuota peserta telah diperbarui.');
    }
}
