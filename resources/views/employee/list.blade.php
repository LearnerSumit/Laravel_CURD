<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LARAVEL CURD OPERATION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">LARAVEL CURD OPERATION</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees List</div>
            <div>
                <a href={{ route('employees.create') }} class="btn btn-primary">Create</a>
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>

        @elseif(Session::has('delete'))
            <div class="alert alert-danger">{{ Session::get('delete') }}</div>    
        @endif

        <div class="card shadow-sm board-0">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($employees->isNotEmpty())
                        @foreach($employees as $employee)
                            <tr>
                                <td> {{$employee->id}} </td>
                                <!-- Image Column -->
<td>
    @if($employee->image != "" && file_exists(public_path().'/upload/employees/' . $employee->image))
        <img src="{{ asset('upload/employees/' . $employee->image) }}" alt="{{ $employee->name }}" width="40" height="40" class="img-thumbnail " data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="{{ asset('upload/employees/' . $employee->image) }}" style="cursor: pointer">
    @else
        <img src="{{ asset('upload/employees/no_image.jpg') }}" alt="{{ $employee->name }}" width="40" height="40" class="img-thumbnail " data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="{{ asset('upload/employees/no_image.jpg') }}" style="cursor: pointer">
    @endif
</td>

                    <!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    <a href={{ route('employees.edit',$employee->id) }} class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" onclick="deleteEmploye({{$employee->id}})" class="btn btn-sm btn-danger">Delete</a>

                                    <form action="{{ route('employees.destroy',$employee->id) }}" method="POST" id="employee-edit-action-{{ $employee->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center h4">No records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>







    {{-- bootstrap js cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var imgSrc = button.getAttribute('data-bs-src'); // Extract info from data-bs-* attributes
                var modalImage = imageModal.querySelector('#modalImage');
    
                // Update the modal's content.
                modalImage.src = imgSrc;
            });
        });

        function deleteEmploye(id) {
            if(confirm('Are you sure you want to delete this record?')) {
                document.getElementById('employee-edit-action-'+id).submit();
            }
        }
    </script>
    
</body>
</html>