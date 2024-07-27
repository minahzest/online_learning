@extends('layouts.app')

@section('content')
<div class="container" id="inputmasks">
    <div class="row justify-content-center">
        <div class="col-md-12 flex-column">
            <h2> Available Courses </h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3 flex-column">
            <div class="card" style="background-color: antiquewhite;">
                <div class="card-header">{{ __('Profile') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="images/user.png" alt="" style="height: 70px;">
                        </div>
                        <div class="col-md-12 text-center">
                            <h4 class="m-0"><strong>{{ Auth::user()->f_name.' '.Auth::user()->l_name }}</strong></h4>
                            <span>{{ Auth::user()->email }}</span><br>
                            <span>{{ Auth::user()->phone }}</span>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5><strong>My Courses</strong></h5>
                        </div>
                        <div class="col-md-12">
                            <!-- {{ $student_courses }} -->
                            @foreach($student_courses as $sc)
                                <p class="m-0">{{ $sc->course_name }}<span style="float:right;">{{ $sc->course_code }}</span></p>
                            @endforeach
                        </div>
                    </div>                 
                </div>
            </div>
            
        </div>    
        <div class="col-md-9 flex-column">
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-sm-3">
                        <div class="card mb-2">
                        <div class="card-header">
                            <h5 class="card-title m-0"><strong>{{ $course->course_name }}</strong></h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 50px; overflow: hidden;">
                                <p class="card-text">{{ $course->course_description }}</p>
                            </div>
                            <a href="javascript:assign({{ $course->id }})" class="btn btn-primary">+ Enroll</a>
                        </div>
                        </div>
                    </div>
                @endforeach
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
