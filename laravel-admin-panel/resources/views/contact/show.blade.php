@extends('layout.master')
@section('title', 'Slider Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش پیام</h4>
    </div>

    <form class="row gy-4" action="{{ route('contact.destroy', $message) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="col-md-4">
            <label class="form-label">نام فرستنده</label>
            <input disabled value="{{ $message->name }}" type="text" class="form-control" />
        </div>
        <div class="col-md-4">
            <label class="form-label"> ایمیل</label>
            <input disabled value="{{ $message->email }}" type="text" class="form-control" />

        </div>
        <div class="col-md-4">
            <label class="form-label">موضوع </label>
            <input disabled value="{{ $message->subject }}" type="text" class="form-control" />

        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea disabled class="form-control" rows="3">{{ $message->body }}</textarea>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
        </div>
    </form>
@endsection
