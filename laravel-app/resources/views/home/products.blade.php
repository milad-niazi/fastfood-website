<section class="food_section layout_padding-bottom">
    <div class="container" x-data="{ tab: 1 }">
        <div class="heading_container heading_center">
            <h2>
                منو محصولات
            </h2>
        </div>

        <ul class="filters_menu">
            <li :class="tab === 4 ? 'active' : ''" @click="tab = 4"> پیتزا </li>
            <li :class="tab === 1 ? 'active' : ''" @click="tab = 1">ساندویچ و برگر</li>
            <li :class="tab === 5 ? 'active' : ''" @click="tab = 5">سالاد و نوشیدنی</li>
        </ul>
        @php
            $pizzas = App\Models\Product::where('category_id', 1)->take(3)->whereNull('deleted_at')->get();
            $burgers = App\Models\Product::where('category_id', 4)->take(3)->whereNull('deleted_at')->get();
            $salads = App\Models\Product::where('category_id', 5)->take(3)->whereNull('deleted_at')->get();
        @endphp
        <div class="filters-content">
            <div x-show="tab === 1">
                <div class="row grid">
                    @foreach ($burgers as $burger)
                        <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ imageUrl($burger->primary_image) }}"
                                            alt="{{ $burger->primary_image }}">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('product.show', $burger->slug) }}">
                                                {{ $burger->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $burger->description }}
                                        </p>
                                        <div class="options">
                                            <h6>
                                                @if ($burger->sale_price)
                                                    <del>{{ number_format($burger->price) }}</del>
                                                    <span>
                                                        <span class="text-danger">
                                                            ({{ discountPercent($burger->price, $burger->sale_price) }}%)
                                                        </span>
                                                        {{ number_format($burger->sale_price) }}
                                                        <span>تومان</span>
                                                    </span>
                                                @else
                                                    <p>{{ number_format($burger->price) }} تومان</p>
                                                @endif
                                            </h6>

                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment', ['product_id' => $burger->id , 'qty' => 1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a
                                                    href="{{ route('profile.wishlist.add', ['product_id' => $burger->id]) }}">
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

            <div x-show="tab === 4">
                <div class="row grid">
                    @foreach ($pizzas as $pizza)
                        <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ imageUrl($pizza->primary_image) }}"
                                            alt="{{ $pizza->primary_image }}">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('product.show', $pizza->slug) }}">
                                                {{ $pizza->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $pizza->description }}
                                        </p>
                                        <div class="options">
                                            <h6>
                                                @if ($pizza->sale_price)
                                                    <del>{{ number_format($pizza->price) }}</del>
                                                    <span>
                                                        <span class="text-danger">
                                                            ({{ discountPercent($pizza->price, $pizza->sale_price) }}%)
                                                        </span>
                                                        {{ number_format($pizza->sale_price) }}
                                                        <span>تومان</span>
                                                    </span>
                                                @else
                                                    <p>{{ number_format($pizza->price) }} تومان</p>
                                                @endif
                                            </h6>

                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment', ['product_id' => $pizza->id, 'qty' => 1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a
                                                    href="{{ route('profile.wishlist.add', ['product_id' => $pizza->id]) }}">
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

            <div x-show="tab === 5">
                <div class="row grid">
                    @foreach ($salads as $salad)
                        <div class="col-sm-6 col-lg-4">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{ imageUrl($salad->primary_image) }}"
                                            alt="{{ $salad->primary_image }}">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            <a href="{{ route('product.show', $salad->slug) }}">
                                                {{ $salad->name }}
                                            </a>
                                        </h5>
                                        <p>
                                            {{ $salad->description }}
                                        </p>
                                        <div class="options">
                                            <h6>
                                                @if ($salad->sale_price)
                                                    <del>{{ number_format($salad->price) }}</del>
                                                    <span>
                                                        <span class="text-danger">
                                                            ({{ discountPercent($salad->price, $salad->sale_price) }}%)
                                                        </span>
                                                        {{ number_format($salad->sale_price) }}
                                                        <span>تومان</span>
                                                    </span>
                                                @else
                                                    <p>{{ number_format($salad->price) }} تومان</p>
                                                @endif
                                            </h6>

                                            <div class="d-flex">
                                                <a class="me-2" href="{{ route('cart.increment', ['product_id' => $salad->id, 'qty' => 1]) }}">
                                                    <i class="bi bi-cart-fill text-white fs-6"></i>
                                                </a>
                                                <a
                                                    href="{{ route('profile.wishlist.add', ['product_id' => $salad->id]) }}">
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

        </div>

        <div class="btn-box">
            <a href="">
                مشاهده بیشتر
            </a>
        </div>
    </div>
</section>
