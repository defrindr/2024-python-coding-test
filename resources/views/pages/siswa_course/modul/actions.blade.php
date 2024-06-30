<div class="btn-group gap-2">
  <a href="{{ route('modul.download', $row->id) }}" class="btn btn-primary">
    Download
  </a>
  <a href="/python-course-siswa/{{ $row->id }}" class="btn btn-success">
    @if($sudahMengerjakan)
      @if($sudahMengerjakan->is_upload_tugas)
        Lihat Jawabn
      @else
        Lanjut Mengerjakan
      @endif
    @else
      Mulai Kerjakan
    @endif
  </a>
</div>