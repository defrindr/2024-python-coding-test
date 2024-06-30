@extends('layouts.master')
@section('main')
<div class="title">Dashboard</div>
<div class="content-wrapper">
  <div class="row same-height">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body d-flex flex-column gap-3">
          <div class="d-flex gap-3">
            <h6 class="my-auto">Nama</h6>
            <span class="my-auto">
              {{ $user->name }}
            </span>
          </div>
          <div class="d-flex gap-3">
            <h6 class="my-auto">Email</h6>
            <span class="my-auto">
              {{ $user->email }}
            </span>
          </div>
          <div class="d-flex gap-3">
            <h6 class="my-auto">Role</h6>
            <span class="my-auto text-uppercase">
              {{ $user->role }}
            </span>
          </div>
          <hr class="my-0">
          <div class="d-flex gap-3">
            <h6 class="my-auto">Asal Sekolah</h6>
            <span class="my-auto">
              {{ $dataUser->sekolah->nama }}
            </span>
          </div>
          <div class="d-flex gap-3">
            <h6 class="my-auto">NIP</h6>
            <span class="my-auto">
              {{ $dataUser->nip }}
            </span>
          </div>
          <div class="d-flex gap-3">
            <h6 class="my-auto">Manual Book</h6>
            @foreach ($manualBooks as $item)
        <a href="{{ route('manualbook.download', $item->id) }}" class="btn btn-link my-auto">Unduh</a>
      @endforeach
            @if ($manualBooks->isEmpty())
        <span class="my-auto">Tidak ada manual book tersedia</span>
      @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-primary">
        <div class="card-body">
          <canvas id="chart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  const ctx = document.getElementById('chart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: {!! json_encode($labels ?? []) !!},

      datasets: [{
        data: {!! json_encode($data ?? []) !!},
      }],

    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endsection