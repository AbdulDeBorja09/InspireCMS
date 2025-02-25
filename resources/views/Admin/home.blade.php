@extends('Admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<!-- Home Content -->
<div class="content" id="home">
    <h1>Home</h1>
    <p>Manage homepage content.</p>

    <div class="form-container">
        <!-- Top Page Section -->

        <h4>Top Page Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="home">
            <div class="form-group">
                <label for="top-page-headline">Headline:</label>
                <input type="text" id="top-page-headline" name="top-headline" placeholder="Input Here"
                    value="{{ $contents['top-headline']->value ?? ''}}" required />
            </div>
            <div class="form-group">
                <label for="top-page-tagline">Tagline:</label>
                <input type="text" id="top-page-tagline" name="top-tagline"
                    value="{{ $contents['top-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview1">

                    @if (!empty($contents['top-background']->value))
                    <img src="{{ asset('storage/' . $contents['top-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif

                </div>
                <input class="imageUpload" type="file" id="imageUpload" name="top-background" accept="image/*"
                    data-preview="preview1" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Top Page Section -->

        <br />

        <!-- Facility Section -->
        <h4>Facility Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="home">
            <div class="form-group">
                <label for="facility-title">Title:</label>
                <input type="text" id="facility-title" name="facility-title"
                    value="{{ $contents['facility-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="facility-tagline">Tagline:</label>
                <input type="text" id="facility-tagline" name="facility-tagline"
                    value="{{ $contents['facility-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- Facility Section -->

        <br />

        <!-- Academy Section -->
        <h4>Academy Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="home">
            <div class="form-group">
                <label for="academy-title">Title:</label>
                <input type="text" id="academy-title" name="academies-title"
                    value="{{ $contents['academies-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="academy-headline">Headline:</label>
                <input type="text" id="academy-headline" name="academies-headline"
                    value="{{ $contents['academies-headline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="academy-tagline">Tagline:</label>
                <input type="text" id="academy-tagline" name="academies-tagline"
                    value="{{ $contents['academies-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="academy-academies">Benefits:</label>
                <div class="academies-container">
                    @php
                    // Decode the JSON value if it exists, otherwise set it as an empty array
                    $benefits = isset($contents['academies-benefits']) ?
                    json_decode($contents['academies-benefits']->value,
                    true) : [];
                    @endphp

                    {{-- Loop through existing benefits or show empty inputs --}}
                    @if(!empty($benefits))
                    @foreach($benefits as $benefit)
                    <input type="text" id="academies-benefits" name="academies-benefits[]" value="{{ $benefit }}"
                        placeholder="Input Here" required />
                    @endforeach
                    @else
                    {{-- If no benefits are stored, display 4 empty input fields --}}
                    @for($i = 0; $i
                    < 4; $i++) <input type="text" id="academies-benefits" name="academies-benefits[]"
                        placeholder="Input Here" required />
                    @endfor
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview2">
                    @if (!empty($contents['academies-background']->value))
                    <img src="{{ asset('storage/' . $contents['academies-background']->value) }}" alt="academy-img">
                    @else
                    <span>No image selected</span>
                    @endif

                </div>
                <input class="imageUpload" type="file" id="imageUpload" name="academies-background" accept="image/*"
                    data-preview="preview2" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- Academy Section -->

        <br />

        <!-- Articles Section -->
        <h4>Articles Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="home">
            <div class="form-group">
                <label for="article-title">Title:</label>
                <input type="text" id="article-title" name="homearticle-title"
                    value="{{ $contents['homearticle-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- Academy Section -->

        <br />

        <!-- About Section -->
        <h4>About Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="home">
            <div class="form-group">
                <label for="about-title">Title:</label>
                <input type="text" id="about-title" name="homeabout-title"
                    value="{{ $contents['homeabout-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="about-headline">Headline:</label>
                <input type="text" id="about-headline" name="homeabout-headline"
                    value="{{ $contents['homeabout-headline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="about-tagline">Tagline:</label>
                <input type="text" id="about-tagline" name="homeabout-tagline"
                    value="{{ $contents['homeabout-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview3">
                    @if (!empty($contents['homeabout-background']->value))
                    <img src="{{ asset($contents['homeabout-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif
                </div>
                <input class="imageUpload" type="file" id="imageUpload" name="homeabout-background" accept="image/*"
                    data-preview="preview3" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- About Section -->
    </div>
</div>
<!-- Home Content -->
<!-- Image Select -->
<script>
    document.querySelectorAll(".imageUpload").forEach((imageUpload) => {
  imageUpload.addEventListener("change", function () {
    const file = this.files[0];
    const previewId = this.getAttribute("data-preview");
    const imagePreview = document.getElementById(previewId);

    // Check if the preview container exists
    if (!imagePreview) {
      console.error(`Preview container with ID "${previewId}" not found.`);
      return;
    }

    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        imagePreview.innerHTML = `<img src="${event.target.result}" alt="Preview Image">`;
      };
      reader.readAsDataURL(file);
    } else {
      imagePreview.innerHTML = `<span>No image selected</span>`;
    }
  });
});

</script>
@endsection