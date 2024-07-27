@extends('layouts.app')

@section('content')
<div class="container" id="inputmasks">
    <div class="row justify-content-center">
        <div class="col-md-12 flex-column">
            <h2> My Courses </h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3 flex-column">
            <div class="card" style="background-color: antiquewhite;">
                <div class="card-header">{{ __('Statistics') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5><strong>My Courses</strong></h5>
                        </div>
                        <div class="col-md-12">
                            <!-- {{ $student_courses }} -->
                                <p class="m-0">{{ __('Available Course') }}<span style="float:right;">{{ count($courses) }}</span></p>
                                <p class="m-0">{{ __('Enrolled Course') }}<span style="float:right;">{{ count($student_courses) }}</span></p>
                                <p class="m-0">{{ __('Recent Enroll') }}
                                    @if(count($student_courses))
                                    <span style="float:right;">{{ $student_courses[count($student_courses)-1]->course_name }}</span>
                                    @endif
                                </p>
                        </div>
                    </div>                 
                </div>
            </div>
            
        </div>    
        <div class="col-md-9 flex-column">
            <div class="card">
                <div class="card-header">{{ __('Courses Enrolment History') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>This table list out the courses you have enrolled and follwoing</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Enrolled Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach($student_courses as $sc)
                                    <tr>
                                        <th scope="row">{{ $count }}</th>
                                        <td>{{ $sc->course_name }}</td>
                                        <td>{{ $sc->course_code }}</td>
                                        <td>{{ $sc->created_at }}</td>
                                    </tr>
                                    <?php $count++; ?>
                                    @endforeach
                                    @if(!count($student_courses))
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
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    var csrfToken = '{{ csrf_token() }}';
</script>
<script>
    function assign(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "POST",
            url: "{{ route('assign.courses') }}",
            data: "course_id="+id,
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
    }
</script>
@endsection
