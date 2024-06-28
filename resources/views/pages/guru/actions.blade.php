<div class="btn-group gap-2">
  @if (Auth::user()->role == 'super_admin')
    <a href="{{ route('guru.show', $row->user->id) }}" class="btn btn-info btn-sm">Detail</a>
    <a href="{{ route('guru.edit', $row->user->id) }}" class="btn btn-primary btn-sm">Edit</a>
    <form action="{{ route('guru.destroy', $row->user->id) }}" method="POST" class="d-inline">
      @csrf
      @method('DELETE')
      <button type="submit" class="show_confirm btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
        Delete
      </button>
    </form>
  @else
    <a href="{{ route('admin.guru.edit', $row->user->id) }}" class="btn btn-primary btn-sm">Edit</a>
    <form action="{{ route('admin.guru.destroy', $row->user->id) }}" method="POST" class="d-inline">
      @csrf
      @method('DELETE')
      <button type="submit" class="show_confirm btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
        Delete
      </button>
    </form>
  @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/alert-delete.js') }}"></script>
