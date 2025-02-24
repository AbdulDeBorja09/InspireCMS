@extends('admin.layouts.app')
@section('content')
<!-- About Content -->
<div class="content" id="about">
    <h1>About</h1>
    <p>Manage about page content.</p>
    <div class="form-container">
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
                <textarea type="text" name="aboutus-mission" name="" id="aboutus-Mission" rows="5" required
                    placeholder="Input Here">{{ $contents['aboutus-mission']->value ?? ''}} </textarea>
            </div>
            <div class="form-group">
                <label for="aboutus-vision">Vision:</label>
                <textarea type="text" name="aboutus-vision" name="" id="aboutus-vision" rows="5" required
                    placeholder="Input Here">{{ $contents['aboutus-vision']->value ?? ''}} </textarea>
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

        <!-- Teams Section -->
        <h4>Teams Section</h4>
        <form action="{{route('admin.Createteam')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="about-title">Full Name:</label>
                <input type="text" id="about-title" name="name" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="about-position">Position:</label>
                <input type="text" id="about-position" name="position" placeholder="Input Here" />
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

        <!-- Table -->
        <h4>Teams Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Action</th>
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $index => $items)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>
                            <img class="mx-auto" src="{{asset('/storage/'. $items->image)}}"
                                alt="{{$items->title}}" />
                        </td>
                        <td>{{$items->name}}</td>
                        <td>{{$items->position}}</td>
                        <td style="width:20%">
                            <button class="edit-btn" onclick="editteam({{ $items }})">Edit</button>
                            <button class="delete-btn" onclick="deleteteam({{ $items->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
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

        <!-- Table -->
        <h4>Partners Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Action</th>
                        <!-- New column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $index => $items)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>
                            <img class="mx-auto" src="{{asset('/storage/'. $items->image)}}"
                                alt="{{$items->title}}" />
                        </td>
                        <td>{{$items->name}}</td>
                        <td style="width:20%">
                            <button class="edit-btn" onclick="editpartner({{ $items }})">Edit</button>
                            <button class="delete-btn" onclick="deletepartner({{ $items->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->

        <!-- About Section -->
    </div>
</div>
<div class="modal fade" id="editteammodal" tabindex="-1" aria-labelledby="editteammodallablel" aria-hidden="true">
    <div class="modal-dialog   modal-md">
        <form id="editPartnerForm" method="POST" action="{{ route('admin.editeam') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editteammodallablel">Edit Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="teameditid">

                    <div class="mb-3">
                        <label for="teameditname" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="teameditname" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="teamposition" class="form-label">Position:</label>
                        <input type="text" class="form-control" id="teamposition" name="position" required>
                    </div>

                    <div class="mb-3">
                        <label for="partnernimg" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="partnernimg" name="image">
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
<div class="modal fade" id="deleteteammodal" tabindex="-1" aria-labelledby="delteteamlabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteFAQForm" method="POST" action="{{ route('admin.deleteteam') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delteteamlabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Team member?
                    <input type="text" name="id" id="delteteamid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="editpartnermodal" tabindex="-1" aria-labelledby="editFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog   modal-md">
        <form id="editFAQForm" method="POST" action="{{ route('admin.editpartner') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Edit Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editpartnerid">

                    <div class="mb-3">
                        <label for="partnername" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="partnername" name="partnername" required>
                    </div>

                    <div class="mb-3">
                        <label for="partnernimg" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="partnernimg" name="image">
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
<div class="modal fade" id="deletepartnermodal" tabindex="-1" aria-labelledby="deletepartnerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteFAQForm" method="POST" action="{{ route('admin.deletepartner') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletepartnerLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Partner?
                    <input type="hidden" name="id" id="deletepartnerid">
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
    function editpartner(partner) {
        document.getElementById('editpartnerid').value = partner.id;
        document.getElementById('partnername').value = partner.name;
        // document.getElementById('partnernimg').value = partner.image;
       

        // Show the modal
        let modal = new bootstrap.Modal(document.getElementById('editpartnermodal'));
        modal.show();
    }

    function deletepartner(PartnerId) {
            // Set the FAQ ID in the hidden input field
        document.getElementById('deletepartnerid').value = PartnerId;

        // Show the delete confirmation modal
        let modal = new bootstrap.Modal(document.getElementById('deletepartnermodal'));
        modal.show();

    }


    function editteam(team) {
        document.getElementById('teameditid').value = team.id;
        document.getElementById('teameditname').value = team.name;
        document.getElementById('teamposition').value = team.position;

        // Show the modal
        let modal = new bootstrap.Modal(document.getElementById('editteammodal'));
        modal.show();
    }

    function deleteteam(teamdid) {
            // Set the FAQ ID in the hidden input field
        document.getElementById('delteteamid').value = teamdid;

        // Show the delete confirmation modal
        let modal = new bootstrap.Modal(document.getElementById('deleteteammodal'));
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