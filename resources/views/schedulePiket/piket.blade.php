@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (Auth::check() && Auth::user()->role == 'admin')
                <div class="d-col">
                    <h1>Pengaturan Piket Siswa</h1>
                    <p>Atuh jobdesk dan jadwal piket untuk setiap siswa</p>
                </div>
            @else
                <div class="d-col">
                    <h1>Jadwal Piket</h1>
                    <p>Lihat jadwal piket untuk setiap siswa</p>
                </div>
            @endif

            @if (Auth::check() && Auth::user()->role == 'admin')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">Tambah
                    Siswa</button>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }};
            </div>
        @endif

        <div class="piket-table-card">
            <div class="card-body">
                <table class="table w-100" id="piket-schedule-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Jobdesk</th>
                            <th>Hari Piket</th>

                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- isian table --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal modal-content-piketSchedule fade" id="modalTambahSiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-5">
                <form action="{{ route('piketSchedule.store') }}" method="POST">
                    @csrf
                    <div class="">
                        <h4 class="modal-title">Edit Piket Siswa</h4>
                        <p class="text-secondary">Atur jobdesk dan hari piket untuk siswa yang dipilih.</p>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswa ?? [] as $s)
                                    <option value="{{ $s->id }}" @selected(old('id_user') == $s->id)>
                                        {{ $s->username }} ({{ $s->nis }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hari Piket</label>
                            <select name="day" class="form-select @error('day') is-invalid @enderror" required>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $d)
                                    <option value="{{ $d }}" @selected(old('day') == $d)>{{ $d }}
                                    </option>
                                @endforeach
                            </select>
                            @error('day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jobdesk</label>
                            <select name="jobdesk" class="form-select @error('jobdesk') is-invalid @enderror" required>
                                @foreach (['Menyapu', 'Mengepel', 'Lap Kaca'] as $j)
                                    <option value="{{ $j }}" @selected(old('jobdesk') == $j)>{{ $j }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jobdesk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center ms-auto gap-4">
                        <div class="col-5">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Batal</button>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPiket" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <form method="POST">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <h4 class="modal-title">Edit Piket Siswa</h4>
                        <p class="text-secondary">Atur jobdesk dan hari piket untuk siswa yang dipilih.</p>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select name="id_user" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswa ?? [] as $s)
                                    <option value="{{ $s->id }}">{{ $s->username }} ({{ $s->nis }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hari Piket</label>
                            <select name="day" class="form-select" required>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jobdesk</label>
                            <select name="jobdesk" class="form-select" required>
                                @foreach (['Menyapu', 'Mengepel', 'Lap Kaca'] as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center ms-auto gap-4">
                        <div class="col-5">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Batal</button>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#piket-schedule-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('piketSchedule.index') }}",
                dom: 'rt<"piket-table-footer d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3"ip>',
                language: {
                    info: "Menampilkan _START_-_END_ dari _TOTAL_ siswa",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    emptyTable: "Belum ada data jadwal piket",
                    zeroRecords: "Data tidak ditemukan"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'jobdesk',
                        name: 'jobdesk',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'day',
                        name: 'day',
                        orderable: false,
                        searchable: false
                    }
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        , {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endif
                ]
            });

            $('#modalEditPiket').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                modal.find('form').attr('action', button.attr('data-update-url'));
                modal.find('select[name="id_user"]').val(button.attr('data-user-id'));
                modal.find('select[name="day"]').val(button.attr('data-day'));
                modal.find('select[name="jobdesk"]').val(button.attr('data-jobdesk'));
            });
        });
    </script>
@endpush
