@extends('admin.layouts.app')
@section('content')
<!-- About Content -->
<div class="content" id="about">
    <h1>About</h1>
    <p>Manage about page content.</p>
    <div class="form-container">
        <!-- Header -->
        <h4>About Header</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="about">
            <div class="form-group">
                <label for="about-title">Title:</label>
                <input type="text" id="about-title" name="about-title"
                    value="{{ $contents['about-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="about-tagline">Tagline:</label>
                <input type="text" id="about-tagline" name="about-tagline"
                    value="{{ $contents['about-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview1">
                    @if (!empty($contents['about-background']->value))
                    <img src="{{ asset('storage/' . $contents['about-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif
                </div>
                <input class="imageUpload" data-preview="preview1" type="file" id="imageUpload" name="about-background"
                    accept="image/*" value="{{ $contents['about-background']->value ?? ''}}" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- Header -->

        <br />

        <!-- About Section -->
        <h4>About Section</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="about">
            <div class="form-group">
                <label for="aboutus-title">Title:</label>
                <input type="text" id="aboutus-title" name="aboutus-title"
                    value="{{ $contents['aboutus-title']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="aboutus-headline">Headline:</label>
                <input type="text" id="aboutus-headline" name="aboutus-headline"
                    value="{{ $contents['aboutus-headline']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="aboutus-about">About:</label>
                <input type="text" id="about-aboutus" name="aboutus-about"
                    value="{{ $contents['aboutus-about']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="aboutus-contact">Contact:</label>
                <input type="text" id="aboutus-contact" name="aboutus-contact"
                    value="{{ $contents['aboutus-contact']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="aboutus-Mission">Mission:</label>
                <input type="text" id="aboutus-Mission" name="aboutus-mission"
                    value="{{ $contents['aboutus-mission']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="aboutus-Vision">Vision:</label>
                <input type="text" id="aboutus-Vision" name="aboutus-vision"
                    value="{{ $contents['aboutus-vision']->value ?? ''}}" required placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="imageUpload">About Image:</label>
                <div class="image-preview" id="preview2">
                    @if (!empty($contents['aboutus-background']->value))
                    <img src="{{ asset('storage/' . $contents['aboutus-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif
                </div>
                <input class="imageUpload" data-preview="preview2" type="file" id="imageUpload"
                    name="aboutus-background" accept="image/*"
                    value="{{ $contents['aboutus-background']->value ?? ''}}" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- About Section -->

        <br />

        <!-- Partners Section -->
        <h4>Partners Section</h4>
        <form action="{{route('admin.CreatePartners')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="about-title">Partner Name:</label>
                <input type="text" id="about-title" name="name" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="imageUpload">Partner Logo:</label>
                <div class="image-preview" id="preview3">
                    <span>No image selected</span>
                </div>
                <input class="imageUpload" data-preview="preview3" type="file" id="imageUpload" name="image"
                    accept="image/*" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>


        <br />

        <!-- Teams Section -->
        <h4>Teams Section</h4>
        <form action="{{route('admin.Createteam')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="about-title">Full Name:</label>
                <input type="text" id="about-title" name="name" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview4">
                    <span>No image selected</span>
                </div>
                <input class="imageUpload" data-preview="preview4" type="file" id="imageUpload" name="image"
                    accept="image/*" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <br />

        <!-- About Section -->
    </div>
</div>
<!-- Image Select Script-->
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