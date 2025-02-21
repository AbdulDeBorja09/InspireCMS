@extends('user.layouts.app')
@section('content')
<section id="image" class="position-relative text-white">
    <div class="bg-image">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>Articles</h1>
                        <p>This is a template text</p>
                        <button onclick="window.history.back()" class="btn shadow-none back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END OF HEADER -->

<!-- SINGLE CONTENT PAGE -->
<section id="contents">
    <div class="container py-5 mb-5">
        <!-- SINGLE CONTENT IMAGES -->
        <div class="row">
            <div class="col-lg-12 col-md-12 cold-sm-12">
                <h1>{{$article->title}}</h1>
                <h5>{{$article->author}}</h5>
                <h6>{{ \Carbon\Carbon::parse($article->date)->format('F j, Y') }}</h6>
                <hr style="
              border: 1px solid #64748b;
              opacity: 1;
              width: 100%;
              float: left;
              margin-top: 5px;
            " />
                <!-- CONTENT IMAGE -->
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <img class="content-image" src="{{asset('../storage/'. $article->image)}}"
                            alt="{{$article->title}}" />


                        <!-- SINGLE CONTENT DESCRIPTION -->
                        <div class="content-container">
                            <p> {{$article->description}}
                            </p>
                        </div>
                    </div>

                    <!-- SOCIALS -->
                    <div class="col-lg-4">
                        <!-- Follow Our Socials -->
                        <div class="social-card mb-4">
                            <h5 class="fw-bold">Follow Our Socials</h5>
                            <div class="follow-socials">
                                @if ($facebook)
                                <a href="{{$facebook->value}}" target="_blank"><i class="bi bi-facebook"></i></a>
                                @endif
                                @if ($instagram)
                                <a href="{{$instagram->value}}" target="_blank"><i class="bi bi-instagram"></i></a>
                                @endif
                                @if ($tiktok)
                                <a href="{{$tiktok->value}}" target="_blank"><i class="bi bi-tiktok"></i></a>
                                @endif
                            </div>
                        </div>

                        <!-- REFERENCES -->
                        <div class="reference-card">
                            <h5 class="fw-bold">References:</h5>
                            <div class="reference-link">
                                @if($article->url1)
                                <a href="{{$article->url1}}" target="__blank">{{$article->url1}}</a>
                                @endif
                                @if($article->url1)
                                <a href="{{$article->url2}}" target="__blank">{{$article->url2}}</a>
                                @endif
                                @if($article->url1)
                                <a href="{{$article->url3}}" target="__blank">{{$article->url3}}</a>
                                @endif
                                @if($article->url1)
                                <a href="{{$article->url4}}" target="__blank">{{$article->url4}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('css')
<link href="{{ asset('../css/single-page-article.css') }}?v={{ time() }}" rel="stylesheet">
@endpush