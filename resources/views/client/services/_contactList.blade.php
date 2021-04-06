<div class="table-responsive bg-white shadow rounded">
                            
                            <table class="table mb-0 table-center scroll" id="contacts_table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Contact</th>
                                    </tr>
                                </thead>
                            <tbody>

                            @if($myContacts) 
                                @foreach($myContacts as $k=>$myContact)
                                    @if($k > 0)
                                        <tr>
                                            <td>
                                                <div class="media">
                                                
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <div class="form-group mb-0">
                                                            <input type="radio" id="{{$myContact->id}}" value="{{ $myContact->id }}" name="myContact_id" class="custom-control-input"  />
                                                            <!-- <input type="radio" id="{{$myContact->id}}" name="id" value="{{ $myContact->id }}" {{ ( (isset($myContact->is_default) && intval($myContact->is_default)) ? 'checked=checked' : '') }}> -->
                                                            <input type="hidden" name="state_id" value="{{ $myContact->state_id }}">
                                                            <input type="hidden" name="lga_id" value="{{ $myContact->lga_id }}">
                                                            <input type="hidden" name="town_id" value="{{ $myContact->town_id }}">
                                                            <label class="custom-control-label" for="{{$myContact->id}}">{{$myContact->name ?? ''}}</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="content ml-3">
                                                        <a href="f" class="forum-title text-primary font-weight-bold">{{$myContact->phone_number}}</a>
                                                        <p class="text-muted small mb-0 mt-2">{{$myContact->address}}</p>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach 
                            @endif
                                </tbody>
                            </table>

                            <!-- <div class="d-flex align-items-center justify-content-between mt-4 col-lg-12">
                                <a onClick="address()" href="javascript:void(0)" class="btn btn-success btn-lg btn-block">Add New Address</a>
                                <a href="javascript:void(0)" class="btn btn-primary" id="edit">Confirm</a>
                            </div> -->
                        </div>