<div class="header-section">
  <h4>{{ ucfirst(str_replace('_', ' ', $section)) }} Header</h4>
  <form action="{{ route('admin.CreateOrUpdateContent') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="{{ $section }}">

    <div class="form-group">
      <label for="{{ $section }}-title">Title:</label>
      <input type="text" id="{{ $section }}-title" name="{{ $section }}-title"
        value="{{ $contents[$section . '-title'] ?? '' }}" placeholder="Input Here" required />
    </div>

    <div class="form-group">
      <label for="{{ $section }}-tagline">Tagline:</label>
      <input type="text" id="{{ $section }}-tagline" name="{{ $section }}-tagline"
        value="{{ $contents[$section . '-tagline'] ?? '' }}" placeholder="Input Here" required />
    </div>

    <div class="form-group">
      <label for="{{ $section }}-background">Background Image:</label>
      <div class="image-preview" id="preview-{{ $section }}">
        @if (!empty($contents[$section . '-background']))
        <img src="{{ asset('storage/' . $contents[$section . '-background']) }}" alt="{{ $section }}-img">
        @else
        <span>No image selected</span>
        @endif
      </div>
      <input class="imageUpload" data-preview="preview-{{ $section }}" type="file" id="{{ $section }}-background"
        name="{{ $section }}-background" accept="image/*" />
    </div>

    <div class="btn-container">
      <button class="text-center btn" type="submit">
        Save Changes
      </button>
    </div>
  </form>
</div>
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