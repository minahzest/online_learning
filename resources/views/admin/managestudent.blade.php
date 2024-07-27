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
                <div class="card-header"><h4 class="d-inline-block font-weight-bold">{{ __('Manage Student') }}</h4>
                    <button class="btn btn-success float-md-right" id="add_student">+ Add Student</button>
                </div>
                <div class="card-body">
                    {{ __('Students registed to this platform') }}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">Enrolled Date</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach($users as $user)
                                    <tr id="stud_row_{{ $user->id }}">
                                        <th scope="row">{{ $count }}</th>
                                        <td id="stud_name_{{ $user->id }}" data-first="{{ $user->f_name }}" data-last="{{ $user->l_name }}">{{ $user->f_name.' '.$user->l_name }}</td>
                                        <td id="stud_mail_{{ $user->id }}">{{ $user->email }}</td>
                                        <td id="stud_phone_{{ $user->id }}">{{ $user->phone }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-secondary update_stud" id="update_stud" data-whatever="{{ $user->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"></path>
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn btn-danger delete_stud" id="delete_stud" data-whatever="{{ $user->id }}">
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
                                    @if(!count($users))
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('There is no students registered') }}</td>
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
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="user_form">
          <input type="hidden" class="form-control" id="user_id" name="user_id" value="0">
          <input type="hidden" class="form-control" id="password" name="password" value="0">
            <div class="form-group">
                <label for="course_name" class="col-form-label">First Name</label>
                <input type="text" class="form-control" id="f_name" name="f_name" placeholder="Enter First Name" required>
                <span class="invalid-feedback f_name" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="form-group">
                <label for="course_name" class="col-form-label">Last Name</label>
                <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Enter Last Name" required>
                <span class="invalid-feedback l_name" role="alert">
                    <strong></strong>
                </span>
            </div>  
            <div class="form-group">
                <label for="course_code" class="col-form-label">Phone</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone" required>
                <span class="invalid-feedback phone" role="alert">
                    <strong></strong>
                </span>
            </div>
            <div class="form-group">
                <label for="course_code" class="col-form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
                <span class="invalid-feedback email" role="alert">
                    <strong></strong>
                </span>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="cour-form-submit" class="btn btn-primary submit">Submit Student</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user_delete_id" id="user_delete_id" value="0">
        <span class="pb-3" id="delete_msg"></span><br><br>
        <span style="color: red;">*Note</span>
        <p>You cant delete course that are already enrolled my students</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="delete_user" class="btn btn-danger">Yes Delete</button>
      </div>
    </div>
  </div>
</div>


<script>
    var csrfToken = '{{ csrf_token() }}';
</script>
<script>
    $('.update_stud').on('click', function (event) {
        var button = $(this);
        var recipient = button.data('whatever');

        var modal = $(this)
        $('#user_id').val(recipient)
        $('#exampleModalLabel').text('Updated Student');
        
        // alert($('#stud_name_'+recipient).data('first'));

        $('#f_name').val($('#stud_name_'+recipient).data('first'));
        $('#l_name').val($('#stud_name_'+recipient).data('last'));
        $('#email').val($('#stud_mail_'+recipient).text());
        $('#phone').val($('#stud_phone_'+recipient).text());
        
        $('#email').attr('disabled', true);

        $('#courseModal').modal('show');
    });
    
    $('#user_form').on('submit', function (event) {
        event.preventDefault();
        $('#password').val($('#phone').val());
        // $('#email').attr('disabled', false);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "POST",
            url: "{{ route('manipulate.user') }}",
            data: $('#user_form').serialize(),
                success: function(response) {
                console.log('Response:', response);
                // alert(response);
                if (response.status == 'success') {
                    toastr["success"](response.data);
                    location.reload();
                    
                }else{
                    toastr["error"](response.data);
                    // alert(response.errors);
                    if (response.errors['f_name']) {
                        $('.f_name').html(response.errors['f_name']);
                        $('.f_name').css('display', 'block');
                        $('#f_name').css('border', '1px solid #e3342f');
                    }
                    if (response.errors['l_name']) {
                        $('.l_name').html(response.errors['l_name']);
                        $('.l_name').css('display', 'block');
                        $('#l_name').css('border', '1px solid #e3342f');
                    }
                    if (response.errors['phone']) {
                        $('.phone').html(response.errors['phone']);
                        $('.phone').css('display', 'block');
                        $('#phone').css('border', '1px solid #e3342f');
                    }
                    if (response.errors['email']) {
                        $('.email').html(response.errors['email']);
                        $('.email').css('display', 'block');
                        $('#email').css('border', '1px solid #e3342f');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
    $('#f_name, #l_name, #phone, #email').on('keyup', function (e){
        // alert(this.id);
        $('.'+this.id).css('display', 'none');
        $('#'+this.id).css('border', '1px solid #ced4da');
    });
</script>
<script>
    $('.delete_stud').on('click', function (event) {
        var button = $(this);
        var recipient = button.data('whatever');

        var modal = $(this)
        $('#user_delete_id').val(recipient)
        $('#delete_msg').html('Do you want delete <strong>'+$('#stud_name_'+recipient).data('first')+' '+$('#stud_name_'+recipient).data('last')+'</strong>');
        $('#deleteModal').modal('show');
    });
</script>
<script>
    $('#delete_user').on('click', function (event) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "POST",
            url: "{{ route('delete.user') }}",
            data: 'user_id='+$('#user_delete_id').val(),
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
    $('#add_student').on('click', function (e){  
        $('#exampleModalLabel').text('Add New Student');
        $('#user_id').val(0)
        $('#f_name').val('');
        $('#l_name').val('');
        $('#email').val('');
        $('#phone').val('');
        
        $('#email').attr('disabled', false);        
        $('#courseModal').modal('show');
    });
</script>
@endsection
