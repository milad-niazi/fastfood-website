@extends('layout.master')
@section('title', 'Product Show')
@section('link')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش محصول</h4>
    </div>

    <form action="{{ route('product.index') }}" class="row gy-4 mb-5">
        <div class="col-md-12 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img src="{{ asset('images/products/' . $product->primary_image) }}" alt="{{ $product->primary_image }}"
                        class="rounded" width=350 height=220 />
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input name="name" type="text" value="{{ $product->name }}" class="form-control" disabled />
        </div>

        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
            <input name="price" type="text" value="{{ $product->category->name }}" disabled class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <input name="price" type="text" value="{{ $product->status ? 'فعال' : 'غیرفعال' }}" disabled
                class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input name="price" type="text" value="{{ $product->price }}" disabled class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input name="quantity" type="text" value="{{ $product->quantity }}" disabled class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت حراجی</label>
            <input name="sale_price" type="text" disabled value="{{ $product->sale_price }}" disabled
                class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input disabled
                value="{{ $product->date_on_sale_from != null ? getJalaliDate($product->date_on_sale_from) : '' }}"
                type="text" class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input disabled value="{{ $product->date_on_sale_to != null ? getJalaliDate($product->date_on_sale_to) : '' }}"
                type="text" class="form-control" />
        </div>

        <div class="col-md-12">
            <label class="form-label">توضیحات</label>
            <textarea name="description" rows="5" placeholder="{{ $product->description }}" disabled class="form-control"></textarea>
        </div>
        <div class="col-md-12">
            @foreach ($product->images as $image)
                <img src="{{ asset('images/products/' . $image->image) }}" class="rounded" width="200" alt="image">
            @endforeach
        </div>
        <div>
            <button class="btn btn-outline-dark mt-3">
                بازگشت به صفحه اصلی
            </button>
        </div>
    </form>
@endsection
