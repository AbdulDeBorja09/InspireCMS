@extends('user.layouts.app')
@section('content')

<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image"
        style=" background-image: url('/storage/{{ $contents['articles-background']->value ?? ''}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['articles-title']->value ?? '' }}</h1>
                        <p>{{ $contents['articles-tagline']->value ?? '' }}</p>
                        <a onclick="history.back()"><button class="btn shadow-none back-btn">
                                <i class="bi bi-arrow-left"></i> Go Back
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- END OF HEADER -->

<!-- CONTENTS -->
<section id="articles">
    <div class="container py-5 mb-5 articles-tab">
        <div class="row justify-content-start g-4 articles-box">

            @if(isset($articles) && $articles->isNotEmpty())
            @foreach($articles as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
                <a class="news-card" href="
                @if($item->redirect_url)
                 {{$item->redirect_url}}
                @else
                {{url('/Article/'.$item->id)}}
                @endif" @if($item->redirect_url)
                    target="__blank"
                    @endif>
                    <img src="{{asset('../storage/'. $item->image)}}" alt="{{$item->title}}" />
                    <div class="meta-info">
                        <span><i class="bi bi-person"></i> {{$item->author}}</span>
                        <span><i class="bi bi-calendar"></i>{{ \Carbon\Carbon::parse($item->date)->format('F j, Y') }}
                        </span>
                    </div>
                    <p class="news-title">
                        {{$item->title}}
                    </p>
                </a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

@endsection
@push('css')
<link href="{{ asset('/css/article.css') }}?v={{ time() }}" rel="stylesheet">
@endpush