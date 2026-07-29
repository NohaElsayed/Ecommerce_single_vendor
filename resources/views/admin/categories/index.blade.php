@extends('admin.layouts.master')

@section('title', 'الفئات')
@section('page-title', 'إدارة الفئات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> فئة جديدة
    </a>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="bi bi-grid"></i> قائمة الفئات
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>الفئات الفرعية</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" width="50" height="50" class="rounded" style="object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @foreach($category->subCategories->take(3) as $sub)
                                <span class="badge bg-secondary me-1">{{ $sub->name }}</span>
                            @endforeach
                            @if($category->subCategories->count() > 3)
                                <span class="badge bg-light text-dark">+{{ $category->subCategories->count() - 3 }}</span>
                            @endif
                        </td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-secondary">معطل</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning btn-action">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟')">
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
    {{-- {{ $categories->links() }} --}}
</div>
@endsection
