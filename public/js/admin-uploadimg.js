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