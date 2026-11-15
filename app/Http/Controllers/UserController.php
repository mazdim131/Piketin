<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPiket;
use App\Models\RiwayatPiket;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'nis' => ['required'],
            'username' => ['required', 'min:3', 'unique:ms_user,username'],
            'email' => ['required', 'email:rfc', 'unique:ms_user,email'],
            'password' => ['required', 'min:8', 'max:20', 'confirmed', Password::min(8)->max(20)],
            'password_confirmation' => ['required'],
            [
                'username.required' => 'Username wajib diisi!',
                'username.min' => 'Username minimal 3 karakter',
                'username.unique' => 'Username sudah terdaftar',
                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email yang diinput sudah terdaftar',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 8 karakter',
                'password.max' => 'Password maximal 20 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'nis.required' => 'Nis wajib diisi!',
            ],
        ]);

        $createAccount = User::create([
            'nis' => $validate['nis'],
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'role' => 'siswa',
            'id_kelas' => null,
            'id_jadwal_piket' => null,
        ]);

        return redirect()->route('login')->with('success', 'Berhasil membuat akun! Silahkan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'token' => ['required'],
            [
                'email.required' => 'Email wajib diisi!',
                'password.required' => 'Password wajib diisi!',
                'token.required' => 'Token room wajib diisi!',
            ],
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $room = Room::where('token', strtoupper($credentials['token']))
                ->where('is_active', true)
                ->first();

            if (! $room) {
                Auth::logout();

                return back()->withErrors([
                    'token' => 'Token room tidak valid atau room tidak aktif.',
                ])->onlyInput('email');
            }

            Auth::user()->update(['room_id' => $room->id]);

            return redirect()
                ->route('home', $room)
                ->cookie('last_room_token', $room->token, 60 * 24 * 30)
                ->with('success', 'Login Berhasil! Selamat Datang');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    public function attendance(Request $request)
    {
        $user = Auth::user();

        if (! Auth::check()) {
            return back()->with('error', 'Anda harus login terlebih dahulu!');
        }

        $today = now()->startOfDay();
        $existing = AbsensiPiket::where('id_user', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah absen piket hari ini!');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password yang anda masukkan tidak dikenali!');
        }

        $status = $request->has('checkPiket') ? 'Menunggu Konfirmasi' : 'Hadir';

        $absensi = AbsensiPiket::create([
            'id_user' => $user->id,
            'status' => $status,
        ]);

        RiwayatPiket::create([
            'id_absensi_piket' => $absensi->id,
            'status_kehadiran' => 'hadir',
            'tanggal_kehadiran' => now(),
        ]);

        $message = $status === 'Menunggu Konfirmasi'
            ? 'Absensi dikirim, menunggu konfirmasi admin!'
            : 'Absensi berhasil!';

        return back()->with('success', $message);
    }

    // function halaman
    public function home()
    {
        $absensi = AbsensiPiket::where('status', 'Hadir')
            ->get();

        $lineas = $absensi->map(function ($item) {
            return [
                'username' => $item->user->username ?? 'Unknown',
            ];
        });

        return view('home', ['lineas' => $lineas]);
    }

    public function about()
    {
        return view('about');
    }

    public function absentStudents()
    {
        $absensi = AbsensiPiket::where('status', 'Hadir')
            ->get();

        $lineas = $absensi->map(function ($item) {
            return [
                'username' => $item->user->username ?? 'Unknown',
            ];
        });

        return view('home', ['lineas' => $lineas]);
    }

    public function set_job()
    {
        $roomId = Auth::user()?->room_id;

        $siswa = User::query()
            ->when($roomId, fn ($query) => $query->where('room_id', $roomId))
            ->where('role', 'siswa')
            ->orderBy('username')
            ->get();

        return view('piket', compact('siswa'));
    }

    public function piketData()
    {
        $absensi = AbsensiPiket::with(['user', 'user.JadwalPiket'])
            ->select('tr_absensi_piket.*');

        return DataTables::of($absensi)
            ->addIndexColumn()
            ->addColumn('username', function ($row) {
                return $row->user->username ?? 'Unknown';
            })
            ->addColumn('hari', function ($row) {
                return $row->user->JadwalPiket->hari ?? '-';
            })
            ->addColumn('tanggal', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y') : '-';
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button" class="btn btn-sm btn-primary" onclick="viewDetail('.$row->id.')">Detail</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function confirmation()
    {
        return view('confirmation');
    }

    public function kas()
    {
        return view('kas');
    }

    public function historyKas()
    {
        return view('historyKas');
    }

    public function warningLog()
    {
        return view('warningLog');
    }

    public function payKas()
    {
        return view('payKas');
    }

    public function piketLog()
    {
        return view('piketLog');
    }

    public function schedulePiket()
    {
        return view('schedulePiket');
    }
}
