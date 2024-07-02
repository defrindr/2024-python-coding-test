@extends('layouts.master')
@section('main')
<div class="title d-flex align-items-center">
    <a href="{{ route('guru.course.index') }}" class="text-decoration-none">
        <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Course</span>
</div>
<div class="content-wrapper">
    <form action="{{ route('guru.modul.simpan-nilai', $modul->id) }}" method="post">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Form Atur Parameter Waktu</h4>
                    </div>
                    <div class="card-body">

                        @csrf
                        @if(isset($tipeWaktu) && count($tipeWaktu) > 0)
                            @foreach ($tipeWaktu as $i => $waktu)
                                <div class="row">
                                    <input name="waktu_hidden[{{$i}}]" type="hidden" value="{{ $waktu->id }}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Minimal Waktu {{$i + 1}} (detik)</label>
                                            <input name="waktu_min[{{$i}}]" type="number" class="form-control"
                                                value="{{$waktu->min_value}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nilai {{$i + 1}} </label>
                                            <input name="waktu_point[{{$i}}]" type="number" class="form-control"
                                                value="{{$waktu->point}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 5; $i++)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Minimal Waktu {{$i + 1}} (detik)</label>
                                            <input name="waktu_min[{{$i}}]" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nilai {{$i + 1}} </label>
                                            <input name="waktu_point[{{$i}}]" type="number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Form Atur Parameter Attempt</h4>
                    </div>
                    <div class="card-body">

                        @csrf
                        @if(isset($tipeAttempt) && count($tipeAttempt) > 0)
                            @foreach ($tipeAttempt as $i => $attempt)
                                <div class="row">
                                    <input name="attempt_hidden[{{$i}}]" type="hidden" value="{{ $attempt->id }}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Minimal Attempt {{$i + 1}}</label>
                                            <input name="attempt_min[{{$i}}]" type="number" class="form-control"
                                                value="{{$attempt->min_value}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nilai {{$i + 1}} </label>
                                            <input name="attempt_point[{{$i}}]" type="number" class="form-control"
                                                value="{{$attempt->point}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 5; $i++)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Minimal Attempt {{$i + 1}}</label>
                                            <input name="attempt_min[{{$i}}]" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nilai {{$i + 1}} </label>
                                            <input name="attempt_point[{{$i}}]" type="number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection