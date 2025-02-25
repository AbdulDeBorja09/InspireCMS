@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<div class="content" id="settings">
    <h1>Settings</h1>
    <p>Manage your account settings.</p>

    <div class="form-container">
        <div class="row">
            <div class="col-lg-6">
                <h4>Security</h4>
                <form action="{{ route('admin.ChangePassword') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Enter old password:</label>
                        <input type="password" id="old_password" name="old_password" placeholder="Enter old password" />
                    </div>
                    <div class="form-group">
                        <label for="new_password">Enter new password:</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" />
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm password:</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            placeholder="Confirm password" />
                    </div>
                    <div class="btn-container">
                        <button class="text-center btn" type="submit">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <h4>Social Media</h4>
                <div class="form-group mt-3">
                    <label for="old_password">Tiktok</label>
                    <form style="padding: 0" action="{{route('admin.EditLayout')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $tiktok->id}}">
                        <input type="text" id="Tiktok" value="{{ $tiktok->value}}" name="value" class="w-100" />
                    </form>
                </div>
                <div class="form-group">
                    <label for="old_password">Facebook</label>
                    <form style="padding: 0" action="{{route('admin.EditLayout')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $facebook->id}}">
                        <input type="text" id="Facebook" value="{{ $facebook->value}}" name="value" class="w-100" />
                    </form>
                </div>
                <div class="form-group">
                    <label for="old_password">Instagram</label>
                    <form style="padding: 0" action="{{route('admin.EditLayout')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $instagram->id}}">
                        <input type="text" id="Facebook" value="{{ $instagram->value}}" name="value" class="w-100" s />
                    </form>
                </div>
            </div>
        </div>
        <h4>Manage Layout</h4>

        <div class="row">
            <div class="col-lg-6">
                <form action="{{route('admin.EditLayout')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="imageUpload">Navbar:</label>
                    <div class="image-preview" id="preview1">
                        <input type="hidden" name="id" value="{{$nav->id}}">
                        @if (!empty($nav->value))
                        <img src="{{ asset('storage/' . $nav->value) }}" alt="academy-img">
                        @else
                        <span>No image selected</span>
                        @endif

                    </div>
                    <input class="imageUpload w-100" type="file" id="imageUpload" name="value" accept="image/*"
                        data-preview="preview1" />
                    <button class="text-center btn mt-3" type="submit">
                        Update Navbar
                    </button>
                </form>
            </div>
            <div class="col-lg-6">
                <form action="{{route('admin.EditLayout')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="imageUpload">Footer:</label>
                    <div class="image-preview" id="preview2">
                        <input type="hidden" name="id" value="{{$footer->id}}">
                        @if (!empty($footer->value))
                        <img src="{{ asset('storage/' . $footer->value) }}" alt="academy-img">
                        @else
                        <span>No image selected</span>
                        @endif

                    </div>
                    <input class="imageUpload w-100" type="file" id="imageUpload" name="value" accept="image/*"
                        data-preview="preview2" />
                    <button class="text-center btn mt-3" type="submit">
                        Update Footer
                    </button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6">
                <h4>Contacts</h4>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Contacts</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contact as $index => $item)
                        <tr>

                            <td>{{$index + 1}}</td>
                            <td>
                                <form action="{{route('admin.EditLayout')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id}}">
                                    <input class="text-center" type="text" value="{{ $item->value}}" name="value"
                                        style="background-color: transparent; border:0; width: 90%">
                                </form>
                            </td>
                            <td><button class="delete-btn">Delete</button></td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <button class="text-center btn mt-3" onclick="NewContact()">
                    New Contact
                </button>
            </div>
            <div class="col-lg-6">
                <h4>Locations</h4>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Contacts</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($address as $index => $item)
                        <tr>
                            <input type="hidden" name="address_id" id="">
                            <td>{{$index + 1}}</td>
                            <td>
                                <form action="{{route('admin.EditLayout')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id}}">
                                    <input class="text-center" type="text" value="{{ $item->value}}" name="value"
                                        style="background-color: transparent; border:0; width: 90%">
                                </form>
                            </td>
                            <td>
                                <form action="{{route('admin.DeleteLayout')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id}}">
                                    <button class="delete-btn" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="text-center btn mt-3" onclick="NewLocation()">
                    New Location
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="NewContact" tabindex="-1" aria-labelledby="deleteServicelabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.NewLayout') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="deleteServicelabel"></button>
                </div>
                <div class="modal-body">
                    <label for="">New Contact</label>
                    <input type="hidden" name="key" value="contact">
                    <input type="text" class="w-100" name="value" id="deleteservice">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="NewLocation" tabindex="-1" aria-labelledby="deleteServicelabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.NewLayout') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="deleteServicelabel"></button>
                </div>
                <div class="modal-body">
                    <label for="">New Location</label>
                    <input type="hidden" name="key" value="location">
                    <input type="text" class="w-100" name="value" id="deleteservice">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function NewContact(SeriveId) {
        // document.getElementById('deleteservice').value = SeriveId;
        let modal = new bootstrap.Modal(document.getElementById('NewContact'));
        modal.show();

    }
    function NewLocation(SeriveId) {
        // document.getElementById('deleteservice').value = SeriveId;
        let modal = new bootstrap.Modal(document.getElementById('NewLocation'));
        modal.show();

    }

    
</script>

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