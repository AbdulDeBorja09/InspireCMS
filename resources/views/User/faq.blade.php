@extends('user.layouts.app')
@section('content')
<!-- HEADER -->
<section id="image" class="position-relative text-white">
    <div class="bg-image"
        style=" background-image: url('/storage/{{ $contents['faq-background']->value ?? '../images/home/bg.png'}}');">
        <div class="image-overlay">
            <div class="container">
                <div class="row justify-content-start image-text">
                    <div class="col-lg-12">
                        <h1>{{ $contents['faq-title']->value ?? 'FAQ' }}</h1>
                        <p>{{ $contents['faq-tagline']->value ?? 'This is a template text' }}</p>
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



<!-- FAQ -->
<section id="faq">
    <div class="container py-5 faq-container">
        <div class="categories">
            <h5><strong>Categories</strong></h5>

            @foreach ($categories as $index => $category)
            <a href="#" class="{{ $index == 0 ? 'active' : '' }}"
                onclick="showFAQ('{{$category->id}}', this)">{{$category->name}}</a>
            @endforeach
        </div>

        <div class="faq-content">
            <h2 class="text-center">Frequently Asked Questions</h2>

            @foreach ($categories as $index => $category)
            <!-- Basics FAQ -->
            <div class="faq-section {{ $index == 0 ? 'active' : '' }}" id="{{ $category->id }}">
                <div class="accordion" id="faqAccordionBasics">
                    @foreach ($category->faqs as $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq{{ $faq->id }}">
                                {{$faq->question}}
                            </button>
                        </h2>
                        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                {{$faq->answer}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @endforeach

         
        </div>
    </div>
</section>
<script>
    function showFAQ(categoryId, element) {
    // Remove the 'active' class from all category links
    document.querySelectorAll('.categories a').forEach(link => {
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked link
    element.classList.add('active');

    // Hide all FAQ sections
    document.querySelectorAll('.faq-section').forEach(section => {
        section.classList.remove('active');
    });

    // Show the selected FAQ section
    document.getElementById(categoryId).classList.add('active');
}

</script>
<!-- END OF FAQ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@push('css')
<link href="{{ asset('/css/faq.css') }}?v={{ time() }}" rel="stylesheet">
@endpush