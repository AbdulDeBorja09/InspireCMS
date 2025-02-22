@extends('admin.layouts.app')
@section('content')
@include('Admin.components.alert')
<!-- Facilities Content -->
<div class="content" id="facilities">
    <h1>Manage Services</h1>
    <p>Edit Service details.</p>

    <div class="form-container">
        <!-- Add Facility -->
        <h4>Edit Details</h4>
        <form action="{{route('admin.CreateService')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="form-control " type="hidden" id="facility-name" name="type" value="facility" />
            <div class="form-group">
                <label for="facility-name"> Name:</label>
                <input class="form-control " type="text" id="facility-name" value="{{$service->name}}" name="name"
                    placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="facility-brief">Brief Description.:</label>
                <input class="form-control " type="text" id="facility-brief" name="brief" value="{{$service->brief}}"
                    placeholder="Input Here" required />
            </div>
            <div class="form-group">
                <label for="facility-description">Facility Description:</label>
                <textarea class="form-control " type="text" id="facility-description" name="description"
                    placeholder="Input Here" rows="5">{{$service->description}}</textarea>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="imageUpload">Image 1:</label>
                        <div class="image-preview" id="preview1">
                            @if (!empty($service->image1))
                            <img src="{{ asset('storage/' . $service->image1) }}" alt="academy-img">
                            @else
                            <span>No image selected</span>
                            @endif

                        </div>
                        <input class="imageUpload" type="file" id="imageUpload" name="image1" accept="image/*"
                            data-preview="preview1" />
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="imageUpload">Image 2:</label>
                        <div class="image-preview" id="preview1">
                            @if (!empty($service->image2))
                            <img src="{{ asset('storage/' . $service->image2) }}" alt="academy-img">
                            @else
                            <span>No image selected</span>
                            @endif

                        </div>
                        <input class="imageUpload" type="file" id="imageUpload" name="image2" accept="image/*"
                            data-preview="preview2" />
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="imageUpload">Image 3:</label>
                        <div class="image-preview" id="preview3">
                            @if (!empty($service->image3))
                            <img src="{{ asset('storage/' . $service->image3) }}" alt="academy-img">
                            @else
                            <span>No image selected</span>
                            @endif

                        </div>
                        <input class="imageUpload" type="file" id="imageUpload" name="image3" accept="image/*"
                            data-preview="preview3" />
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                        <label for="imageUpload">Image 4:</label>
                        <div class="image-preview" id="preview3">
                            @if (!empty($service->image4))
                            <img src="{{ asset('storage/' . $service->image4) }}" alt="academy-img">
                            @else
                            <span>No image selected</span>
                            @endif

                        </div>
                        <input class="imageUpload" type="file" id="imageUpload" name="image4" accept="image/*"
                            data-preview="preview4" />
                    </div>
                </div>
            </div>


            {{-- <div id="rates-container">
                <div class="rate-row mb-3">
                    <label for="rate-type">Rate Type:</label>
                    <input id="rate-type" type="text" name="rate_type[]" class="form-control mb-2"
                        placeholder="Rate Type" required>
                    <label for="rate">Facility Rate:</label>
                    <input id="rate" type="number" name="rate[]" class="form-control mb-2" placeholder="Rate"
                        step="0.01" required>
                    <label for="unit">Rate Unit:</label>

                    <select id="unit" name="unit[]" class="form-control mb-2">
                        <option value="Per Head">Per Head</option>
                        <option value="Per Hour">Per Hour</option>
                        <option value="Per Hour & Per Court">Per Hour & Per Court</option>
                    </select>
                    <label for="unit">Hours:</label>
                    <input type="number" id="hour" name="hour[]" class="form-control mb-2"
                        placeholder="hour (e.g., 1,2,3)" value="1" required>
                    <label for="unit">Inclusions:</label>
                    <textarea name="inclusions[]" id="inclusions" class="form-control mb-2" rows="5"
                        placeholder="Inclusions (optional)"></textarea>
                </div>

            </div> --}}


            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Save Edit
                </button>
            </div>
        </form>
        <!-- Add Facility -->

        <br />

        <!-- Table -->
        <h4>{{$service->name}} Rates</h4>
        <div class="btn-container">
            <button type="button" class="btn btn-secondary mb-3" id="add-rate">Add Another Rate</button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 3%">#</th>
                        <th>Rate Type</th>
                        <th>Rate</th>
                        @if ($service->type === 'facility')
                        <th class="text-center">Unit</th>
                        <th class="text-center">Hours</th>
                        @endif
                        <th>Inclusions</th>
                        <th class="text-center" style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rates as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{$index + 1}}
                        </td>
                        <td>{{$item->rate_type}}</td>
                        <td>{{$item->rate}}</td>
                        @if ($service->type === 'facility')
                        <td class="text-center">
                            {{$item->unit}}

                        </td>
                        <td class="text-center">{{$item->hour}}</td>
                        @endif
                        <td>{{$item->inclusions}}</td>
                        <td class="text-center">
                            <a class="edit-btn" style="text-decoration:none">Edit</a>
                            <button class="delete-btn" onclick="confirmDelete({{$item->id}})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table -->
    </div>
</div>
<div class="modal fade" id="deleteRate" tabindex="-1" aria-labelledby="deleteRateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteFAQForm" method="POST" action="{{ route('admin.DeletRate') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletearticle">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="deleteRateLabel"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Rate?
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
    function confirmDelete(RateID) {
            // Set the FAQ ID in the hidden input field
        document.getElementById('deletearticleID').value = RateID;

        // Show the delete confirmation modal
        let modal = new bootstrap.Modal(document.getElementById('deleteRate'));
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
    document.getElementById('add-rate').addEventListener('click', function() {
        const container = document.getElementById('rates-container');
        const rateRow = document.createElement('div');
        rateRow.classList.add('rate-row', 'mb-3');
        rateRow.innerHTML = `
            <hr/>
            <div>
                <label for="rate-type">Rate Type:</label>
                <input type="text" name="rate_type[]" class="form-control mb-2" placeholder="Rate Type" required>
                
                <label for="rate">Facility Rate:</label>
                <input type="number" name="rate[]" class="form-control mb-2" placeholder="Rate" step="0.01" required>
                
                <label for="unit">Rate Unit:</label>
                <select name="unit[]" class="form-control mb-2">
                    <option value="Per Head">Per Head</option>
                    <option value="Per Hour">Per Hour</option>
                    <option value="Per Hour & Per Court">Per Hour & Per Court</option>
                </select>
                
                <label for="hour">Hours:</label>
                <input type="number" name="hour[]" class="form-control mb-2" placeholder="hour (e.g., 1,2,3)" value="1" required>
                
                <label for="inclusions">Inclusions:</label>
                <textarea name="inclusions[]" class="form-control mb-2" rows="5" placeholder="Inclusions (optional)"></textarea>
                
                <button type="button" class="btn btn-danger remove-rate" style="background-color: #f44336;">Remove</button>
            </div>
        `;

        container.appendChild(rateRow);

        // Attach event listener to the newly added remove button
        rateRow.querySelector('.remove-rate').addEventListener('click', function() {
            rateRow.remove();
        });
    });
</script>

@endsection