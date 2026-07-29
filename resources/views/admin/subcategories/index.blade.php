@extends('admin.layouts.master')

@section('title', 'الفئات الفرعية')
@section('page-title', 'إدارة الفئات الفرعية')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> فئة فرعية جديدة
    </a>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="bi bi-grid-3x3-gap"></i> قائمة الفئات الفرعية
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الفئة الرئيسية</th>
                        <th>الاسم</th>
                        <th>Slug</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subcategories as $sub)  {{-- ← $subcategories lowercase --}}
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>
                            <span class="badge bg-info">{{ $sub->category->name ?? '-' }}</span>
                        </td>
                        <td>{{ $sub->name }}</td>
                        <td><code>{{ $sub->slug }}</code></td>
                        <td>
                            @if($sub->is_active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-secondary">معطل</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="btn btn-sm btn-warning btn-action">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-action">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $subcategories->links() }}  {{-- ← $subcategories lowercase --}}
</div>
@endsection
