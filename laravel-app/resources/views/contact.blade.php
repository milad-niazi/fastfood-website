@extends('layout.master')

@section('title', 'Contact Page')

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

    <!-- contact section -->
    <section class="book_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>
                    تماس با ما
                </h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_container">
                        <x-contact.form />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map_container ">
                        <div id="map" style="height: 345px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end contact section -->
@endsection
