@extends('client.layouts.app')
@section('title', 'Danh sách sản phẩm - Shop Đồ Chơi')
@section('description', 'Khám phá bộ sưu tập sản phẩm đa dạng của chúng tôi với nhiều thể loại, tác giả và chủ đề khác
    nhau.')
@section('keywords', 'sản phẩm, thể loại sản phẩm, sản phẩm mới, sản phẩm bán chạy, mua sản phẩm trực tuyến')

@section('content')
    <!-- Modern Header -->
    <div class="modern-page-header">
        <div class="header-background">
            <div class="header-pattern"></div>
        </div>
        <div class="container">
            <div class="header-content">
                <div class="breadcrumb-nav">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                    <span>Trang chủ</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <h1 class="page-title">
                    <span class="title-text">Danh sách sản phẩm</span>
                    <div class="title-decoration"></div>
                </h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="products-main">
        <div class="container">
            <div class="products-layout">
                <!-- Enhanced Sidebar -->
                <aside class="products-sidebar">
                    <div class="sidebar-card">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">
                                <i class="fas fa-filter"></i>
                                Bộ lọc
                            </h3>
                        </div>

                        <div class="filter-section">
                            <h4 class="filter-heading">Danh mục</h4>
                            <ul class="filter-list">
                                <li
                                    class="filter-item {{ !request('category') && !request('is_bestseller') && !request('newest') ? 'active' : '' }}">
                                    <a href="{{ route('products.index') }}" class="filter-link">
                                        <span class="filter-text">Tất cả sản phẩm</span>
                                        <span class="filter-count">{{ \App\Models\Product::count() }}</span>
                                    </a>
                                </li>

                                @foreach ($categories as $category)
                                    <li class="filter-item {{ request('category') == $category->slug ? 'active' : '' }}">
                                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                            class="filter-link">
                                            <span class="filter-text">{{ $category->name }}</span>
                                            <span class="filter-count">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-section">
                            <h4 class="filter-heading">Loại sản phẩm</h4>
                            <ul class="filter-list">
                                <li class="filter-item {{ request('is_bestseller') ? 'active' : '' }}">
                                    <a href="{{ route('products.index', ['is_bestseller' => 1]) }}" class="filter-link">
                                        <span class="filter-text">
                                            <i class="fas fa-star filter-icon"></i>
                                            Sản phẩm bán chạy
                                        </span>
                                        <span
                                            class="filter-count">{{ \App\Models\Product::where('is_bestseller', 1)->count() }}</span>
                                    </a>
                                </li>
                                <li class="filter-item {{ request('newest') ? 'active' : '' }}">
                                    <a href="{{ route('products.index', ['newest' => 1]) }}" class="filter-link">
                                        <span class="filter-text">
                                            <i class="fas fa-clock filter-icon"></i>
                                            Sản phẩm mới
                                        </span>
                                        <span
                                            class="filter-count">{{ \App\Models\Product::latest()->take(20)->count() }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="products-content">
                    <!-- Search and Controls -->
                    <div class="products-controls">
                        <div class="search-section">
                            <form action="{{ route('products.index') }}" method="GET" class="search-form">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('is_bestseller'))
                                    <input type="hidden" name="is_bestseller" value="{{ request('is_bestseller') }}">
                                @endif
                                @if (request('newest'))
                                    <input type="hidden" name="newest" value="{{ request('newest') }}">
                                @endif

                                <div class="search-input-group">
                                    <div class="search-icon">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <input type="text" name="search" placeholder="Tìm kiếm đồ chơi..."
                                        value="{{ request('search') }}" class="search-input">
                                    <button type="submit" class="search-button">
                                        <span>Tìm kiếm</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="results-info">
                            <div class="results-count">
                                <span class="count-text">Tìm thấy</span>
                                <span class="count-number">{{ $products->total() }}</span>
                                <span class="count-text">kết quả</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if (request('category') || request('search') || request('is_bestseller') || request('newest'))
                        <div class="active-filters">
                            <div class="filters-header">
                                <span class="filters-label">Bộ lọc đang áp dụng:</span>
                            </div>
                            <div class="filters-list">
                                @if (request('category'))
                                    @php $categoryName = \App\Models\Category::where('slug', request('category'))->first()->name ?? ''; @endphp
                                    <div class="filter-tag">
                                        <span class="tag-label">Danh mục:</span>
                                        <span class="tag-value">{{ $categoryName }}</span>
                                        <a href="{{ route('products.index', request()->except('category')) }}"
                                            class="tag-remove">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endif

                                @if (request('is_bestseller'))
                                    <div class="filter-tag">
                                        <span class="tag-label">Loại:</span>
                                        <span class="tag-value">Sản phẩm bán chạy</span>
                                        <a href="{{ route('products.index', request()->except('is_bestseller')) }}"
                                            class="tag-remove">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endif

                                @if (request('newest'))
                                    <div class="filter-tag">
                                        <span class="tag-label">Loại:</span>
                                        <span class="tag-value">Sản phẩm mới</span>
                                        <a href="{{ route('products.index', request()->except('newest')) }}"
                                            class="tag-remove">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endif

                                @if (request('search'))
                                    <div class="filter-tag">
                                        <span class="tag-label">Tìm kiếm:</span>
                                        <span class="tag-value">"{{ request('search') }}"</span>
                                        <a href="{{ route('products.index', request()->except('search')) }}"
                                            class="tag-remove">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Products Grid -->
                    <div class="products-grid-section">
                        @if ($products->isEmpty())
                            <div class="no-results-state">
                                <div class="no-results-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3 class="no-results-title">Không tìm thấy kết quả</h3>
                                <p class="no-results-description">
                                    Rất tiếc, chúng tôi không thể tìm thấy bất kỳ sản phẩm nào phù hợp với tiêu chí tìm kiếm
                                    của bạn.
                                </p>
                                <a href="{{ route('products.index') }}" class="no-results-action">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Xem tất cả sản phẩm</span>
                                </a>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up"
                                        data-aos-delay="{{ $loop->iteration * 50 }}">
                                        @include('components.item-product', ['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Enhanced Pagination -->
                    @if ($products->hasPages())
                        <div class="pagination-section">
                            {{ $products->appends(request()->query())->links('components.paginate') }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Modern Page Header */
        .modern-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem 0 3rem;
            position: relative;
            overflow: hidden;
        }

        .header-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .breadcrumb-nav {
            margin-bottom: 1.5rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            align-items: center;
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
            transition: color 0.2s ease;
        }

        .breadcrumb-item a:hover {
            color: white;
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.6);
            margin-left: 1rem;
            position: relative;
        }

        .breadcrumb-item.active::before {
            content: '/';
            position: absolute;
            left: -0.75rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .page-title {
            color: white;
            margin: 0;
            position: relative;
        }

        .title-text {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
        }

        .title-decoration {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #ffd89b, #19547b);
            margin-top: 1rem;
            border-radius: 2px;
        }

        /* Main Layout */
        .products-main {
            padding: 3rem 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 80vh;
        }

        .products-layout {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 3rem;
            align-items: start;
        }

        /* Enhanced Sidebar */
        .products-sidebar {
            position: sticky;
            top: 2rem;
        }

        .sidebar-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 1.5rem;
        }

        .sidebar-title {
            color: white;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .filter-section:last-child {
            border-bottom: none;
        }

        .filter-heading {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .filter-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .filter-item {
            margin-bottom: 0.5rem;
        }

        .filter-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            color: #4a5568;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .filter-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .filter-link:hover,
        .filter-item.active .filter-link {
            color: white;
            transform: translateX(5px);
        }

        .filter-link:hover::before,
        .filter-item.active .filter-link::before {
            left: 0;
        }

        .filter-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-icon {
            font-size: 0.875rem;
        }

        .filter-count {
            background: rgba(0, 0, 0, 0.1);
            color: #718096;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-link:hover .filter-count,
        .filter-item.active .filter-link .filter-count {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Products Content */
        .products-content {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .products-controls {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-form {
            width: 100%;
            max-width: 500px;
        }

        .search-input-group {
            display: flex;
            background: white;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .search-input-group:focus-within {
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.2);
        }

        .search-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            color: #667eea;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 1rem 0;
            font-size: 1rem;
            outline: none;
            background: transparent;
        }

        .search-button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .results-info {
            text-align: right;
        }

        .results-count {
            color: #4a5568;
            font-size: 1rem;
        }

        .count-number {
            color: #667eea;
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0 0.25rem;
        }

        /* Active Filters */
        .active-filters {
            padding: 1.5rem 2rem;
            background: #f7fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .filters-header {
            margin-bottom: 1rem;
        }

        .filters-label {
            font-weight: 600;
            color: #4a5568;
        }

        .filters-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-tag {
            background: white;
            border: 2px solid #667eea;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .tag-label {
            color: #667eea;
            font-weight: 600;
        }

        .tag-value {
            color: #4a5568;
        }

        .tag-remove {
            color: #e53e3e;
            text-decoration: none;
            padding: 0.25rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .tag-remove:hover {
            background: #fed7d7;
            color: #c53030;
        }

        /* Products Grid */
        .products-grid-section {
            padding: 2rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-grid-item {
            transition: transform 0.3s ease;
        }

        /* No Results State */
        .no-results-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-results-icon {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1.5rem;
        }

        .no-results-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .no-results-description {
            color: #718096;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .no-results-action {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .no-results-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Pagination */
        .pagination-section {
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f7fafc;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .products-layout {
                grid-template-columns: 250px 1fr;
                gap: 2rem;
            }

            .title-text {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .products-layout {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .products-sidebar {
                position: static;
                order: 2;
            }

            .products-content {
                order: 1;
            }

            .products-controls {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
            }

            .filters-list {
                justify-content: center;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .title-text {
                font-size: 1.75rem;
            }

            .modern-page-header {
                padding: 2rem 0 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .search-input-group {
                flex-direction: column;
                border-radius: 15px;
            }

            .search-button {
                padding: 0.75rem 1.5rem;
            }

            .filter-tag {
                font-size: 0.75rem;
                padding: 0.375rem 0.75rem;
            }
        }

        /* Loading Animation */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 1.5s infinite;
        }

        /* Smooth Transitions */
        * {
            box-sizing: border-box;
        }

        .product-grid-item {
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .filter-link,
        .search-button,
        .no-results-action {
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS Animation
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 600,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: 50
                });
            }

            // Search form enhancement
            const searchForm = document.querySelector('.search-form');
            const searchInput = document.querySelector('.search-input');
            const searchButton = document.querySelector('.search-button');

            if (searchForm && searchInput) {
                // Auto-submit on enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchForm.submit();
                    }
                });

                // Search input focus effects
                searchInput.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                searchInput.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });

                // Loading state for search
                searchForm.addEventListener('submit', function() {
                    searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tìm...';
                    searchButton.disabled = true;
                });
            }

            // Filter links enhancement
            const filterLinks = document.querySelectorAll('.filter-link');
            filterLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state
                    const originalText = this.querySelector('.filter-text').innerHTML;
                    this.querySelector('.filter-text').innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i> Đang tải...';

                    // Allow the link to proceed normally
                    setTimeout(() => {
                        this.querySelector('.filter-text').innerHTML = originalText;
                    }, 100);
                });
            });

            // Smooth scroll for pagination
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading effect
                    this.style.opacity = '0.5';
                    this.style.pointerEvents = 'none';
                });
            });

            // Enhanced product grid animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe product items
            const productItems = document.querySelectorAll('.product-grid-item');
            productItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                item.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(item);
            });

            // Filter tags animation
            const filterTags = document.querySelectorAll('.filter-tag');
            filterTags.forEach((tag, index) => {
                tag.style.animationDelay = `${index * 0.1}s`;
                tag.classList.add('fadeInUp');
            });

            // Sidebar sticky behavior enhancement
            const sidebar = document.querySelector('.products-sidebar');
            const content = document.querySelector('.products-content');

            if (sidebar && content && window.innerWidth > 768) {
                let lastScrollTop = 0;

                window.addEventListener('scroll', function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const contentRect = content.getBoundingClientRect();

                    // Hide/show sidebar based on scroll direction
                    if (scrollTop > lastScrollTop && scrollTop > 200) {
                        sidebar.style.transform = 'translateX(-20px)';
                        sidebar.style.opacity = '0.7';
                    } else {
                        sidebar.style.transform = 'translateX(0)';
                        sidebar.style.opacity = '1';
                    }

                    lastScrollTop = scrollTop;
                });
            }

            // Enhanced search suggestions (if needed in future)
            let searchTimeout;
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    if (query.length >= 2) {
                        searchTimeout = setTimeout(() => {
                            // Add visual feedback
                            this.style.background = 'linear-gradient(135deg, #f0f8ff, #e6f3ff)';
                        }, 300);
                    } else {
                        this.style.background = '';
                    }
                });
            }

            // Add ripple effect to buttons
            function addRippleEffect(button) {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            }

            // Apply ripple effect to interactive elements
            document.querySelectorAll('.search-button, .filter-link, .no-results-action').forEach(addRippleEffect);
        });

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

            .fadeInUp {
                animation: fadeInUp 0.6s ease forwards;
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
        `;

        const style = document.createElement('style');
        style.textContent = rippleCSS;
        document.head.appendChild(style);
    </script>
@endpush
