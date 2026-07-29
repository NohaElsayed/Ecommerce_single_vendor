@extends('frontend.layouts.app')

@section('title', __('messages.order_number') . ' #' . $order->order_number)

@section('content')
<div class="breadcrumb-wrapper">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.my') }}">{{ __('messages.my_orders') }}</a></li>
                <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Order Header -->
                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h4 class="fw-bold mb-1">{{ __('messages.order_number') }}: <span class="text-primary">#{{ $order->order_number }}</span></h4>
                            <p class="text-muted mb-0">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} bg-opacity-10 text-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} px-3 py-2">
                                {{ __('messages.status_' . $order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-box-open me-2 text-primary"></i>{{ __('messages.products') }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.quantity') }}</th>
                                    <th class="text-end pe-4">{{ __('messages.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && $item->product->featured_image)
                                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" alt="">
                                                @else
                                                    <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $item->product_name }}</h6>
                                                    @if($item->product)
                                                        <small class="text-muted">{{ $item->product->sku ?? '' }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end pe-4 fw-bold">${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card p-4 h-100">
                            <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ __('messages.shipping_address') }}</h6>
                            <p class="text-muted mb-0">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-4 h-100">
                            <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-primary"></i>{{ __('messages.contact_info') }}</h6>
                            <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                            <p class="mb-1 text-muted"><i class="fas fa-envelope me-2"></i>{{ $order->customer_email }}</p>
                            <p class="mb-0 text-muted"><i class="fas fa-phone me-2"></i>{{ $order->customer_phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="card p-4 mt-4">
                    <h5 class="fw-bold mb-4">{{ __('messages.order_summary') }}</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('messages.subtotal') }}</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('messages.shipping') }}</span>
                        <span class="text-success">{{ __('messages.free') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('messages.tax') }}</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('messages.discount') }}</span>
                            <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">{{ __('messages.total') }}</span>
                        <span class="fw-bold fs-4 text-primary">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('orders.my') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} me-2"></i>{{ __('messages.my_orders') }}
                    </a>
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form action="#" method="POST" onsubmit="return confirm('{{ __('messages.confirm_cancel') }}')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>{{ __('messages.cancel_order') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
