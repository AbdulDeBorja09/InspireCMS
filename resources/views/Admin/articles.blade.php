@extends('Admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<!-- Articles Content -->
<div class="content" id="Articles">
    <h1>Articles</h1>
    <p>Manage articles details.</p>

    <div class="form-container">
        <!-- Add articles -->
        <h4>Add articles</h4>
        <form action="{{route('admin.CreateArticle')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">

                <label for="articles-name">Article Title:</label>
                <input type="text" id="articles-name" name="title" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="articles-description">Article Author:</label>
                <input type="text" id="articles-description" name="author" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="articles-rate">Article Date:</label>
                <input type="date" id="articles-rate" name="date" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="option">Redirect Option:</label>
                <select name="redirect" id="option">
                    <option value="0" id="internal" selected>Internal</option>
                    <option value="1" id="external">External</option>
                </select>
            </div>
            <div class="ref-container " id="refcontainer" style="display: block;">
                <div class=" form-group">
                    <label for="articles-ur1">Article Reference URL:</label>
                    <input type="text" id="articles-url1" name="url1" placeholder="Input Here" />
                </div>
                <div class="form-group">
                    <label for="articles-url2">Article Reference URL:</label>
                    <input type="text" id="articles-url2" name="url2" placeholder="Input Here" />
                </div>
                <div class="form-group">
                    <label for="articles-url3">Article Reference URL:</label>
                    <input type="text" id="articles-url3" name="url3" placeholder="Input Here" />
                </div>
                <div class="form-group">
                    <label for="articles-url4">Article Reference URL:</label>
                    <input type="text" id="articles-url4" name="url4" placeholder="Input Here" />
                </div>

            </div>

            <div class="url-container" id="urlcontainer" style="display: none;">
                <div class="form-group">
                    <label for="articles-url1">URL:</label>
                    <input type="text" id="articles-url1" name="redirect_url" placeholder="Input Here" />
                </div>
            </div>
            <div class="form-group">
                <label for="articles-desc">Article Description:</label>
                <textarea name="description" id="articles-desc" cols="30" rows="7" placeholder="Input Here"></textarea>
            </div>

            <div class="form-group">
                <label for="imageUpload">Article Cover:</label>
                <div class="image-preview" id="preview2">
                    <span>No image selected</span>
                </div>
                <input class="imageUpload" data-preview="preview2" type="file" id="imageUpload" name="image"
                    accept="image/*" required />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">Add article</button>
            </div>
        </form>


        <!-- Add Articles -->

        <br />

        <!-- Table -->
        <h4>articles Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Action</th>
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $index =>$article)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>
                            <img src="{{asset('/storage/'. $article->image)}}" alt="{{$article->title}}" />
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->author}}</td>
                        <td>{{ \Carbon\Carbon::parse($article->date)->format('F j, Y') }}</td>
                        <td>
                            <button class="edit-btn" onclick="editArticle({{ $article }})">Edit</button>
                            <button class="delete-btn" onclick="confirmDelete({{ $article->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>
<div class="modal fade" id="editArticle" tabindex="-1" aria-labelledby="editArticleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editArtilcform" method="POST" action="{{route('admin.editarticle')}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editArticleLabel">Edit Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="articleid">

                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">Title</label>
                        <input type="text" class="form-control" id="articletitle" name="title" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            <div class="mb-3">
                                <label for="faqAnswer" class="form-label">author</label>
                                <input type="text" class="form-control" id="articleauthor" name="author" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-6">
                            <div class="mb-3">
                                <label for="faqAnswer" class="form-label">Date</label>
                                <input type="date" class="form-control" id="articledate" name="date" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-6">
                            <div class="mb-3">
                                <label for="option">Redirect Option:</label>
                                <select class="form-control" name="redirect" id="articleoption">
                                    <option value="0">Internal</option>
                                    <option value="1">External</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="modalurlcontainer" style="display: none;">
                        <label for="faqAnswer" class="form-label">Redirect URL</label>
                        <input type="text" class="form-control" id="redirecturl" name="redirect_url" required>
                    </div>
                    <div id="modalrefcontainer" style="display: block;">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="faqAnswer" class="form-label">Reference URL1</label>
                                    <input type="text" class="form-control" id="articleurl1" name="url1">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="faqAnswer" class="form-label">Reference URL2</label>
                                    <input type="text" class="form-control" id="articleurl2" name="url2">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="faqAnswer" class="form-label">Reference URL3</label>
                                    <input type="text" class="form-control" id="articleurl3" name="url3">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="faqAnswer" class="form-label">Reference URL4</label>
                                    <input type="text" class="form-control" id="articleurl4" name="url4">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Description:</label>
                        <textarea type="file" class="form-control" id="articledescription" name="description"
                            rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="articleimage" name="image">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticlelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteFAQForm" method="POST" action="{{ route('admin.DelereArticle') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletearticle">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this FAQ?
                    <input type="hidden" name="id" id="deletearticleID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function editArticle(article) {
   
        document.getElementById('articleid').value = article.id;
        document.getElementById('articletitle').value = article.title;
        document.getElementById('articledate').value = article.date;
        document.getElementById('articleauthor').value = article.author;
        document.getElementById('redirecturl').value = article.redirect_url;
        document.getElementById('articleurl1').value = article.url1;
        document.getElementById('articleurl2').value = article.url2;
        document.getElementById('articleurl3').value = article.url3;
        document.getElementById('articleurl4').value = article.url4;
        document.getElementById('articleoption').value = article.redirect;
        document.getElementById('articledescription').value = article.description;
        // Show the modal
        let modal = new bootstrap.Modal(document.getElementById('editArticle'));
        modal.show();
    }

    
    function confirmDelete(ArticleId) {
            // Set the FAQ ID in the hidden input field
        document.getElementById('deletearticleID').value = ArticleId;

        // Show the delete confirmation modal
        let modal = new bootstrap.Modal(document.getElementById('deleteArticleModal'));
        modal.show();

    }
</script>
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
    // Grab elements
    const Dropdown = document.getElementById('option');
    const Refcontainer = document.getElementById('refcontainer');
    const Urlcontainer = document.getElementById('urlcontainer');

    // Function to clear inputs in a container
    function clearInputs(container) {
        const inputs = container.querySelectorAll('input');
        inputs.forEach(input => input.value = ""); // Clear each input value
    }

    // Function to toggle visibility and clear inputs
    function changeoption() {
        const value = Dropdown.value; // Get selected value

        if (value === "0") { // Internal selected
            Refcontainer.style.display = "block"; // Show Refcontainer
            Urlcontainer.style.display = "none";  // Hide Urlcontainer
            clearInputs(Urlcontainer); // Clear inputs in Urlcontainer
        } else { // External selected
            Refcontainer.style.display = "none";  // Hide Refcontainer
            Urlcontainer.style.display = "block"; // Show Urlcontainer
            clearInputs(Refcontainer); // Clear inputs in Refcontainer
        }
    }

    // Attach event listener to dropdown
    Dropdown.addEventListener('change', changeoption);

    // Initialize visibility on page load
    changeoption();
</script>

<script>
    // Grab elements
    const ArticleDropdown = document.getElementById('articleoption');
    const ModalRefContainer = document.getElementById('modalrefcontainer');
    const ModalUrlContainer = document.getElementById('modalurlcontainer');

    // Function to clear inputs in a container
    function clearInputs(container) {
        const inputs = container.querySelectorAll('input');
        inputs.forEach(input => input.value = ""); // Clear each input value
    }

    // Function to toggle visibility and clear inputs
    function handleArticleOptionChange() {
        const value = ArticleDropdown.value; // Get selected value

        if (value === "0") { // Internal selected
            ModalRefContainer.style.display = "block"; // Show ModalRefContainer
            ModalUrlContainer.style.display = "none";  // Hide ModalUrlContainer
            clearInputs(ModalUrlContainer); // Clear inputs in ModalUrlContainer
        } else { // External selected
            ModalRefContainer.style.display = "none";  // Hide ModalRefContainer
            ModalUrlContainer.style.display = "block"; // Show ModalUrlContainer
            clearInputs(ModalRefContainer); // Clear inputs in ModalRefContainer
        }
    }

    // Attach event listener to dropdown
    ArticleDropdown.addEventListener('change', handleArticleOptionChange);

    // Initialize visibility on page load
    handleArticleOptionChange();
</script>

@endsection