@extends('layout.master')
@section('title', 'Contact Us')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">پیام ها</h4>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>موضوع </th>
                    <th>متن</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ $message->body }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('contact.show', $message) }}"
                                    class="btn btn-sm btn-outline-info me-2">نمایش</a>
                                <form action="{{ route('contact.destroy', $message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @if (session('success'))
        {{ session('success') }}
    @endif
@endsection
