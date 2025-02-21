@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<!-- Facilities Content -->
<div class="content" id="facilities">
    <h1>Facilities</h1>
    <p>Manage facilities details.</p>

    <div class="form-container">
        <!-- Header -->
        <h4>Facility Header</h4>
        <form action="{{route('admin.CreateOrUpdateContent')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="facilities">
            <div class="form-group">
                <label for="facility-title">Title:</label>
                <input type="text" id="facility-title" name="facilities-title"
                    value="{{ $contents['facilities-title']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="facility-tagline">Tagline:</label>
                <input type="text" id="facility-tagline" name="facilities-tagline"
                    value="{{ $contents['facilities-tagline']->value ?? ''}}" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="imageUpload">Background Image:</label>
                <div class="image-preview" id="preview1">
                    @if (!empty($contents['facilities-background']->value))
                    <img src="{{ asset('storage/' . $contents['facilities-background']->value) }}" alt="Top-page-img">
                    @else
                    <span>No image selected</span>
                    @endif
                </div>
                <input class="imageUpload" data-preview="preview1" type="file" id="imageUpload"
                    name="facilities-background" value="{{ $contents['facilities-background']->value ?? ''}}"
                    accept="image/*" />
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
        <h4>Add Facility</h4>
        <form action="{{route('admin.CreateService')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="facility-name">Facility Type:</label>
                <input class="form-control " type="text" id="facility-name" name="type" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="facility-name">Facility Name:</label>
                <input class="form-control " type="text" id="facility-name" name="name" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="facility-description">Facility Description:</label>
                <input class="form-control " type="text" id="facility-description" name="description"
                    placeholder="Input Here" />
            </div>
            {{-- <div class="form-group">
                <label for="facility-rate">Facility Rate:</label>
                <input class="form-control" type="text" id="facility-rate" name="facility" placeholder="Input Here" />
            </div> --}}
            <div class="form-group">
                <label for="image1">Image:</label>
                <input class="form-control" name="image1" type="file" id="image1" accept="image/*" required />
            </div>
            <div class="form-group">
                <label for="image2">Image:</label>
                <input class="form-control" name="image2" type="file" id="image2" accept="image/*" required />
            </div>
            <div class="form-group">
                <label for="image3">Image:</label>
                <input class="form-control" name="image3" type="file" id="image3" accept="image/*" required />
            </div>
            <div class="form-group">
                <label for="image4">Image:</label>
                <input class="form-control" name="image4" type="file" id="image4" accept="image/*" required />
            </div>
            <div id="rates-container">
                <div class="rate-row mb-3">
                    <label for="rate-type">Rate Type:</label>
                    <input id="rate-type" type="text" name="rate_type[]" class="form-control mb-2"
                        placeholder="Rate Type (e.g., Individual Rate)" required>
                    <label for="rate">Facility Rate:</label>
                    <input id="rate" type="number" name="rate[]" class="form-control mb-2" placeholder="Rate (e.g., 50)"
                        step="0.01" required>
                    <label for="unit">Rate Unit:</label>
                    <input type="text" id="unit" name="unit[]" class="form-control mb-2"
                        placeholder="Unit (e.g., per head, per hour)">
                    <label for="unit">Inclusions:</label>
                    <textarea name="inclusions[]" id="inclusions" class="form-control mb-2" rows="5"
                        placeholder="Inclusions (optional)"></textarea>
                </div>

            </div>
            <button type="button" class="btn btn-secondary mb-3" id="add-rate">Add Another Rate</button>

            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Add Facility
                </button>
            </div>
        </form>
        <!-- Add Facility -->

        <br />

        <!-- Table -->
        <h4>Facility Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Facility Image</th>
                        <th>Facility Name</th>
                        <th>Facility Description</th>
                        <th>Facility Price</th>
                        <th>Actions</th>
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="images/facility/1.jpg" alt="Facility 1" />
                        </td>
                        <td>Basketball Court</td>
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
<script>
    document.getElementById('add-rate').addEventListener('click', function() {
        const container = document.getElementById('rates-container');
        const rateRow = `
        <hr/>
            <div class="rate-row mb-3">
                    <label for="rate-type">Rate Type:</label>
                    <input id="rate-type" type="text" name="rate_type[]" class="form-control mb-2"
                        placeholder="Rate Type (e.g., Individual Rate)" required>
                    <label for="rate">Facility Rate:</label>
                    <input id="rate" type="number" name="rate[]" class="form-control mb-2" placeholder="Rate (e.g., 50)"
                        step="0.01" required>
                    <label for="unit">Rate Unit:</label>
                    <input type="text" id="unit" name="unit[]" class="form-control mb-2"
                        placeholder="Unit (e.g., per head, per hour)">
                    <label for="unit">Inclusions:</label>
                    <textarea name="inclusions[]" id="inclusions" class="form-control mb-2" rows="5"
                    placeholder="Inclusions (optional)"></textarea>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rateRow);
    });
</script>
@endsection