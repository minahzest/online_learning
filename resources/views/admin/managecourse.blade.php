@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">

            @php
                $urlSegments = explode('/', url()->current());
                $lastTwoSegments = array_slice($urlSegments, -2);
                $final_url = implode('/', $lastTwoSegments);
            @endphp

            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link @if($final_url=='admin/dashboard') active @endif" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link @if($final_url=='admin/course') active @endif" href="{{ route('admin.course') }}">Manage Courses</a>
                <a class="nav-link @if($final_url=='admin/student') active @endif" href="{{ route('admin.student') }}">Manage Students</a>
            </div>

        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><h4 class="d-inline-block font-weight-bold">{{ __('Manage Courses') }}</h4>
                    <button class="btn btn-success float-md-right" id="add_course">+ Add Course</button>
                </div>
                <div class="card-body">
                    {{ __('Courses Currently active for atudents to enroll!') }}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Course Description</th>
                                    <th scope="col">Enrolled Date</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach($courses as $course)
                                    <tr id="cour_row_{{ $course->id }}">
                                        <th scope="row">{{ $count }}</th>
                                        <td id="cour_name_{{ $course->id }}">{{ $course->course_name }}</td>
                                        <td id="cour_code_{{ $course->id }}">{{ $course->course_code }}</td>
                                        <td id="cour_desc_{{ $course->id }}">{{ $course->course_description }}</td>
                                        <td>{{ $course->created_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-secondary update_cour" id="update_cour" data-whatever="{{ $course->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"></path>
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn btn-danger delete_cour" id="delete_cour" data-whatever="{{ $course->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                    @endforeach
                                    @if(!count($courses))
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('There is Courses you have enrolled') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!--modal-->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="course_form">
          <input type="hidden" class="form-control" id="course_id" name="course_id" value="0">
            <div class="form-group">
            <label for="course_name" class="col-form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Enter Course Name" required>
          </div>  
            <div class="form-group">
            <label for="course_code" class="col-form-label">Course Code</label>
            <input type="text" class="form-control" id="course_code" name="course_code" placeholder="Enter Course Code" required>
          </div>
          <div class="form-group">
            <label for="course_description" class="col-form-label">Course Description</label>
            <textarea class="form-control" id="course_description" name="course_description" placeholder="Enter Course Description" required></textarea>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="cour-form-submit" class="btn btn-primary submit">Update Course</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="course_delete_id" id="course_delete_id" value="0">
        <span class="pb-3" id="delete_msg"></span><br><br>
        <span style="color: red;">*Note</span>
        <p>You cant delete course that are already enrolled my students</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="delete_course" class="btn btn-danger">Yes Delete</button>
      </div>
    </div>
  </div>
</div>


<script>
    var csrfToken = '{{ csrf_token() }}';
</script>
<script>
    $('.update_cour').on('click', function (event) {
        var button = $(this);
        var recipient = button.data('whatever');

        var modal = $(this)
        $('#course_id').val(recipient)
        $('#course_name').val($('#cour_name_'+recipient).text());
        $('#course_code').val($('#cour_code_'+recipient).text());
        $('#course_description').val($('#cour_desc_'+recipient).text());
        
        $('#courseModal').modal('show');
    });
    
    $('#course_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "POST",
            url: "{{ route('update.courses') }}",
            data: $('#course_form').serialize(),
                success: function(response) {
                console.log('Response:', response);
                // alert(response);
                if (response.status == 'success') {
                    toastr["success"](response.data);
                    location.reload();
                    
                }else{
                    toastr["error"](response.data);

                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>
<script>
    $('.delete_cour').on('click', function (event) {
        var button = $(this);
        var recipient = button.data('whatever');

        var modal = $(this)
        $('#course_delete_id').val(recipient)
        $('#delete_msg').html('Do you want delete <strong>'+$('#cour_name_'+recipient).text()+'</strong> course');
        $('#deleteModal').modal('show');
    });
</script>
<script>
    $('#delete_course').on('click', function (event) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "POST",
            url: "{{ route('deleted.courses') }}",
            data: 'course_id='+$('#course_delete_id').val(),
                success: function(response) {
                // console.log('Response:', response);
                // alert(response);
                if (response.status == 'success') {
                    toastr.success(response.data);
                    location.reload();
                    
                }else{
                    toastr.error(response.data);

                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>

<script>
    $('#add_course').on('click', function (e){  
        $('#course_id').val(0)
        $('#course_name').val('');
        $('#course_code').val('');
        $('#course_description').val('');
        
        $('#courseModal').modal('show');
    });
</script>
@endsection
