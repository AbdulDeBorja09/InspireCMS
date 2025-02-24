@extends('admin.layouts.app')
@section('content')
<!-- faq Content -->
@include('Admin.components.alert')
<div class="content" id="faq">
    <h1>FAQ</h1>
    <p>Manage FAQ details.</p>

    <div class="form-container">
        <!-- Add faq -->
        <h4>Add FAQ Category</h4>
        <form action="{{route('admin.CreateFaqCategory')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="faq-name">Category Name:</label>
                <input type="text" id="faq-name" name="name" placeholder="Input Here" />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">Add Category</button>
            </div>
        </form>
        <h4>Add FAQ Question</h4>
        <form action="{{route('admin.CreateFaqQuestions')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="faq-category">Category Name:</label>
                <select name="category_id" required>
                    @if(isset($categories) && $categories->isNotEmpty())
                    @foreach($categories as $category)

                    <option value="{{$category->id}}">{{$category->name}}</option>

                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="faq-question">Faq Question:</label>
                <input type="text" id="faq-name" name="question" placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="faq-question">Faq Answer:</label>
                <input type="text" id="faq-name" name="answer" placeholder="Input Here" required />
            </div>
            <div class="btn-container">
                <button class="text-center btn" type="submit">Add Question</button>
            </div>
        </form>

        <!-- Add faq -->

        <br />

        <!-- Table -->
        <h4>FAQs Questions</h4>
        <div class="table-container">
            <table>
                <thead>

                    <tr>
                        <th class="text-center">#</th>
                        <th>Category</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($faqs as $index => $faq)
                    <tr>
                        <td class="text-center" style="width: 5%">{{ $index + 1}}</td>
                        <td>{{$faq->category->name}}</td>
                        <td>{{$faq->question}}</td>
                        <td>{{$faq->answer}}</td>
                        <td class="text-center" style="width:20%">
                            <button class="edit-btn" onclick="editFAQ({{ $faq }})">Edit</button>
                            <button class="delete-btn" onclick="confirmDelete({{ $faq->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>
<div class="modal fade" id="editFAQModal" tabindex="-1" aria-labelledby="editFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editFAQForm" method="POST" action="{{ route('admin.editfaqs') }}">

            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editfaqid">

                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">Question</label>
                        <input type="text" class="form-control" id="faqQuestion" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Answer</label>
                        <textarea class="form-control" id="faqAnswer" name="answer" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="faqCategory" class="form-label">Category</label>
                        <select class="form-control" id="faqCategory" name="category_id" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
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
<div class="modal fade" id="deleteFAQModal" tabindex="-1" aria-labelledby="deleteFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteFAQForm" method="POST" action="{{ route('admin.deletefaqs') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFAQModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this FAQ?
                    <input type="hidden" name="id" id="deleteFAQId">
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
    function editFAQ(faq) {
        document.getElementById('editfaqid').value = faq.id;
        document.getElementById('faqQuestion').value = faq.question;
        document.getElementById('faqAnswer').value = faq.answer;
        document.getElementById('faqCategory').value = faq.category_id;

        // Show the modal
        let modal = new bootstrap.Modal(document.getElementById('editFAQModal'));
        modal.show();
    }

    function confirmDelete(faqId) {
        // Set the FAQ ID in the hidden input field
        document.getElementById('deleteFAQId').value = faqId;

        // Show the delete confirmation modal
        let modal = new bootstrap.Modal(document.getElementById('deleteFAQModal'));
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
@endsection