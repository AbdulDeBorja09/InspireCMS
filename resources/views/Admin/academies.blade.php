@extends('admin.layouts.app')
@section('content')
<!-- Academies Content -->
<div class="content" id="academies">
    <h1>Academies</h1>
    <p>Manage academy details.</p>

    <div class="form-container">
        <!-- Header -->
        <h4>Academy Header</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="academies">
            <div class="form-group">
                <label for="academy-title">Title:</label>
                <input type="text" id="academy-title" name="academy-title"
                    value="{{ $contents['academy-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="academy-tagline">Tagline:</label>
                <input type="text" id="academy-tagline" name="academy-tagline"
                    value="{{ $contents['academy-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview1">
                    @if (!empty($contents['academy-background']->value))
                    <img src="{{ asset('storage/' . $contents['academy-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif
                </div>
                <input class="imageUpload" data-preview="preview1" type="file" id="imageUpload"
                    name="academy-background" accept="image/*"
                    value="{{ $contents['academy-background']->value ?? ''}}" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Changes
                </button>
            </div>
        </form>
        <!-- Header -->

        <br />

        <!-- Add Facility -->
        <h4>Add Academy</h4>
        <form>
            <div class="form-group">
                <label for="academy-name">Academy Name:</label>
                <input type="text" id="academy-name" name="academy" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="academy-description">Academy Description:</label>
                <input type="text" id="academy-description" name="academy" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="academy-rate">Academy Rate:</label>
                <input type="text" id="academy-rate" name="academy" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="imagePreview">
                    <span>No image selected</span>
                </div>
                <input type="file" id="imageUpload" accept="image/*" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">Add Academy</button>
            </div>
        </form>
        <!-- Add Academy -->

        <br />

        <!-- Table -->
        <h4>Academy Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Academy Image</th>
                        <th>Academy Name</th>
                        <th>Academy Description</th>
                        <th>Academy Price</th>
                        <th>Actions</th>
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="images/facility/3.jpg" alt="Facility 1" />
                        </td>
                        <td>Basketball Academy</td>
                        <td>Indoor full-court basketball facility with seating.</td>
                        <td>$50 per hour</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Table -->
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