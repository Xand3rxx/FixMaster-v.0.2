
                                
  <div class="divider-text">Supplier {{ $loop->iteration }}</div>
                                    <ul class="list-group wd-md-100p">
             
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/user-avatars/'.$item->warranty_claim_supplier->user->account->avatar??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ ucfirst($item->warranty_claim_supplier->user->account->first_name)}} {{  ucfirst($item->warranty_claim_supplier->user->account->last_name)}}</h6>

                                            <span class="d-block tx-11 text-muted">
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel: {{$item->warranty_claim_supplier->user->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>

                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                     <div class="custom-control custom-radio mt-2">
                                                         <div class="custom-control custom-radio">
                                                             <input type="radio" class="custom-control-input" id="" name="supplier_id" value="{{$item->warranty_claim_supplier->id}}">
                                                             <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                         </div>
                                                     </div>
                                                 </div>

                                            </div>
                                            </div>
                                        </div>
                                        </li>
              
                                    </ul>