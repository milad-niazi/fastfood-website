  @extends('profile.layout.master')


  @section('title', 'Profile')


  @section('link')
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin="" />
      <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
          integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
          crossorigin=""></script>
  @endsection


  @section('main')
      <div class="col-sm-12 col-lg-9">
          <form action="{{ route('profile.update', ['user' => $user]) }}" method="POST" class="vh-70">
              @csrf
              @method('PUT')
              <div class="row g-4">
                  <div class="col col-md-6">
                      <label class="form-label">نام و نام خانوادگی</label>
                      <input name="name" type="text" class="form-control" value="{{ $user->name }}" />
                      <div class="form-text text-danger">
                          @error('name')
                              {{ $message }}
                          @enderror
                      </div>
                  </div>
                  <div class="col col-md-6">
                      <label class="form-label">ایمیل</label>
                      <input name="email" type="email" class="form-control" value="{{ $user->email }}" />
                      <div class="form-text text-danger">
                          @error('email')
                              {{ $message }}
                          @enderror
                      </div>
                  </div>
                  <div class="col col-md-6">
                      <label class="form-label">شماره تلفن</label>
                      <input type="text" disabled class="form-control" value="{{ $user->cellphone }}" />
                  </div>
              </div>
              <button type="submit" class="btn btn-primary mt-4">ویرایش</button>
          </form>
      </div>
  @endsection
