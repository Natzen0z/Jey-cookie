@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<h1 class="fw-bold text-gradient mb-4">
    <i class="fa-solid fa-credit-card me-2"></i> Checkout
</h1>

<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    
    <div class="row g-4">
        <!-- Customer Details Form -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-user me-2"></i> Informasi Pengiriman
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', $user->name) }}"
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone', $user->phone) }}"
                                   placeholder="08xxxxxxxxxx"
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', $user->email) }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="customer_address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                      id="customer_address" 
                                      name="customer_address" 
                                      rows="3"
                                      placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                      required>{{ old('customer_address', $user->address) }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2"
                                      placeholder="Catatan khusus untuk pesanan Anda">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-box me-2"></i> Detail Pesanan
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="rounded me-2"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <span class="fw-semibold">{{ $item['name'] }}</span>
                                                <br>
                                                <small class="text-muted">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }} / item
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item['quantity'] }}</td>
                                    <td class="text-end align-middle fw-semibold">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="checkout-summary">
                <h5 class="fw-bold mb-4">
                    <i class="fa-solid fa-receipt me-2"></i> Ringkasan Pembayaran
                </h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    @if($totals['delivery_fee'] == 0)
                        <span class="text-success fw-semibold">GRATIS</span>
                    @else
                        <span>Rp {{ number_format($totals['delivery_fee'], 0, ',', '.') }}</span>
                    @endif
                </div>
                
                @if($totals['discount'] > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Diskon</span>
                        <span class="text-success">- Rp {{ number_format($totals['discount'], 0, ',', '.') }}</span>
                    </div>
                @endif
                
                <hr>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-4 text-pink">Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <div class="payment-method-card p-3 border rounded-3 bg-light">
                        <div class="d-flex align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/320px-QRIS_logo.svg.png" 
                                 alt="QRIS" 
                                 style="height: 40px;" 
                                 class="me-3">
                            <div>
                                <strong>QRIS</strong>
                                <br>
                                <small class="text-muted">Scan QR dengan aplikasi e-wallet atau m-banking</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-pink btn-lg w-100">
                    <i class="fa-solid fa-lock me-2"></i> Buat Pesanan
                </button>
                
                <p class="text-center text-muted small mt-3">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    Pembayaran aman & terenkripsi
                </p>
            </div>
        </div>
    </div>
</form>

@endsection

@push('styles')
<style>
    .text-pink {
        color: var(--pink-600);
    }
    
    .payment-method-card {
        transition: all 0.3s ease;
    }
    
    .payment-method-card:hover {
        border-color: var(--pink-400) !important;
    }
</style>
@endpush
