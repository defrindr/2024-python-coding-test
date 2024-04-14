@props(['status'])

@if ($status)
  <div {{ $attributes->merge(['class' => 'fw-medium fs-4 text-success']) }}>
    {{ $status }}
  </div>
@endif