@php
    $item = App\Models\About::first();
@endphp
<section class="about_section layout_padding">
    <div class="container">

        <div class="row">
            <div class="col-md-6 ">
                <div class="img-box">
                    <img src="{{ asset('/images/about-img.png ') }}" alt="" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            {{ $item->title }}
                        </h2>
                    </div>
                    <p>
                        {{ $item->body }}
                    </p>
                    <a href="{{ $item->link }}">
                        مشاهده بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
