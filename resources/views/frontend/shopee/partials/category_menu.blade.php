<div class="aiz-category-menu bg-white rounded-0 border-top shopee" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        <li class="category-nav-element border border-top-0 position-relative">
            <a href="#" class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                <?php $e_commerce_image = get_single_category(12);
                // print_r(uploaded_asset($e_commerce_image['cover_image']));exit;
                ?>
                <img class="cat-image lazyload mr-2" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($e_commerce_image['cover_image']) ? uploaded_asset($e_commerce_image['cover_image']) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $e_commerce_image['name'] ?? '' }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                <span class="cat-name has-transition">E-commerce</span>
            </a>
            <div class="sub-cat-menu c-scrollbar-light border p-2 shadow-none bg-white">
                <ul class="list-unstyled">
                    @foreach (get_level_zero_categories()->take(10) as $key => $category)
                    @php
                        $category_name = $category->getTranslation('name');
                    @endphp
                    <li class="p-2 sub-mrnu-custom"><a href="{{ route('products.category', $category->slug) }}">{{ $category_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>

    </ul>
</div>
<div class="aiz-category-menu bg-white rounded-0 border-top shopee" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        <li class="category-nav-element border border-top-0 position-relative">
            <?php $eSerbisyoimg = get_single_category(13);
                ?>
            <a href="#" class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($eSerbisyoimg['cover_image']) ? uploaded_asset($eSerbisyoimg['cover_image']) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $eSerbisyoimg['name'] ?? '' }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                <span class="cat-name has-transition">eSerbisyo</span>
            </a>
            <div class="sub-cat-menu c-scrollbar-light border p-2 shadow-none bg-white">
                <ul class="list-unstyled">
                    @foreach (get_level_zero_service() as $key => $service)
                    @php
                        $service_name = $service['name'];
                        $service_url = route('service', $service['slug']);
                    @endphp
                    <li class="p-2 sub-mrnu-custom"><a href="{{$service_url}}">{{ $service_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>

    </ul>
</div>

<div class="aiz-category-menu bg-white rounded-0 border-top shopee" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        <?php $PasabuyImg = get_single_category(14);
                ?>
        <li class="category-nav-element border border-top-0 position-relative">
            <a href="#" class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($PasabuyImg['cover_image']) ? uploaded_asset($PasabuyImg['cover_image']) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $PasabuyImg['name'] ?? '' }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                <span class="cat-name has-transition">E Pasabuy</span>
            </a>
            <div class="sub-cat-menu c-scrollbar-light border p-2 shadow-none bg-white">

            </div>
        </li>

    </ul>
</div>

<div class="aiz-category-menu bg-white rounded-0 border-top shopee" id="category-sidebar" style="width:270px;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        <?php $FarmerImg = get_single_category(11);
                ?>
        <li class="category-nav-element border border-top-0 position-relative">
            <a href="#" class="text-truncate text-dark px-4 fs-14 d-block hov-column-gap-1">
                <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($FarmerImg['cover_image']) ? uploaded_asset($FarmerImg['cover_image']) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $FarmerImg['name'] ?? '' }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                <span class="cat-name has-transition">Farmer</span>
            </a>
            <div class="sub-cat-menu c-scrollbar-light border p-2 shadow-none bg-white">
                <ul class="list-unstyled">
                    @foreach (get_level_zero_farmer() as $key => $farmer)
                    @php
                        $service_name = $farmer['name'];
                        $service_url = route('product', $farmer['slug']);
                    @endphp
                    <li class="p-2 sub-mrnu-custom"><a href="{{$service_url}}">{{ $service_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>

    </ul>
</div>
