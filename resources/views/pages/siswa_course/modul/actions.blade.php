<div class="btn-group gap-2">
  <a href="{{ route('modul.download', $row->id) }}" class="btn btn-primary">
    Download
  </a>
  @if($sudahMengerjakan)
      @if($sudahMengerjakan->is_upload_tugas)
        <a href="/python-course-siswa/{{ $row->id }}" class="btn btn-success">
        Lihat Jawabn
        </a>
      @else
        <a href="/python-course-siswa/{{ $row->id }}" class="btn btn-info">
        Lanjut Mengerjakan
        </a>
      @endif
  @else
    <a href="/python-course-siswa/{{ $row->id }}" class="btn btn-warning">
    Mulai Kerjakan
    </a>
  @endif
</div>