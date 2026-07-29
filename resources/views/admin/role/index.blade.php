@extends('admin.layouts.app')
@section('title', __('messages.roles'))
@section('page-title', __('messages.roles'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>{{ __('messages.roles') }}</h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> {{ __('messages.create') }}
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الدور</th>
                        <th>الصلاحيات</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td><strong>{{ $role->name }}</strong></td>
                        <td>
                            @foreach($role->permissions->take(3) as $perm)
                            <span class="badge bg-info">{{ $perm->name }}</span>
                            @endforeach
                            @if($role->permissions->count() > 3)
                            <span class="badge bg-secondary">+{{ $role->permissions->count() - 3 }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
