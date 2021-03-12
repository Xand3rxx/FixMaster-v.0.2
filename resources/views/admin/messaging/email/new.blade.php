@extends('layouts.dashboard')
@section('title', 'Create New Estate')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/jlistbox/css/jquery.transfer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/jlistbox/icon_font/css/icon_font.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!-- include summernote css/js -->
<style>
 .btn-placeholder{
   margin-bottom:5px;
 }
 .placeholders{
     padding:10px;
 }

.note-editable { background-color: white !important; }

</style>
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.inbox', app()->getLocale()) }}">Inbox</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Email</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Send Email</h4>
                </div>
            </div>

            @csrf
            <fieldset class="form-group border p-4">
                <legend class="w-auto px-2">Recepients</legend>
                <div class="row row-xs">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="recipients"></div>

                            </div>
                            
                         </div>
                       
                    </div>
                </div>
            </fieldset>
            <fieldset class="form-group border p-4">
                <legend class="w-auto px-2">Your Message</legend>
                <div class="form-row">
                            <div class="form-group col-md-8">
                            <input type="text" class="form-control " id="subject"  placeholder="Mail Subject" />
                            </div>
                </div>
                <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="message-div">
                                    <textarea id="message-box"></textarea>
                                 <div class="placeholders">
                                 <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="firstname">Firstname</button>
                                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="lastname">Lastname</button>
                                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="address">Address</button>
                                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="email">Email</button>
                                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="password">Password</button>
                                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="url">URL</button>
                                 </div>
                                </div>

                            </div>
                            <button type="buton" class="btn btn-primary float-right" id="btnSendMessage">Send Message</button>
                         </div>
            </fieldset>
              

        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>
<script src="{{ asset('assets/dashboard/assets/jlistbox/js/jquery.transfer.js') }}"></script>
<script>
    var url = window.location.origin
    var selected_recipients = {};
        $(document).ready(function (){
            $("#message-box").summernote({
                height: 150
            });
            $.get( url+"/api/messaging/roles", function( data ) {
                var roles = [];
                $.each(data, function(key, val){
                  var role = {
                      'name': val.name,
                      'value': val.id
                  }
                  roles.push(role)
                })
                var groupData = [
                    {
                        "groupName":"UserGroups",
                        "groupData": roles
                    }
                ];
         
                var settings = {
                    // data item name
                    itemName: "name",
                    // group data item name
                    groupItemName: "groupItem",
                    // group data array name
                    groupArrayName: "groupArray",
                    // data value name
                    valueName: "value",
                    // tab text
                    tabNameText: "Users",
                    // right tab text
                    rightTabNameText: "Recipients",
                    // search placeholder text
                    searchPlaceholderText: "search",
                    // group data array
                    groupDataArray: groupData,
                    dataArray: roles,
                    callable: function (items) {
                        selected_recipients = items;
                    }
                };
                $(".recipients").html("")
                var newrecipients = $(".recipients").transfer(settings);
                newrecipients.getSelectedItems();
                

                
            });
        $('.btn-placeholder').click(function(){
            var toInsert = '{'+$(this).data('val')+'}';
            
            var selection = document.getSelection();
            var cursorPos = selection.anchorOffset;
            var oldContent = selection.anchorNode.nodeValue;
            var newContent = oldContent.substring(0, cursorPos) + toInsert + oldContent.substring(cursorPos);
            selection.anchorNode.nodeValue = newContent;
            

         });

         
         $('#btnSendMessage').click(function(){
            var subject = $('#subject').val();
            var recipients = selected_recipients;
            var content = $('#message-box').val();
            var sender = '<?php echo Auth::user()->id; ?>';
            var jqxhr = $.post(url+"/api/messaging/save_email",
            {
               subject:subject,
               recipients:recipients,
               mail_content:content,
               sender:sender
            },
            function(data, status){
                console.log(data)
                displayMessage(data.message, 'success');
            })
            .fail(function(data, status) {
                displayMessage(data.responseJSON.message, 'error');
            })


          

         });
            
        });
    </script>
@endpush
