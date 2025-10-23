<!DOCTYPE html>
<html lang="en" dir="ltr">
@include('client.layout.components.head')

<body data-mn-mode="light">
    <main class="wrapper sb-default">
        <div id="mn-overlay">
            <div class="loader">
                <img src="https://maraviyainfotech.com/projects/mantu-html/assets/img/logo/loader.png" alt="loader">
                <span class="shape"></span>
            </div>
        </div>
        @include('client.layout.components.header')
        <div class="mn-main-content sb-hide">
            @yield('content')
        </div>
        @include('client.layout.components.footer')
        <!-- Quick view Modal -->
        <div class="modal fade quickview-modal" id="quickview_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="qty-close" data-bs-dismiss="modal" aria-label="Close"
                        title="Close"></button>
                    <div class="modal-body">
                        <div class="row mb-minus-24">
                            <div class="col-md-5 col-sm-12 col-xs-12 mb-24">
                                <div class="single-pro-img single-pro-img-no-sidebar">
                                    <div class="single-product-scroll">
                                        <div class="single-slide-quickview owl-carousel">
                                            <img class="img-responsive"
                                                src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/1.jpg"
                                                alt="product-img-1">
                                            <img class="img-responsive"
                                                src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/2.jpg"
                                                alt="product-img-1">
                                            <img class="img-responsive"
                                                src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/3.jpg"
                                                alt="product-img-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 col-xs-12 mb-24">
                                <div class="quickview-pro-content">
                                    <h5 class="mn-quick-title">
                                        <a href="product-detail.html">Best cotton fabric women's half sleeve
                                            T-shirt white color.</a>
                                    </h5>
                                    <div class="mn-pro-rating">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill grey"></i>
                                    </div>
                                    <div class="mn-quickview-desc">Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                        ever
                                        since the 1900s.</div>
                                    <div class="mn-quickview-price">
                                        <span class="new-price">$50.00</span>
                                        <span class="old-price">$62.00</span>
                                    </div>
                                    <div class="mn-pro-variations">
                                        <ul>
                                            <li class="active">
                                                <a href="javascript:void(0)" class="mn-opt-sz"
                                                    data-tooltip="Small">s</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="mn-opt-sz"
                                                    data-tooltip="Medium">m</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="mn-opt-sz"
                                                    data-tooltip="Large">l</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="mn-opt-sz"
                                                    data-tooltip="Extra Large">xl</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mn-quickview-qty">
                                        <div class="qty-plus-minus">
                                            <input class="qty-input" type="text" name="mn-qtybtn" value="1">
                                        </div>
                                        <div class="mn-quickview-cart">
                                            <a href="cart.html" class="mn-btn-1">
                                                <span><i class="ri-shopping-bag-line"></i>Add To Cart</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Sidebar -->
        <div class="mn-side-search-overlay"></div>
        <div class="mn-side-search">
            <div class="mn-search-inner">
                <div class="mn-search-title">
                    <span class="search_title">Search</span>
                    <a href="javascript:void(0)" class="mn-search-close">
                        <i class="ri-close-line"></i>
                    </a>
                </div>
                <div class="mn-search">
                    <form>
                        <input type="text" placeholder="Search here...">
                        <a href="javascript:void(0)"><i class="ri-search-line"></i></a>
                    </form>
                </div>
                <div class="mn-search-list">
                    <ul class="mn-search-pro-items">
                        <li class="search-sidebar-list">
                            <a href="product-detail.html" class="mn-pro-img"><img
                                    src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/9.jpg"
                                    alt="product"></a>
                            <div class="mn-pro-content">
                                <a href="product-detail.html" class="search-pro-title">Sport Shoes</a>
                                <a href="shop-right-sidebar.html" class="search-cat">Shoes</a>
                                <ul class="mn-ratings">
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                </ul>
                                <span class="search-price"><span>$255.00</span><span class="stock">- 11 in
                                        Stock</span></span>
                                <a href="javascript:void(0)" class="search-remove-item">×</a>
                            </div>
                        </li>
                        <li class="search-sidebar-list">
                            <a href="product-detail.html" class="mn-pro-img"><img
                                    src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/15.jpg"
                                    alt="product"></a>
                            <div class="mn-pro-content">
                                <a href="product-detail.html" class="search-pro-title">Leather bag</a>
                                <a href="shop-right-sidebar.html" class="search-cat">Bags</a>
                                <ul class="mn-ratings">
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                </ul>
                                <span class="search-price"><span>$65.00</span><span class="stock">- 54 in
                                        Stock</span></span>
                                <a href="javascript:void(0)" class="search-remove-item">×</a>
                            </div>
                        </li>
                        <li class="search-sidebar-list">
                            <a href="product-detail.html" class="mn-pro-img"><img
                                    src="https://maraviyainfotech.com/projects/mantu-html/assets/img/product/1.jpg"
                                    alt="product"></a>
                            <div class="mn-pro-content">
                                <a href="product-detail.html" class="search-pro-title">T-shirt for girls</a>
                                <a href="shop-right-sidebar.html" class="search-cat">Clothes</a>
                                <ul class="mn-ratings">
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                    <li><i class="ri-star-fill grey"></i></li>
                                </ul>
                                <span class="search-price"><span>$59.00</span><span class="stock">- 4 in
                                        Stock</span></span>
                                <a href="javascript:void(0)" class="search-remove-item">×</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mn-search-also m-t-15">
                    <div class="mn-search-title">
                        <span class="search_title">Recently searches</span>
                    </div>
                    <ul>
                        <li><a href="shop-right-sidebar.html">T-shirts</a></li>
                        <li><a href="shop-right-sidebar.html">watches</a></li>
                        <li><a href="shop-right-sidebar.html">Bags</a></li>
                        <li><a href="shop-right-sidebar.html">Belts</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    @include('client.layout.components.script')
</body>

</html>
