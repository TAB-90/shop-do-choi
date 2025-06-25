<div class="modern-product-card {{ $containerClass ?? '' }}">
    <div class="product-wrapper">
        <div class="product-image-container">
            <div class="image-overlay"></div>
            <img src="{{ Storage::url($product->cover_image) }}" alt="{{ $product->title }}" loading="lazy" class="product-image">
            
            @if ($product->is_bestseller)
                <div class="product-badge bestseller-badge">
                    <i class="fas fa-star"></i>
                    <span>Bestseller</span>
                </div>
            @endif
            
            <div class="quick-actions">
                <button class="quick-action-btn add-to-cart" data-id="{{ $product->id }}" title="Thêm vào giỏ">
                    <i class="fas fa-shopping-bag"></i>
                </button>
                <button class="quick-action-btn add-to-wishlist" data-id="{{ $product->id }}" title="Yêu thích">
                    @if (isset($product->is_favorited) && $product->is_favorited)
                        <i class="fas fa-heart favorited"></i>
                    @else
                        <i class="far fa-heart"></i>
                    @endif
                </button>
            </div>
        </div>
        
        <div class="product-content">
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="product-category-link">
                {{ $product->category->name }}
            </a>
            <a href="{{ route('products.show', $product->slug) }}" class="product-name text-decoration-none">{{ $product->title }}</a>
            <div class="product-pricing">
                <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .modern-product-card {
                height: 100%;
                perspective: 1000px;
                transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            }

            .product-wrapper {
                background: #ffffff;
                border-radius: 20px;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
                position: relative;
                transform-style: preserve-3d;
            }

            .modern-product-card:hover .product-wrapper {
                transform: translateY(-12px) rotateX(5deg);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }

            .product-image-container {
                position: relative;
                aspect-ratio: 1;
                overflow: hidden;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
                z-index: 1;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .modern-product-card:hover .image-overlay {
                opacity: 1;
            }

            .product-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
            }

            .modern-product-card:hover .product-image {
                transform: scale(1.1) rotate(2deg);
            }

            .product-badge {
                position: absolute;
                top: 16px;
                left: 16px;
                background: linear-gradient(135deg, #ff6b6b, #ff8e53);
                color: white;
                padding: 8px 16px;
                border-radius: 25px;
                font-size: 0.75rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 6px;
                z-index: 2;
                box-shadow: 0 4px 20px rgba(255, 107, 107, 0.4);
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            .quick-actions {
                position: absolute;
                top: 16px;
                right: 16px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                z-index: 2;
                opacity: 0;
                transform: translateX(30px);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            }

            .modern-product-card:hover .quick-actions {
                opacity: 1;
                transform: translateX(0);
            }

            .quick-action-btn {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #4a5568;
                transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .quick-action-btn:hover {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                transform: scale(1.1) rotate(5deg);
                box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
            }

            .quick-action-btn .favorited {
                color: #ff6b6b;
            }

            .product-content {
                padding: 24px 20px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                background: white;
            }

            .product-category-link {
                color: #667eea;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                margin-bottom: 8px;
                text-decoration: none;
                transition: color 0.2s ease;
                position: relative;
            }

            .product-category-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                transition: width 0.3s ease;
            }

            .product-category-link:hover::after {
                width: 100%;
            }

            .product-name {
                font-size: 0.7rem;
                font-weight: 600;
                margin-bottom: 16px;
                line-height: 1.5;
                color: #2d3748;
                flex-grow: 1;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .product-pricing {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .current-price {
                font-size: 1.25rem;
                font-weight: 800;
                background: linear-gradient(135deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .product-content {
                    padding: 16px;
                }

                .product-name {
                    font-size: 1rem;
                }

                .current-price {
                    font-size: 1.1rem;
                }

                .quick-action-btn {
                    width: 40px;
                    height: 40px;
                }

                .quick-actions {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Loading Animation */
            @keyframes shimmer {
                0% { background-position: -200px 0; }
                100% { background-position: calc(200px + 100%) 0; }
            }

            .product-image[src=""], .product-image:not([src]) {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200px 100%;
                animation: shimmer 1.5s infinite;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add to cart functionality
                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const productId = this.dataset.id;
                        
                        // Add loading state
                        this.style.transform = 'scale(0.95)';
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        
                        addToCart(productId, this);
                    });
                });

                // Add to wishlist functionality
                document.querySelectorAll('.add-to-wishlist').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const productId = this.dataset.id;
                        
                        // Add animation
                        this.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 200);
                        
                        addToWishlist(productId);
                    });
                });

                function addToCart(productId, button) {
                    fetch(`/user/cart/add/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ quantity: 1 })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Reset button
                            button.innerHTML = '<i class="fas fa-shopping-bag"></i>';
                            button.style.transform = '';
                            
                            if (data.success) {
                                showToast('Đã thêm đồ chơi vào giỏ hàng', 'success');
                                
                                // Success animation
                                button.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
                                button.style.color = 'white';
                                setTimeout(() => {
                                    button.style.background = '';
                                    button.style.color = '';
                                }, 1000);

                                if (document.querySelector('.cart-count')) {
                                    document.querySelector('.cart-count').textContent = data.cartCount;
                                }
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra khi thêm đồ chơi vào giỏ hàng', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            button.innerHTML = '<i class="fas fa-shopping-bag"></i>';
                            button.style.transform = '';
                        });
                }

                function addToWishlist(productId) {
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
                                const heartIcons = document.querySelectorAll(`.add-to-wishlist[data-id="${productId}"] i`);
                                heartIcons.forEach(icon => {
                                    if (data.added) {
                                        icon.classList.remove('far');
                                        icon.classList.add('fas', 'favorited');
                                        
                                        // Heart animation
                                        icon.style.animation = 'heartBeat 0.6s ease-in-out';
                                        setTimeout(() => {
                                            icon.style.animation = '';
                                        }, 600);
                                        
                                        showToast('Đã thêm vào danh sách yêu thích', 'success');
                                    } else {
                                        icon.classList.remove('fas', 'favorited');
                                        icon.classList.add('far');
                                        showToast('Đã xóa khỏi danh sách yêu thích', 'success');
                                    }
                                });
                            } else {
                                showToast(data.message || 'Có lỗi xảy ra khi cập nhật danh sách yêu thích', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            // Heart beat animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes heartBeat {
                    0%, 50%, 100% { transform: scale(1); }
                    25%, 75% { transform: scale(1.3); }
                }
            `;
            document.head.appendChild(style);
        </script>
    @endpush
@endonce