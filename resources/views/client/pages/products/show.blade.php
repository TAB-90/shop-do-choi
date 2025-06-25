@extends('client.layouts.app')
@section('title', $product->title . ' - Shop Đồ Chơi')
@section('description', Str::limit($product->description, 160))
@section('keywords', 'đồ chơi, ' . $product->title . ', ' . $product->category->name)

@section('content')
    <!-- Hero Product Section -->
    <div class="product-hero">
        <div class="hero-background">
            <div class="hero-particles"></div>
        </div>
        <div class="container">
            <!-- Breadcrumb Navigation -->
            <nav class="breadcrumb-nav" data-aos="fade-down">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ $product->title }}</li>
                </ol>
            </nav>

            <!-- Product Main Content -->
            <div class="product-main-content">
                <div class="product-gallery-section" data-aos="fade-right" data-aos-delay="200">
                    <div class="main-image-container">
                        <div class="product-badges">
                            @if ($product->is_bestseller)
                                <div class="product-badge bestseller">
                                    <i class="fas fa-star"></i>
                                    <span>Bestseller</span>
                                </div>
                            @endif
                            @if ($product->created_at->diffInDays() < 30)
                                <div class="product-badge new">
                                    <i class="fas fa-sparkles"></i>
                                    <span>Mới</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="main-image-wrapper">
                            <img src="{{ Storage::url($product->cover_image) }}" 
                                 alt="{{ $product->title }}" 
                                 class="main-product-image"
                                 id="mainProductImage">
                            <div class="image-zoom-overlay">
                                <i class="fas fa-search-plus"></i>
                                <span>Phóng to</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-info-section" data-aos="fade-left" data-aos-delay="400">
                    <div class="product-header">
                        <div class="category-tag">
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">
                                <i class="fas fa-tag"></i>
                                {{ $product->category->name }}
                            </a>
                        </div>
                        <h1 class="product-title">{{ $product->title }}</h1>
                        
                        <div class="product-meta">
                            <div class="stock-status {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }}"></i>
                                <span>{{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                @if ($product->stock > 0)
                                    <span class="stock-count">({{ $product->stock }} sản phẩm)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pricing-section">
                        <div class="price-display">
                            <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="product-actions">
                        <div class="quantity-selector">
                            <label for="quantity">Số lượng:</label>
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn minus" onclick="updateQuantity(-1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                                <button type="button" class="qty-btn plus" onclick="updateQuantity(1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            @auth
                                <button class="btn-add-cart" onclick="addToCart({{ $product->id }})" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>{{ $product->stock == 0 ? 'Hết hàng' : 'Thêm vào giỏ' }}</span>
                                </button>
                                
                                <button class="btn-wishlist {{ isset($product->is_favorited) && $product->is_favorited ? 'active' : '' }}" 
                                        onclick="toggleWishlist({{ $product->id }})">
                                    <i class="fas fa-heart"></i>
                                    <span>Yêu thích</span>
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-add-cart">
                                    <i class="fas fa-user"></i>
                                    <span>Đăng nhập để mua</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="product-features">
                        <div class="feature-item">
                            <i class="fas fa-truck"></i>
                            <div class="feature-content">
                                <h4>Giao hàng miễn phí</h4>
                                <p>Đơn hàng từ 500.000đ</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <div class="feature-content">
                                <h4>Bảo hành chính hãng</h4>
                                <p>Cam kết chất lượng</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-undo"></i>
                            <div class="feature-content">
                                <h4>Đổi trả dễ dàng</h4>
                                <p>Trong vòng 7 ngày</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Section -->
    <section class="product-details-section">
        <div class="container">
            <div class="details-tabs" data-aos="fade-up">
                <div class="tab-navigation">
                    <button class="tab-btn active" data-tab="description">
                        <i class="fas fa-align-left"></i>
                        Mô tả sản phẩm
                    </button>
                    <button class="tab-btn" data-tab="specifications">
                        <i class="fas fa-list-ul"></i>
                        Thông số kỹ thuật
                    </button>
                    <button class="tab-btn" data-tab="reviews">
                        <i class="fas fa-star"></i>
                        Đánh giá
                    </button>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="description">
                        <div class="description-content">
                            <h3>Mô tả chi tiết</h3>
                            <div class="description-text">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="specifications">
                        <div class="specifications-content">
                            <h3>Thông số kỹ thuật</h3>
                            <div class="spec-table">
                                <div class="spec-row">
                                    <span class="spec-label">Danh mục:</span>
                                    <span class="spec-value">{{ $product->category->name }}</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Tình trạng:</span>
                                    <span class="spec-value">{{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Số lượng kho:</span>
                                    <span class="spec-value">{{ $product->stock }} sản phẩm</span>
                                </div>
                                <div class="spec-row">
                                    <span class="spec-label">Ngày phát hành:</span>
                                    <span class="spec-value">{{ $product->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="reviews">
                        <div class="reviews-content">
                            <h3>Đánh giá từ khách hàng</h3>
                            <div class="reviews-summary">
                                <div class="rating-overview">
                                    <div class="average-rating">
                                        <span class="rating-number">4.8</span>
                                        <div class="rating-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="total-reviews">(124 đánh giá)</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="review-placeholder">
                                <i class="fas fa-comments"></i>
                                <h4>Chức năng đánh giá sẽ sớm được bổ sung</h4>
                                <p>Chúng tôi đang phát triển tính năng này để mang đến trải nghiệm tốt nhất cho bạn.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    @if ($relatedProducts->count() > 0)
        <section class="related-products-section">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="section-title">
                        <span class="title-text">Sản phẩm liên quan</span>
                        <div class="title-decoration"></div>
                    </h2>
                    <p class="section-description">Những sản phẩm tương tự bạn có thể quan tâm</p>
                </div>

                <div class="related-products-grid" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($relatedProducts as $relatedProduct)
                        @include('components.item-product', ['product' => $relatedProduct, 'containerClass' => 'related-item'])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Image Modal -->
    <div class="image-modal" id="imageModal">
        <div class="modal-overlay" onclick="closeImageModal()"></div>
        <div class="modal-content">
            <button class="modal-close" onclick="closeImageModal()">
                <i class="fas fa-times"></i>
            </button>
            <img src="" alt="" id="modalImage">
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Product Hero Section */
        .product-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 0 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .hero-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, rgba(255,255,255,0.3), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 90px 40px, rgba(255,255,255,0.4), transparent);
            background-repeat: repeat;
            background-size: 120px 120px;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-120px) rotate(360deg); }
        }

        /* Breadcrumb */
        .breadcrumb-nav {
            position: relative;
            z-index: 2;
            margin-bottom: 2rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .breadcrumb-item:not(:last-child)::after {
            content: '›';
            color: rgba(255, 255, 255, 0.6);
            margin: 0 0.5rem;
            font-size: 1.2rem;
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }

        /* Product Main Content */
        .product-main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            position: relative;
            z-index: 2;
        }

        /* Product Gallery */
        .product-gallery-section {
            position: relative;
        }

        .main-image-container {
            position: relative;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .product-badges {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 3;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .product-badge.bestseller {
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
            color: white;
        }

        .product-badge.new {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .main-image-wrapper {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            cursor: zoom-in;
        }

        .main-product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .main-image-wrapper:hover .main-product-image {
            transform: scale(1.1);
        }

        .image-zoom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .main-image-wrapper:hover .image-zoom-overlay {
            opacity: 1;
        }

        .image-zoom-overlay i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        /* Product Info */
        .product-info-section {
            color: white;
        }

        .product-header {
            margin-bottom: 2rem;
        }

        .category-tag {
            margin-bottom: 1rem;
        }

        .category-tag a {
            color: #ffd89b;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .category-tag a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
            line-height: 1.2;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stock-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .stock-status.in-stock {
            background: rgba(72, 187, 120, 0.2);
            color: #9ae6b4;
        }

        .stock-status.out-of-stock {
            background: rgba(245, 101, 101, 0.2);
            color: #feb2b2;
        }

        .stock-count {
            opacity: 0.8;
            font-weight: 400;
        }

        /* Pricing */
        .pricing-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .current-price {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffd89b, #19547b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Product Actions */
        .product-actions {
            margin-bottom: 2rem;
        }

        .quantity-selector {
            margin-bottom: 1.5rem;
        }

        .quantity-selector label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: fit-content;
        }

        .qty-btn {
            width: 50px;
            height: 50px;
            border: none;
            background: transparent;
            color: white;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .qty-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        #quantity {
            width: 80px;
            height: 50px;
            border: none;
            background: transparent;
            color: white;
            text-align: center;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-add-cart,
        .btn-wishlist {
            flex: 1;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .btn-add-cart {
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .btn-add-cart:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.6);
        }

        .btn-add-cart:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-wishlist {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-wishlist:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .btn-wishlist.active {
            background: rgba(255, 107, 107, 0.2);
            border-color: #ff6b6b;
            color: #ff6b6b;
        }

        /* Product Features */
        .product-features {
            display: grid;
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .feature-item i {
            font-size: 1.5rem;
            color: #ffd89b;
        }

        .feature-content h4 {
            margin: 0 0 0.25rem 0;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .feature-content p {
            margin: 0;
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* Product Details Section */
        .product-details-section {
            padding: 4rem 0;
            background: white;
        }

        .details-tabs {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .tab-navigation {
            display: flex;
            background: #f7fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .tab-btn {
            flex: 1;
            padding: 1.5rem 2rem;
            border: none;
            background: transparent;
            color: #4a5568;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab-btn.active {
            color: #667eea;
            background: white;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .tab-btn:hover:not(.active) {
            background: rgba(102, 126, 234, 0.05);
            color: #667eea;
        }

        .tab-content {
            padding: 2rem;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .description-content h3,
        .specifications-content h3,
        .reviews-content h3 {
            color: #2d3748;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .description-text {
            color: #4a5568;
            line-height: 1.8;
            font-size: 1rem;
        }

        .spec-table {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .spec-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-row:nth-child(even) {
            background: #f7fafc;
        }

        .spec-label {
            font-weight: 600;
            color: #2d3748;
        }

        .spec-value {
            color: #4a5568;
        }

        .reviews-summary {
            margin-bottom: 2rem;
        }

        .rating-overview {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .average-rating {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .rating-number {
            font-size: 2rem;
            font-weight: 800;
            color: #667eea;
        }

        .rating-stars {
            color: #ffd700;
            font-size: 1.2rem;
        }

        .total-reviews {
            color: #718096;
        }

        .review-placeholder {
            text-align: center;
            padding: 3rem;
            color: #718096;
        }

        .review-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #cbd5e0;
        }

        .review-placeholder h4 {
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        /* Related Products */
        .related-products-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            position: relative;
            margin-bottom: 1rem;
        }

        .title-text {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
        }

        .title-decoration {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .section-description {
            color: #718096;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        /* Image Modal */
        .image-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .image-modal.active {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            z-index: 2;
        }

        .modal-close {
            position: absolute;
            top: -50px;
            right: 0;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.2s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        #modalImage {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .product-main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .product-title {
                font-size: 2rem;
            }

            .tab-navigation {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .product-hero {
                padding: 1rem 0 2rem;
            }

            .breadcrumb {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .current-price {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .related-products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .tab-btn {
                padding: 1rem;
                font-size: 0.875rem;
            }

            .tab-content {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .related-products-grid {
                grid-template-columns: 1fr;
            }

            .quantity-controls {
                width: 100%;
            }

            #quantity {
                flex: 1;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-out-cubic',
                    once: true
                });
            }

            // Tab functionality
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;
                    
                    // Remove active class from all tabs and panes
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding pane
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });

            // Image zoom modal
            const mainImage = document.getElementById('mainProductImage');
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            mainImage.addEventListener('click', function() {
                modalImage.src = this.src;
                modalImage.alt = this.alt;
                imageModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            // Parallax effect for hero section
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelector('.hero-particles');
                if (parallax) {
                    const speed = scrolled * 0.5;
                    parallax.style.transform = `translateY(${speed}px)`;
                }
            });

            // Smooth scroll to details section
            const addToCartBtn = document.querySelector('.btn-add-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    // Add ripple effect
                    createRipple(this, event);
                });
            }

            // Create ripple effect
            function createRipple(button, e) {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }

            // Add ripple CSS
            const rippleCSS = `
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: ripple-animation 0.6s linear;
                    pointer-events: none;
                }

                @keyframes ripple-animation {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;

            const style = document.createElement('style');
            style.textContent = rippleCSS;
            document.head.appendChild(style);
        });

        // Quantity update function
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.max);
            const newValue = currentValue + change;
            
            if (newValue >= 1 && newValue <= maxStock) {
                quantityInput.value = newValue;
                
                // Add visual feedback
                quantityInput.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    quantityInput.style.transform = 'scale(1)';
                }, 150);
            }
        }

        // Add to cart function
        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            const button = document.querySelector('.btn-add-cart');
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Đang thêm...</span>';
            button.disabled = true;
            
            fetch(`/user/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: parseInt(quantity) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success animation
                    button.innerHTML = '<i class="fas fa-check"></i> <span>Đã thêm!</span>';
                    button.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
                    
                    // Update cart count if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                        cartCount.style.animation = 'bounce 0.5s ease';
                    }
                    
                    showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                    
                    // Reset button after delay
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.style.background = '';
                        button.disabled = false;
                    }, 2000);
                } else {
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalContent;
                button.disabled = false;
                showToast('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
            });
        }

        // Toggle wishlist function
        function toggleWishlist(productId) {
            const button = document.querySelector('.btn-wishlist');
            const icon = button.querySelector('i');
            
            fetch(`/user/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.added) {
                        button.classList.add('active');
                        icon.style.animation = 'heartBeat 0.6s ease-in-out';
                        showToast('Đã thêm vào danh sách yêu thích!', 'success');
                    } else {
                        button.classList.remove('active');
                        showToast('Đã xóa khỏi danh sách yêu thích!', 'success');
                    }
                    
                    setTimeout(() => {
                        icon.style.animation = '';
                    }, 600);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra!', 'error');
            });
        }

        // Close image modal
        function closeImageModal() {
            const imageModal = document.getElementById('imageModal');
            imageModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Heart beat animation
        const heartBeatCSS = `
            @keyframes heartBeat {
                0%, 50%, 100% { transform: scale(1); }
                25%, 75% { transform: scale(1.3); }
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
        `;

        const heartStyle = document.createElement('style');
        heartStyle.textContent = heartBeatCSS;
        document.head.appendChild(heartStyle);
    </script>
@endpush