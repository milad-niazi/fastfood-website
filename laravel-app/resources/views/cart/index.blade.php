@extends('layout.master')


@section('title', 'Home')


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
    @if ($cart == null)
        <div class="cart-empty">
            <div class="text-center">
                <div>
                    <i class="bi bi-basket-fill" style="font-size:80px"></i>
                </div>
                <h4 class="text-bold">سبد خرید شما خالی است</h4>
                <a href="{{ route('product.menu') }}" class="btn btn-outline-dark mt-3">
                    مشاهده محصولات
                </a>
            </div>
        </div>
    @else
        <section class="single_page_section layout_padding">
            <div x-data="{ addressId: null }" class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row gy-5">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>محصول</th>
                                                <th>نام</th>
                                                <th>قیمت</th>
                                                <th>تعداد</th>
                                                <th>قیمت کل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $key => $item)
                                                <tr>
                                                    <th>
                                                        <img class="rounded" src="{{ imageUrl($item['primary_image']) }}"
                                                            width="100" alt="" />
                                                    </th>
                                                    <td class="fw-bold">{{ $item['name'] }}</td>
                                                    <td>
                                                        @if ($item['is_sale'])
                                                            <div>
                                                                <del>{{ number_format($item['price']) }}</del>
                                                                {{ number_format($item['price']) }} تومان
                                                            </div>
                                                            <div class="text-danger">
                                                                {{ discountPercent($item['price'], $item['sale_price']) }}%
                                                            </div>
                                                        @else
                                                            <div>
                                                                {{ number_format($item['price']) }} تومان
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-counter">
                                                            <a href="{{ route('cart.increment', ['product_id' => $key, 'qty' => 1]) }}"
                                                                class="plus-btn">
                                                                +
                                                            </a>
                                                            <div class="input-number">{{ $item['qty'] }}</div>
                                                            <a href="{{ route('cart.decrement', ['product_id' => $key, 'qty' => $item['qty'] - 1]) }}"
                                                                class="minus-btn">
                                                                -
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $price = $item['is_sale']
                                                                ? $item['sale_price']
                                                                : $item['price'];
                                                        @endphp
                                                        <span>{{ number_format($item['qty'] * $price) }}</span>
                                                        <span class="ms-1">تومان</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('cart.remove', ['product_id' => $key]) }}">
                                                            <i class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('cart.clear') }}" class="btn btn-primary mb-4">پاک کردن سبد خرید</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6">
                                <form action="{{ route('cart.checkCoupon') }}">
                                    <div class="input-group mb-3">
                                        <input name="code" type="text" class="form-control" placeholder="کد تخفیف" />
                                        <button type="submit" class="input-group-text" id="basic-addon2">اعمال کد
                                            تخفیف</button>
                                    </div>
                                    <div class="form-text text-danger">
                                        @error('code')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-end align-items-baseline">
                                @if ($addresses->isEmpty())
                                    <a href="{{ route('profile.address.create') }}" class="btn btn-primary">
                                        ایجاد آدرس
                                    </a>
                                @else
                                    <div>
                                        انتخاب آدرس
                                    </div>
                                    <select x-model="addressId" style="width: 200px;" class="form-select ms-3">
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger">
                                        @error('address_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold">مجموع سبد خرید</h5>
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>مجموع قیمت :</div>
                                                <div>
                                                    {{ number_format($cartTotalPrice) }} تومان
                                                </div>
                                            </li>

                                            @php
                                                $couponPercent = 0;
                                                $couponPrice = 0;
                                                $FinalPrice = $cartTotalPrice;
                                                if (request()->session()->has('coupon')) {
                                                    $coupon = request()->session()->get('coupon');
                                                    $couponCode = $coupon['code'];
                                                    $couponPercent = $coupon['percent'];
                                                    $couponPrice = ($cartTotalPrice * $couponPercent) / 100;
                                                    $FinalPrice = $cartTotalPrice - $couponPrice;
                                                }
                                            @endphp

                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>تخفیف :
                                                    <span class="text-danger ms-1">{{ $couponPercent }}%</span>
                                                </div>
                                                <div class="text-danger">
                                                    {{ number_format($couponPrice) }}
                                                    تومان
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>قیمت پرداختی :</div>
                                                <div>
                                                    {{ number_format($FinalPrice) }}
                                                    تومان
                                                </div>
                                            </li>
                                        </ul>
                                        <form action="{{ route('payment.send') }}" method="POST">
                                            @csrf
                                            <input name="coupon_code"
                                                value="{{ $couponPrice != 0 ? $coupon['code'] : null }}" type="hidden">
                                            <input name="address_id" :value="addressId" type="hidden">
                                            <button type="submit" class="user_option btn-auth mt-4">پرداخت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
