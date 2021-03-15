@extends('layouts.dashboard')
@section('title', 'Edit Profile')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('cse.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Account Settings</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="description-tab3" data-toggle="tab" href="#description3" role="tab" aria-controls="description" aria-selected="true">Update Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="rfq-tab3" data-toggle="tab" href="#rfq3" role="tab" aria-controls="rfq" aria-selected="false">Change Password</a>
                </li>
              </ul>
              <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">
                <div class="tab-pane fade show active" id="description3" role="tabpanel" aria-labelledby="description-tab3">
                  <h6>UPDATE PROFILE</h6>
                  <div class="card-body pd-20 pd-lg-25">
                    <form action="{{route('cse.updateProfile')}}" method="post" role="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="d-sm-flex float-left">
                            <div class="mg-sm-r-30">
                                <div class="pos-relative d-inline-block mg-b-20">
                                    <a href="#">
                                    <div class="avatar avatar-xxl">
                                      <div class="user-img">
                                        <img class="rounded-circle wh-150p img-fluid image profile_image_preview" src="{{!empty($avatar) ? asset('assets/cse-technician-images/'.$avatar) : asset('assets/admin/img/noimage.jpg')}}" alt="user-image">
                                      </div>
                                      
                                      </div></a>
                                    {{-- <a href="" class="contact-edit-photo"><i data-feather="edit-2"></i></a> --}}
                                </div>
                            </div><!-- col -->
                        </div>
                        <!-- First Name -->
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ $firstName }}">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Middle Name -->
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $middleName }}">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Last Name -->
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ $lastName }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Email -->
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Phone Number -->
                            <div class="form-group col-md-4">
                              <label for="inputEmail4">Phone Number</label>
                              <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" maxlength="11" value="{{ old('phone_number')?? $phoneNumber }}">
                              @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Other Phone Number -->
                            <div class="form-group col-md-4">
                              <label for="inputEmail4">Other Phone Number</label>
                              <input type="tel" class="form-control" id="other_phone_number" maxlength="11" maxlength="11" value="{{ old('other_phone_number')?? $otherPhoneNumber }}">
                            </div>
                            <!-- Profile Avatar -->
                            <div class="form-group col-md-4">
                              <label>Profile Avatar</label>
                              <div class="custom-file">
                                <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="profile_avater" id="profile_image">
                                <label class="custom-file-label" id="imagelabel" for="profile_image">Upload Profile Avatar</label>
                               
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                              </div>

                            </div>
                            <!-- Bank Name -->
                            <div class="form-group col-md-4">
                              <label>Bank Name</label>
                              <select id="bankSelect" name="bank_id" class="custom-select bank_id @error('bank_id') is-invalid @enderror">
                                  
                              <option data-display="Select Bank *" value="">Bank *</option>
                                @foreach($allBanks as $allBank)
                                    <option value="{{$allBank->id}}" {{$allBank->id == $bank_selected->id ? 'selected':'' }}>{{$allBank->name}} </option>
                                @endforeach
                              </select>

                              @error('bank_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror

                            </div>
                            <!-- Account Number -->
                            <div class="form-group col-md-4">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" placeholder="Account Number" value="{{ old('account_number')?? $accountNumber }}" maxlength="10"  autocomplete="off">
                                @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- State -->
                            <div class="form-group col-md-3">
                              <label>State</label>
                              <select class="form-control @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                <!-- <option selected value="">Select...</option> -->
                                
                                <option data-display="Select State *" value="">State *</option>
                                @foreach($allStates as $allState)
                                    <option value="{{$allState->id}}" {{$allState->id == $state_selected->id ? 'selected':'' }}>{{$allState->name}} </option>
                                @endforeach

                              </select>

                              @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- L.G.A -->
                            <div class="form-group col-md-3">
                              <label>L.G.A</label>
                              <select class="form-control @error('lga_id') is-invalid @enderror" name="lga_id" id="lga_id">
                              <option data-display="Select LGA *" value="">LGA *</option>
                                @foreach($allLgas as $allLga)
                                    <option value="{{$allLga->id}}" {{$allLga->id == $Lga_selected->id ? 'selected':'' }}>{{$allLga->name}} </option>
                                @endforeach
                              </select>
                              @error('lga_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <!-- Town/City -->
                            <div class="form-group col-md-3">
                              <label>Town/City</label>
                              <input type="text" class="form-control @error('town') is-invalid @enderror" placeholder="e.g. CMS, Ikoyi, Egbeda" name="town" id="town" value="{{ old('town')?? $town }}" required>
                              
                            </div>
                            {{-- gender --}}
                            <div class="form-group col-md-3">
                              <label>Gender</label>
                              <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="">Choose....</option>
                                <option value="Male" {{ $gender == 'Male' ? 'selected' : ''}}>Male</option>
                                <option value="Female" {{ $gender == 'Female' ? 'selected' : ''}}>Female</option>                                                         
                             </select> 
                            </div>
                          
                            <!-- Full Address -->
                          <div class="form-group col-md-12">
                            <label for="inputAddress2">Full Address</label> 
                            <textarea rows="3" class="form-control" id="inputAddress2" name="full_address">{{ old('full_address')?? $fullAddress }}</textarea>
                          </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                  </div>
                </div>

                <div class="tab-pane fade" id="rfq3" role="tabpanel" aria-labelledby="rfq-tab3">
                  <h6>CHANGE PASSWORD</h6>
                  <p class="mg-b-0 text-danger">In order to change your password, you need to provide the current password.</p>
                  <div class="card-body pd-20 pd-lg-25">
                  <form action="{{route('cse.updatePassword')}}" method="post">
                    {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="current_password">Current Password</label>
                              <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                              @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                              </div>
                            <div class="form-group col-md-4">
                              <label for="new_password">New Password</label>
                              <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                              @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-4">
                              <label for="new_confirm_password">Confirm Password</label>
                              <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="new_confirm_password" name="new_confirm_password">
                              @error('new_confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                  </div>
                </div>

          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  (function($){
    "use scrict";
    $(document).ready(function(){
    
      $(document).on('change','#profile_image', function(){
        readURL(this);
      })

      reader.readAsDataURL(input.files[0]);

      function readURL(input){
        if(input.files && input.files[0]){
          var reader = new FileReader();
          var res = isImage(input.files[0].name);

          if(res==false){
            var msg = 'Image should be png/PNG, jpg/JPG & jpeg/JPG';
            Snackbar.show({text: msg, pos: 'bottom-right',backgroundColor:'#d32f2f', actionTextColor:'#fff' });
            return false;
          }

          reader.onload = function(e){
            $('.profile_image_preview').attr('src', e.target.result);
            $("imagelabel").text((input.files[0].name));
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      function getExtension(filename) {
          var parts = filename.split('.');
          return parts[parts.length - 1];
      }  

      function isImage(filename) {
          var ext = getExtension(filename);
          switch (ext.toLowerCase()) {
          case 'jpg':
          case 'jpeg':
          case 'png':
          case 'gif':
              return true;
          }
          return false;
      }

    })

 })(jQuery);

// change lga on state change
 $(document).ready(function (){
        $('#state_id').on('change',function () {
            let stateId = $('#state_id').find('option:selected').val();
            let stateName = $('#state_id').find('option:selected').text();
            
            // console.log(stateId, stateName); return;
            $.ajaxSetup({
                headers: {
                    'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('lga_list') }}",
                method: "POST",
                dataType: "JSON",
                data: {state_id:stateId},
                success: function(data){
                    if(data){

                        $('#lga_id').html(data.lgaList);
                    }else{
                        var message = 'Error occured while trying to get L.G.A`s in '+ categoryName +' category to '+ serviceName + ' service';
                        var type = 'error';
                        displayMessage(message, type);

                    }
                },
            })  
        });

    });

</script>
@endsection