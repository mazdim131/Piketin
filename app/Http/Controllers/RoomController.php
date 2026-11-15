<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function landing(Request $request)
    {
        if ($token = $request->cookie('last_room_token')) {
            $room = Room::where('token', $token)->where('is_active', true)->first();
            if ($room) {
                return redirect()->route('room.show', $room);
            }
        }

        return view('landing');
    }

    public function join(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $room = Room::where('token', strtoupper($request->token))
            ->where('is_active', true)
            ->firstOrFail();

        return redirect()
            ->route('room.show', $room)
            ->cookie('last_room_token', $room->token, 60 * 24 * 30);
    }

    public function show(Room $room)
    {
        abort_unless($room->is_active, 404);

        $siswa = $room->students()->get();
        $isOwner = Auth::check() && Auth::id() === $room->admin_id;

        return view('room.show', compact('room', 'siswa', 'isOwner'));
    }
}
