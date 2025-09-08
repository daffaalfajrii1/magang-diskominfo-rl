@extends('admin.layouts.app')
@section('title','Detail Pengajuan - '.config('app.name'))

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-gray-800 mb-0">Detail Pengajuan</h1>
    <a href="{{ route('admin.internships.index') }}" class="btn btn-light btn-sm">← Kembali</a>
  </div>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if($errors->any())     <div class="alert alert-danger">{{ $errors->first() }}</div>  @endif

  <div class="row">
    {{-- KIRI --}}
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Informasi Pemohon</h6>
          @php $map=['awaiting_letter'=>'warning','waiting_confirmation'=>'info','active'=>'success','rejected'=>'danger']; @endphp
          <span class="badge badge-{{ $map[$internship->status] ?? 'light' }}">{{ strtoupper(str_replace('_',' ',$internship->status)) }}</span>
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <dt class="col-sm-4">Nama Akun</dt>
            <dd class="col-sm-8">{{ $internship->user->name }}</dd>

            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8">{{ $internship->user->email }}</dd>

            <dt class="col-sm-4">Surat Pemohon</dt>
            <dd class="col-sm-8">
              @if($internship->letter_path)
                <a target="_blank" href="{{ asset('storage/'.$internship->letter_path) }}" class="btn btn-outline-primary btn-sm">Lihat PDF</a>
              @else
                <span class="text-muted">—</span>
              @endif
            </dd>

            <dt class="col-sm-4">Diunggah</dt>
            <dd class="col-sm-8">{{ optional($internship->letter_uploaded_at)->format('d M Y H:i') ?? '—' }}</dd>

            @if($internship->status==='active')
              <dt class="col-sm-4">Status Peserta</dt>
              <dd class="col-sm-8">
                AKTIF sejak {{ optional($internship->confirmed_at)->format('d M Y H:i') ?? '-' }}
                @if($internship->approval_letter_path)
                  • <a target="_blank" href="{{ asset('storage/'.$internship->approval_letter_path) }}" class="btn btn-outline-success btn-sm">Surat Balasan</a>
                @endif
              </dd>
            @endif

            {{-- Biodata --}}
            <dt class="col-sm-12 mt-3" id="biodata"><strong>Biodata Peserta</strong></dt>
            @if($internship->profile_completed_at)
              <dt class="col-sm-4">Nama Lengkap</dt><dd class="col-sm-8">{{ $internship->full_name ?? $internship->user->name }}</dd>
              <dt class="col-sm-4">WhatsApp</dt><dd class="col-sm-8">{{ $internship->whatsapp }}</dd>
              <dt class="col-sm-4">Sekolah/Kampus</dt><dd class="col-sm-8">{{ $internship->school }}</dd>
              <dt class="col-sm-4">Jurusan/Prodi</dt><dd class="col-sm-8">{{ $internship->major }}</dd>
              <dt class="col-sm-4">NIS/NIM</dt><dd class="col-sm-8">{{ $internship->student_id ?? '—' }}</dd>
              <dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ $internship->address }}</dd>
              <dt class="col-sm-4">Periode</dt>
              <dd class="col-sm-8">
                @if($internship->start_date && $internship->end_date)
                  {{ $internship->start_date->format('d M Y') }} s/d {{ $internship->end_date->format('d M Y') }}
                @else — @endif
              </dd>
            @else
              <dd class="col-sm-12 text-muted">Biodata belum diisi.</dd>
            @endif

            {{-- Laporan --}}
            <dt class="col-sm-12 mt-3" id="laporan"><strong>Laporan Akhir</strong></dt>
            @if($internship->final_report_uploaded_at)
              <dt class="col-sm-4">Diunggah</dt><dd class="col-sm-8">{{ $internship->final_report_uploaded_at->format('d M Y H:i') }}</dd>
              <dt class="col-sm-4">Berkas</dt>
              <dd class="col-sm-8">
                @if($internship->final_report_path)
                  <a target="_blank" href="{{ asset('storage/'.$internship->final_report_path) }}" class="btn btn-outline-info btn-sm">Lihat Laporan</a>
                @else <span class="text-muted">—</span> @endif
              </dd>
            @else
              <dd class="col-sm-12 text-muted">Belum ada laporan.</dd>
            @endif

            {{-- Riwayat Pesan --}}
            <dt class="col-sm-12 mt-3"><strong>Pesan ke Peserta</strong></dt>
            <dd class="col-sm-12">
              @forelse($internship->messages as $m)
                <div class="border rounded p-2 mb-2">
                  <div class="small text-muted">
                    {{ $m->created_at->format('d M Y H:i') }} • oleh {{ $m->admin->name ?? 'Admin' }}
                  </div>
                  @if($m->subject)
                    <div class="font-weight-bold">{{ $m->subject }}</div>
                  @endif
                  <div>{{ $m->body }}</div>
                </div>
              @empty
                <span class="text-muted">Belum ada pesan.</span>
              @endforelse
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- KANAN: Aksi --}}
    <div class="col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-success">Aksi</h6>
        </div>
        <div class="card-body">

          {{-- APPROVE (hanya saat menunggu) --}}
          @if(in_array($internship->status, ['waiting_confirmation','awaiting_letter']))
            <form method="POST" action="{{ route('admin.internships.approve',$internship) }}" enctype="multipart/form-data" class="mb-4">
              @csrf
              <div class="form-group">
                <label class="small">Surat Balasan (PDF) — opsional saat menyetujui</label>
                <input type="file" name="approval_letter" accept="application/pdf" class="form-control-file">
              </div>
              <button class="btn btn-success btn-block"><i class="fas fa-check mr-1"></i> Setujui (Menjadi AKTIF)</button>
            </form>
            <hr>
          @endif

          {{-- UPLOAD / REPLACE SURAT BALASAN (waiting/active) --}}
          @if(in_array($internship->status, ['waiting_confirmation','active']))
            <h6 class="font-weight-bold mb-2">Unggah/Perbarui Surat Balasan</h6>
            <form method="POST" action="{{ route('admin.internships.approval_letter', $internship) }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <input type="file" name="approval_letter" accept="application/pdf" class="form-control-file" required>
              </div>
              <button class="btn btn-primary btn-block"><i class="fas fa-file-upload mr-1"></i> Unggah/Perbarui Surat</button>
            </form>
            @if($internship->approval_letter_path)
              <a target="_blank" href="{{ asset('storage/'.$internship->approval_letter_path) }}" class="btn btn-outline-success btn-sm mt-3">Lihat Surat Balasan</a>
            @endif
            <hr class="my-4">
          @endif

          {{-- KIRIM PESAN --}}
          <h6 class="font-weight-bold mb-2">Kirim Pesan ke Peserta</h6>
          <form method="POST" action="{{ route('admin.internships.message', $internship) }}">
            @csrf
            <div class="form-group"><input type="text" name="subject" class="form-control" placeholder="Subjek (opsional)"></div>
            <div class="form-group"><textarea name="body" class="form-control" rows="3" required placeholder="Isi pesan singkat..."></textarea></div>
            <button class="btn btn-secondary btn-block"><i class="fas fa-paper-plane mr-1"></i> Kirim Pesan</button>
          </form>

          {{-- TOLAK (hanya saat menunggu; tidak tampil jika sudah AKTIF) --}}
          @if(in_array($internship->status, ['waiting_confirmation','awaiting_letter']))
            <hr class="my-4">
            <h6 class="font-weight-bold mb-2 text-danger">Tolak Pengajuan</h6>
            <form method="POST" action="{{ route('admin.internships.reject', $internship) }}">
              @csrf
              <div class="form-group"><textarea name="reason" class="form-control" rows="2" placeholder="Alasan penolakan (opsional)"></textarea></div>
              <button class="btn btn-outline-danger btn-block"><i class="fas fa-times mr-1"></i> Tolak</button>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
