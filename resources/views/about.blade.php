@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<!-- Hero Section -->
<section class="about-hero text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-4 fw-bold text-gradient mb-3">Tentang Jeycookie</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Bakery artisan yang menghadirkan kelezatan autentik dengan bahan-bahan premium berkualitas tinggi.
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="mb-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1556217477-d325251ece38?w=600&h=400&fit=crop" 
                 alt="Our Bakery" 
                 class="img-fluid rounded-4 shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">Cerita Kami</h2>
            <p class="text-muted mb-4">
                Jeycookie lahir dari kecintaan kami terhadap dunia pastry dan baking. Bermula dari dapur rumahan pada tahun 2020, 
                kami memulai perjalanan dengan mimpi sederhana: membagikan kelezatan cookies dan kue buatan rumah kepada semua orang.
            </p>
            <p class="text-muted mb-4">
                Nama "Jeycookie" terinspirasi dari founder kami yang memiliki passion mendalam terhadap cookies. 
                Setiap produk yang kami buat adalah hasil dari eksperimen, riset, dan cinta yang tak terbatas untuk menciptakan 
                rasa yang sempurna.
            </p>
            <p class="text-muted">
                Kini, Jeycookie telah berkembang menjadi bakery yang dipercaya oleh ribuan pelanggan setia. 
                Kami tetap berkomitmen pada kualitas, menggunakan bahan-bahan premium, dan menjaga standar rasa yang konsisten.
            </p>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="mb-5 py-5 bg-light rounded-4">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Nilai-Nilai Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="value-icon mx-auto mb-3">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h5 class="fw-bold">Dibuat dengan Cinta</h5>
                    <p class="text-muted">
                        Setiap produk dibuat dengan sepenuh hati dan perhatian terhadap detail.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="value-icon mx-auto mb-3">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h5 class="fw-bold">Bahan Premium</h5>
                    <p class="text-muted">
                        Kami hanya menggunakan bahan-bahan berkualitas terbaik untuk produk kami.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="value-icon mx-auto mb-3">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <h5 class="fw-bold">Kualitas Terjaga</h5>
                    <p class="text-muted">
                        Standar kualitas yang konsisten untuk setiap produk yang kami hasilkan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="mb-5">
    <h2 class="fw-bold text-center mb-5">Tim Kami</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-lg-3">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1607631568010-a87245c0daf8?w=200&h=200&fit=crop&facepad=3" 
                     alt="Founder" 
                     class="team-image mb-3">
                <h5 class="fw-bold mb-1">Jey</h5>
                <p class="text-muted small">Founder & Head Baker</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1574966739987-65f38e93b58e?w=200&h=200&fit=crop&facepad=3" 
                     alt="Pastry Chef" 
                     class="team-image mb-3">
                <h5 class="fw-bold mb-1">Sarah</h5>
                <p class="text-muted small">Pastry Chef</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="team-card text-center">
                <img src="https://images.unsplash.com/photo-1581299894007-aaa50297cf16?w=200&h=200&fit=crop&facepad=3" 
                     alt="Creative" 
                     class="team-image mb-3">
                <h5 class="fw-bold mb-1">Maya</h5>
                <p class="text-muted small">Creative Director</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info -->
<section class="mb-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">
                        <i class="fa-solid fa-location-dot text-pink me-2"></i> Lokasi Kami
                    </h4>
                    <p class="text-muted mb-3">
                        <strong>Jeycookie Bakery</strong><br>
                        Jl. Bakery No. 123<br>
                        Kelurahan Manis, Kecamatan Lezat<br>
                        Jakarta Selatan 12345
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fa-solid fa-clock me-2"></i>
                        Buka setiap hari: 08:00 - 20:00 WIB
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">
                        <i class="fa-solid fa-phone text-pink me-2"></i> Hubungi Kami
                    </h4>
                    <p class="text-muted mb-2">
                        <i class="fa-solid fa-phone me-2"></i>
                        +62 812-3456-7890
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fa-brands fa-whatsapp me-2"></i>
                        +62 812-3456-7890 (WhatsApp)
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fa-solid fa-envelope me-2"></i>
                        hello@jeycookie.com
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fa-brands fa-instagram me-2"></i>
                        @jeycookie.id
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="text-center py-5 mb-4">
    <h3 class="fw-bold mb-3">Siap untuk Mencoba?</h3>
    <p class="text-muted mb-4">Jelajahi koleksi produk kami dan temukan favorit Anda!</p>
    <a href="{{ route('products.index') }}" class="btn btn-pink btn-lg">
        <i class="fa-solid fa-shopping-bag me-2"></i> Lihat Produk
    </a>
</section>

@endsection

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, var(--pink-50), var(--peach-50));
        border-radius: var(--radius-xl);
        margin-top: -1rem;
    }
    
    .value-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
    }
    
    .team-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--pink-100);
    }
    
    .team-card {
        padding: 1.5rem;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        transition: transform 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .text-pink {
        color: var(--pink-600);
    }
</style>
@endpush