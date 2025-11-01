@extends('layout.master')


@section('title', 'Products Menu')

@section('link')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
@endsection

@section('script')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({
                search: '',
                currentUrl: @json(url()->current()),
                params: new URLSearchParams(location.search),

                filter(type, value) {
                    this.params.set(type, value);
                    this.params.delete('page');
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                },

                removeFilter(type) {
                    this.params.delete(type);
                    this.params.delete('page');
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                }
            }))
        });
    </script>
@endsection

@section('content')
    <section class="food_section layout_padding">
        <div class="container">
            <div class="row">
                <div x-data="filter()" class="col-sm-12 col-lg-3">
                    <div>
                        <label class="form-label">جستجو
                            @if (request()->has('search'))
                                <i @click="removeFilter('search')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>

                        <div class="input-group mb-3">
                            <input type="text" x-model="search" class="form-control" placeholder="نام محصول ..." />
                            <button @click="filter('search', search)" class="input-group-text">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="filter-list">
                        <div class="form-label">
                            دسته بندی
                            @if (request()->has('category'))
                                <i @click="removeFilter('category')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li @click="filter('category', '{{ $category->id }}')"
                                    class="my-2 cursor-pointer {{ request()->has('category') && request()->category == $category->id ? 'filter-list-active' : '' }}">
                                    {{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <hr />
                    <div>
                        <label class="form-label">مرتب سازی
                            @if (request()->has('sortBy'))
                                <i @click="removeFilter('sortBy')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'max')"
                                {{ request()->has('sortBy') && request()->sortBy == 'max' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                بیشترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'min')"
                                {{ request()->has('sortBy') && request()->sortBy == 'min' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                کمترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'bestseller')"
                                {{ request()->has('sortBy') && request()->sortBy == 'bestseller' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                پرفروش ترین
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sortBy', 'sale')"
                                {{ request()->has('sortBy') && request()->sortBy == 'sale' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                با تخفیف
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-9">
                    @if ($products->isEmpty())
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <h5>محصولی یافت نشده!</h5>
                        </div>
                    @endif
                    <div class="row gx-3">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4">
                                <div class="box">
                                    <div>
                                        <div class="img-box">
                                            <img class="img-fluid" src="{{ imageUrl($product->primary_image) }}"
                                                alt="{{ $product->primary_image }}">
                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                <a href="{{ route('product.show', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h5>
                                            <p>
                                                {{ $product->description }}
                                            </p>
                                            <div class="options">
                                                <h6>
                                                    @if ($product->sale_price)
                                                        <del>{{ number_format($product->price) }}</del>
                                                        <span>
                                                            <span class="text-danger">
                                                                ({{ discountPercent($product->price, $product->sale_price) }}%)
                                                            </span>
                                                            {{ number_format($product->sale_price) }}
                                                            <span>تومان</span>
                                                        </span>
                                                    @else
                                                        <p>{{ number_format($product->price) }} تومان</p>
                                                    @endif
                                                </h6>

                                                <div class="d-flex">
                                                    <a class="me-2" href="{{ route('cart.increment', ['product_id' => $product->id, 'qty' => 1]) }}">
                                                        <i class="bi bi-cart-fill text-white fs-6"></i>
                                                    </a>
                                                    <a
                                                        href="{{ route('profile.wishlist.add', ['product_id' => $product->id]) }}">
                                                        <i class="bi bi-heart-fill  text-white fs-6"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        {{ $products->withQueryString()->links('layout.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
