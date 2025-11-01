@extends('layout.master')


@section('title', 'Product Page')


@section('link')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
@endsection

@section('script')
    <script>
        var map = L.map('map').setView([37.25817148200506, 55.16899702628263], 14);
        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
        }).addTo(map);
        var marker = L.marker([37.25817148200506, 55.16899702628263]).addTo(map)
            .bindPopup('<b>Qabus Ibn Voshmgir Historical Tower</b>').openPopup();
    </script>
@endsection

@section('content')
    <!-- food section -->
    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row gy-5">
                        <div class="col-sm-12 col-lg-6">
                            <h3 class="fw-bold mb-4">{{ $product->name }} </h3>
                            <h5 class="mb-3">
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
                            </h5>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                                است.</p>

                            <form x-data="{ quantity: 1 }" action="{{ route('cart.add') }}" class="mt-5 d-flex">
                                <button class="btn-add">افزودن به سبد خرید</button>
                                <input name="product_id" value="{{ $product->id }}" type="hidden">
                                <input name="qty" :value="quantity" type="hidden">
                                <div class="input-counter ms-4">
                                    <span @click="quantity < {{ $product->quantity }} && quantity++" class="plus-btn">
                                        +
                                    </span>
                                    <div class="input-number" x-text="quantity"></div>
                                    <span @click="quantity > 1 && quantity--" class="minus-btn">
                                        -
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                        class="active"></button>

                                    @foreach ($product->images as $key => $image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="{{ $key + 1 }}"></button>
                                    @endforeach

                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ imageUrl($product->primary_image) }}" class="d-block w-100"
                                            alt="primary_image" />
                                    </div>

                                    @foreach ($product->images as $image)
                                        <div class="carousel-item">
                                            <img src="{{ imageUrl($image->image) }}" class="d-block w-100"
                                                alt="image" />
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end food section -->
    <hr>
    @php
        $products = App\Models\Product::inRandomOrder()->take(4)->get();
    @endphp
    <section class="food_section my-5">
        <div class="container">
            <div class="row gx-3">
                @foreach ($products as $item)
                    <div class="col-sm-6 col-lg-3">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img class="img-fluid" src="{{ imageUrl($item->primary_image) }}" alt="" />
                                </div>
                                <div class="detail-box">
                                    <h5>
                                        <a href="{{ route('product.show', $item->slug) }}">
                                            {{ $item->name }}
                                        </a>
                                    </h5>
                                    <p>
                                        {{ $item->description }}
                                    </p>
                                    <div class="options">
                                        <h6>
                                            @if ($item->sale_price)
                                                <del>{{ number_format($item->price) }}</del>
                                                <span>
                                                    <span class="text-danger">
                                                        ({{ discountPercent($item->price, $item->sale_price) }}%)
                                                    </span>
                                                    {{ number_format($item->sale_price) }}
                                                    <span>تومان</span>
                                                </span>
                                            @else
                                                <p>{{ number_format($item->price) }} تومان</p>
                                            @endif
                                        </h6>
                                        <div class="d-flex">
                                            <a class="me-2"
                                                href="{{ route('cart.increment', ['product_id' => $item->id, 'qty' => 1]) }}">
                                                <i class="bi bi-cart-fill text-white fs-6"></i>
                                            </a>
                                            <a href="{{ route('profile.wishlist.add', ['product_id' => $item->id]) }}">
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
        </div>
    </section>
@endsection
