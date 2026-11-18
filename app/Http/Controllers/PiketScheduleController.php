<?php

namespace App\Http\Controllers;

use App\Models\JadwalPiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PiketScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roomId = Auth::user()?->room_id;

        if ($request->ajax()) {
            $model = JadwalPiket::query()
                ->with('user')
                ->whereHas('user', function ($query) use ($roomId) {
                    if ($roomId) {
                        $query->where('room_id', $roomId);
                    }
                });

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->user->username ?? '-';
                })
                ->addColumn('jobdesk', function ($row) {
                    return '<span class="badge-jobdesk">'.e($row->jobdesk).'</span>';
                })
                ->addColumn('day', function ($row) {
                    $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'];
                    $fullDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    $html = '<div class="day-buttons">';

                    foreach ($days as $index => $label) {
                        $active = $row->day === $fullDays[$index] ? 'day-btn-active' : 'day-btn-inactive';
                        $html .= '<button type="button" class="day-btn '.$active.'" data-day="'.e($fullDays[$index]).'">'.$label.'</button>';
                    }

                    $html .= '</div>';

                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $updateUrl = route('piketSchedule.update', $row->id);
                    $deleteUrl = route('piketSchedule.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="action-buttons">
                            <button type="button" class="btn-action btn-edit" title="Edit"
                                data-bs-toggle="modal" data-bs-target="#modalEditPiket"
                                data-id="'.e($row->id).'"
                                data-user-id="'.e($row->user?->id).'"
                                data-username="'.e($row->user?->username ?? '-').'"
                                data-day="'.e($row->day).'"
                                data-jobdesk="'.e($row->jobdesk).'"
                                data-update-url="'.$updateUrl.'">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="'.$deleteUrl.'" method="POST" class="d-inline">
                                '.$csrf.'
                                '.$method.'
                                <button type="submit" class="btn-action btn-delete" title="Hapus" onclick="return confirm(\'Apakah anda yakin ingin menghapus jadwal piket ini?\')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })

                ->rawColumns(['jobdesk', 'day', 'action'])
                ->toJson();
        }

        $siswa = User::query()
            ->when($roomId, fn ($query) => $query->where('room_id', $roomId))
            ->where('role', 'siswa')
            ->orderBy('username')
            ->get();

        return view('schedulePiket.piket', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => ['required'],
            'day' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat'],
            'jobdesk' => ['required', 'in:Menyapu,Mengepel,Lap Kaca'],
        ]);

        $siswa = User::findOrFail($validated['id_user']);

        abort_unless($siswa->role === 'siswa', 403);
        abort_unless(Auth::user()?->room_id === $siswa->room_id, 403);

        $jadwal = JadwalPiket::create($validated);

        $siswa->update(['id_jadwal_piket' => $jadwal->id]);

        return redirect()
            ->route('piketSchedule.index')
            ->with('success', 'Jadwal piket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $piketSchedule = JadwalPiket::findOrFail($id);

        return view('schedulePiket.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'id_user' => ['required'],
            'day' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat'],
            'jobdesk' => ['required', 'in:Menyapu,Mengepel,Lap Kaca'],
        ]);

        $piketSchedule = JadwalPiket::findOrFail($id);
        $siswaBaru = User::findOrFail($validated['id_user']);

        abort_unless($siswaBaru->role === 'siswa', 403);
        abort_unless(Auth::user()?->room_id === $siswaBaru->room_id, 403);

        $siswaLama = $piketSchedule->user;

        if ($siswaLama && $siswaLama->id !== $siswaBaru->id) {
            $siswaLama->update(['id_jadwal_piket' => null]);
        }

        $piketSchedule->update($validated);
        $siswaBaru->update(['id_jadwal_piket' => $piketSchedule->id]);

        return redirect()
            ->route('piketSchedule.index')
            ->with('success', 'Jadwal piket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $piketSchedule = JadwalPiket::findOrFail($id);

        $piketSchedule->delete();

        return redirect()->route('piketSchedule.index')->with('success', 'Jadwal siswa berhasil di hapus!');
    }
}
