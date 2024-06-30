@extends('layouts.master')
@section('main')
<div class="title d-flex align-items-center">
  <a href="{{ route('guru.course.index') }}" class="text-decoration-none">
    <i class="ti-arrow-circle-left"></i>
  </a>
  <span class="ms-2">Course {{ $sekolahCourse->course->name }} - {{ $sekolahCourse->sekolah->nama }}</span>
</div>
<div class="content-wrapper">
  <div class="row same-height">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-column gap-3 table-responsive">
            <div class="form-group">
              <span class="fw-bold">Guru</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->guru->user->name }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Course</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->course->name }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Deskripsi</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->course->description }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Pertemuan</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->pertemuan }}</span>
              </div>
            </div>

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th width="24px">No</th>
                  <th>Nama Modul</th>
                  <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4>List Pengerjaan Siswa</h4>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered data-pengerjaan-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Course</th>
                <th>Modul</th>
                <th>Waktu Pengerjaan</th>
                <th>Nilai</th>
                <th width="280px">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal  m-8" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pengerjaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include('pages.guru_course.modul.detail')
        <hr>
        <form id="form-nilai" class="form">
          @csrf
          <input type="hidden" name="id" id="penilaian_id">
          <div class="form-group mb-3">
            <label for="">Nilai</label>
            <input type="number" max="100" name="nilai" class="form-control" id="nilai">
          </div>
          <div class="form-group">
            <button class="btn btn-primary">Simpan Nilai</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function () {
    var myModal = new bootstrap.Modal(document.querySelector('.modal'), {
      keyboard: false
    })
    const table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('guru.course.show', $sekolahCourse->id) }}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
      {
        data: 'nama',
        name: 'nama'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }
      ]
    });
    const tablePengerjaan = $('.data-pengerjaan-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('guru.course.list-jawaban', $sekolahCourse) }}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      }, {
        data: 'namaSiswa',
        name: 'namaSiswa'
      }, {
        data: 'kelasSiswa',
        name: 'kelasSiswa'
      }, {
        data: 'courseSiswa',
        name: 'courseSiswa'
      }, {
        data: 'modulSiswa',
        name: 'modulSiswa'
      }, {
        data: 'waktuPengerjaanSiswa',
        name: 'waktuPengerjaanSiswa'
      }, {
        data: 'nilaiSiswa',
        name: 'nilaiSiswa'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }
      ],
    });

    $('#form-nilai').on('submit', async (evt) => {
      evt.preventDefault();

      let response = await fetch("{{route('guru.course.penilaian.beri-nilai')}}", {
        method: "POST",
        headers: {
          'Accept': 'application/json'
        },
        body: new FormData(evt.target)
      });
      let json = await response.json()

      alert(json.message)
      if (response.ok) {
        tablePengerjaan.ajax.reload()
        myModal.hide()
      }
    })

    $('.data-pengerjaan-table tbody').on('click', '.btn-show', function () {
      var currentRowData = $(this).data('id');
      fetch("{{ route('guru.course.penilaian.detail', ['penilaian' => 1337]) }}".replace('1337', currentRowData))
        .then(res => res.json())
        .then(json => {
          myModal.show();
          $('#penilaian_id').val(json.data.id)
          $('#nilai').val(json.data.point ?? 0)
          editor.setValue(json.data.source, 1)
          initialModul(json.modul);
          initialOutput(JSON.parse(json.data.raw_result));
        })
    });
  });
</script>
@endsection