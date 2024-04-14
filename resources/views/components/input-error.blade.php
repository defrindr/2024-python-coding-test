@props(['messages'])

@if ($messages)
  <div {{ $attributes->merge(['class' => 'invalid-feedback']) }}>
    @foreach ((array) $messages as $message)
      <p>{{ $message }}</p>
    @endforeach
  </div>
@endif