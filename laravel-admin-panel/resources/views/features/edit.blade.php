@extends('layout.master')
@section('title', 'Feature Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش ویژگی</h4>
    </div>

    <form action="{{ route('feature.update', ['feature' => $feature->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-2">
            <label class="form-label">عنوان</label>
            <input name="title" value="{{ $feature->title }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-7">
            <label class="form-label"> متن</label>
            <input name="body" value="{{ $feature->body }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">آیکون </label>
            <input name="icon" value="{{ $feature->icon }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('icon')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش ویژگی
            </button>
        </div>
    </form>
@endsection
