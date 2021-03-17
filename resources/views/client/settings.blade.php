@extends('layouts.client')
@section('title', 'Settings')
@section('content')
@include('layouts.partials._messages')

      <div class="col-lg-8 col-12">
          <div class="card border-0 rounded shadow">
              <div class="card-body mt-">
                  <h5 class="text-md-left text-center">Personal Detail :</h5>

                  <div class="mt-3 text-md-left text-center d-sm-flex">
                      <img src="http://localhost:8000/assets/images/default-female-avatar.png" alt="Default female profile avatar" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" />

                      <div class="mt-md-4 mt-3 mt-sm-0">
                          <button type="button" class="btn btn-primary btn-sm mt-2 change-picture">Change Picture</button>

                          <form method="POST" action="" enctype="multipart/form-data">
                              <input type="hidden" name="_token" value="QPTh2nPY9a4ypodU53bsXMtvmbEJPgvtUbnc96We" /> <input type="hidden" name="_method" value="PUT" /> <input type="hidden" id="old_avatar" name="old_avatar" value="" />
                              <input type="file" accept="image/*" class="d-none" name="avatar" id="avatar" />
                              <button type="submit" class="btn btn-outline-primary btn-sm d-none mt-2" id="submit-avatar">Save Picture</button>
                          </form>
                      </div>
                  </div>

                  <form method="POST" action=" ">
                      <input type="hidden" name="_token" value="QPTh2nPY9a4ypodU53bsXMtvmbEJPgvtUbnc96We" /> <input type="hidden" name="_method" value="PUT" />
                      <div class="row mt-4">
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>First Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="first_name" id="first_name" type="text" class="form-control pl-5" value="" placeholder="First Name :" />
                              </div>
                          </div>
                          <!--end col-->

                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Middle Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="middle_name" id="middle_name" type="text" class="form-control pl-5" value="" placeholder="Middle Name :" />
                              </div>
                          </div>
                          <!--end col-->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Last Name</label>
                                  <i data-feather="user" class="fea icon-sm icons"></i>
                                  <input name="last_name" id="last_name" type="text" class="form-control pl-5" value="" placeholder="Last Name :" />
                              </div>
                          </div>
                          <!--end col-->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Your Email</label>
                                  <i data-feather="mail" class="fea icon-sm icons"></i>
                                  <input name="email" id="email" type="email" class="form-control pl-5" value="client@fix-master.com" placeholder="Your E-Mail :" />
                              </div>
                          </div>
                          <!--end col-->
                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Phone No. :</label>
                                  <i data-feather="phone" class="fea icon-sm icons"></i>
                                  <input name="phone_number" id="phone_number" type="tel" maxlength="11" class="form-control pl-5" value="" placeholder="Phone :" />
                              </div>
                          </div>
                          <!--end col-->

                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>State <span class="text-danger">*</span></label>
                                  <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                  <select class="form-control pl-5" name="state_id" id="state_id">
                                      <option selected value="">Select...</option>
                                      <option value="1">Abia</option>
                                      <option value="37">Abuja Federal Capital Territory</option>
                                      <option value="2">Adamawa</option>
                                      <option value="3">Akwa Ibom</option>
                                      <option value="4">Anambra</option>
                                      <option value="5">Bauchi</option>
                                      <option value="6">Bayelsa</option>
                                      <option value="7">Benue</option>
                                      <option value="8">Borno</option>
                                      <option value="9">Cross River</option>
                                      <option value="10">Delta</option>
                                      <option value="11">Ebonyi</option>
                                      <option value="12">Edo</option>
                                      <option value="13">Ekiti</option>
                                      <option value="14">Enugu</option>
                                      <option value="15">Gombe</option>
                                      <option value="16">Imo</option>
                                      <option value="17">Jigawa</option>
                                      <option value="18">Kaduna</option>
                                      <option value="19">Kano</option>
                                      <option value="20">Katsina</option>
                                      <option value="21">Kebbi</option>
                                      <option value="22">Kogi</option>
                                      <option value="23">Kwara</option>
                                      <option value="24">Lagos</option>
                                      <option value="25">Nassarawa</option>
                                      <option value="26">Niger</option>
                                      <option value="27">Ogun</option>
                                      <option value="28">Ondo</option>
                                      <option value="29">Osun</option>
                                      <option value="30">Oyo</option>
                                      <option value="31">Plateau</option>
                                      <option value="32">Rivers</option>
                                      <option value="33">Sokoto</option>
                                      <option value="34">Taraba</option>
                                      <option value="35">Yobe</option>
                                      <option value="36">Zamfara</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group position-relative">
                                  <label>Town/City <span class="text-danger">*</span></label>
                                  <i data-feather="navigation" class="fea icon-sm icons"></i>
                                  <input type="text" class="form-control pl-5" placeholder="e.g. Ajah, Ikoyi" name="town" id="town" value="" />
                              </div>
                          </div>

                          <div class="col-lg-12">
                              <div class="form-group position-relative">
                                  <label>Residential Address</label>
                                  <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                  <textarea name="full_address" id="full_address" rows="4" class="form-control pl-5" placeholder="Residential address :"></textarea>
                              </div>
                          </div>
                      </div>
                      <!--end row-->
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="submit" id="submit" class="btn btn-primary btn-sm" value="Update Profile" />
                          </div>
                          <!--end col-->
                      </div>
                      <!--end row-->
                  </form>
                  <!--end form-->

                  <div class="row">
                      <div class="col-md-12 mt-4 pt-2">
                          <h5>Change password :</h5>
                          <small class="text-danger">In order to change your password, you need to provide the current password.</small>

                          <form method="POST" action=" ">
                              <input type="hidden" name="_token" value="QPTh2nPY9a4ypodU53bsXMtvmbEJPgvtUbnc96We" /> <input type="hidden" name="_method" value="PUT" />
                              <div class="row mt-4">
                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>Current Password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="Current Password" id="current_password" name="current_password" />
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>New password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="New password" id="new_password" name="new_password" />
                                          <small style="font-size: 10px;" class="text-muted">Password must be at least 8 characters</small>
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-4">
                                      <div class="form-group position-relative">
                                          <label>Re-type New password :</label>
                                          <i data-feather="key" class="fea icon-sm icons"></i>
                                          <input type="password" class="form-control pl-5" placeholder="Re-type New password" id="new_confirm_password" name="new_confirm_password" />
                                      </div>
                                  </div>
                                  <!--end col-->

                                  <div class="col-lg-12 mt-2 mb-0">
                                      <button type="submit" class="btn btn-primary btn-sm">Change password</button>
                                  </div>
                                  <!--end col-->
                              </div>
                              <!--end row-->
                          </form>
                      </div>
                      <!--end col-->
                  </div>
                  <!--end row-->
              </div>
          </div>
      </div>
      <!--end col-->

      @push('scripts')
 
  <script>
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
                url: "http://localhost:8000/en/lga-list",
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

        $(document).on('click', '.change-picture', function (){
            // alert();
            $('#avatar').trigger('click');
            $('#submit-avatar').removeClass('d-none');
        });
    });
</script>

@endpush

@endsection