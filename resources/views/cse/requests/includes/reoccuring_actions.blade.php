<div class="mt-4">
    <div class="tx-13 mg-b-25">
        <div id="wizard3">
            <h3>{{$contents['comment']['name']}}</h3>
            <section>
                <div class="mt-4 form-row">
                    <div class="form-group col-md-12">
                        <label for="{{$contents['comment']['button']['name']}}">{{$contents['comment']['button']['label']}}</label>
                        <textarea {{$contents['comment']['button']['required']}} rows="3" class="form-control @error($contents['comment']['button']['name']) is-invalid @enderror" id="{{$contents['comment']['button']['id']}}"
                            name="{{$contents['comment']['button']['name']}}"></textarea>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div><!-- df-example -->
