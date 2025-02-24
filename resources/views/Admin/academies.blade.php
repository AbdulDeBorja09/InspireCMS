@extends('admin.layouts.app')
@section('content')
<!-- Academies Content -->
<div class="content" id="academies">
    <h1>Academies</h1>
    <p>Manage academy details.</p>

    <div class="form-container">
        <!-- Add Academies -->
        <h4>Add Academies</h4>
        <form action="{{route('admin.CreateService')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="form-control " type="hidden" id="Academies-name" name="type" value="Academy" />
            <div class="form-group">
                <label for="Academies-name">Name:</label>
                <input class="form-control " type="text" id="Academies-name" name="name" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="Academies-brief">Brief Description.:</label>
                <input class="form-control " type="text" id="Academies-brief" name="brief" placeholder="Input Here" />
            </div>
            <div class="form-group">
                <label for="Academies-description">Course Description:</label>
                <textarea class="form-control " type="text" id="Academies-description" name="description"
                    placeholder="Input Here" rows="5"> </textarea>
            </div>
            {{-- <div class="form-group">
                <label for="Academies-rate">Academies Rate:</label>
                <input class="form-control" type="text" id="Academies-rate" name="Academies" placeholder="Input Here" />
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
                    <label for="rate-type">Course Type:</label>
                    <input id="rate-type" type="text" name="rate_type[]" class="form-control mb-2"
                        placeholder="Rate Type" required>
                    <label for="rate">Course Rate:</label>
                    <input id="rate" type="number" name="rate[]" class="form-control mb-2" placeholder="Rate"
                        step="0.01" required>
                    <label for="unit">Inclusions:</label>
                    <textarea name="inclusions[]" id="inclusions" class="form-control mb-2" rows="5"
                        placeholder="Inclusions (optional)"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" id="add-rate">Add Another Rate</button>

            <div class="btn-container">
                <button class="text-center btn" type="submit">
                    Add Academies
                </button>
            </div>
        </form>
        <!-- Add Academies -->

        <br />

        <!-- Table -->
        <h4>Academies Table</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                    <tr>
                        <th class="text-center" style="width: 3%">#</th>
                        <th>Name</th>
                        <th>Brief Description</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 20%">Actions</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($academies as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{$index + 1}}
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->brief}}</td>
                        <td class="text-center">
                            @if ($item->status == 1)
                            <span class="badge badge-success" style="background-color: #064e3b">Available</span>
                            @else
                            <span class="badge badge-danger" style="background-color:red;">Unavailable</span>
                            @endif

                        </td>
                        <td class="text-center">
                            <a class="edit-btn" style="text-decoration:none"
                                href="{{url('/Admin/edit/'.$item->id)}}">View</a>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    @endforeach
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
        const rateRow = document.createElement('div');
        rateRow.classList.add('rate-row', 'mb-3');
        rateRow.innerHTML = `
            <hr/>
            <div class="rate-row mb-3">
                    <label for="rate-type">Course Type:</label>
                    <input id="rate-type" type="text" name="rate_type[]" class="form-control mb-2"
                        placeholder="Rate Type" required>
                    <label for="rate">Course Rate:</label>
                    <input id="rate" type="number" name="rate[]" class="form-control mb-2" placeholder="Rate"
                        step="0.01" required>
                    <label for="unit">Inclusions:</label>
                    <textarea name="inclusions[]" id="inclusions" class="form-control mb-2" rows="5"
                        placeholder="Inclusions (optional)"></textarea>
            </div>
             <button type="button" class="btn btn-danger remove-rate" style="background-color: #f44336;">Remove</button>
        `;

        container.appendChild(rateRow);

        // Attach event listener to the newly added remove button
        rateRow.querySelector('.remove-rate').addEventListener('click', function() {
            rateRow.remove();
        });
    });
</script>
@endsection