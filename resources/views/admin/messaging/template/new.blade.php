@extends('layouts.dashboard')
@section('title', 'New Message')
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
                <legend class="w-auto px-2">Recipients</legend>
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
                        <div>
                            <form id="frmMessaging">
                                <div class="form-group">
                                    <input name="msg-type" type="radio" id="rd-email" value="email" checked />  Email
                                    <input name="msg-type" type="radio" id="rd-sms" value="SMS" />  SMS
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="feature" aria-placeholder="Feature"></select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email-title" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="email_editor"></textarea>
                                </div>
                            </form>
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
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_name">Customer Name</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_email">Customer Email</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_phone">Customer Phone</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_address">Customer Address</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_whatsapp">Whatsapp</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="preferred_communication">Communication</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="booking_fee">Booking Fee</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="diagnosis_fee">Diagnosis Fee</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="service">Service</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="job_ref">Job Ref</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="invoice">Invoice</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="date">Date</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="time">Time</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="passport">Passport</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_id">Technician ID</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_name">Technician Name</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="completed_jobs">Completed Jobs</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_rating">Technician Rating</button>
            <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="cse_name">CSE Name</button>
                                 </div>
                                </div>

                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save message</button>
        <button type="button" class="btn btn-primary" id="btn-update">Update message</button>
                         </div>
            </fieldset>
              

        </div>
    </div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
{{-- <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>
<script>
var url = window.location.origin;
var editor_disabled = false;
var checked_value = 'Email';
  $(document).ready(function (){

    $.get( url+"/api/template/list", function( data ) {
        var trow = "";
        $.each(data.data, function(key, val){
           trow = '<tr data-id="'+val.uuid+'"><td class="tx-medium">'+ val.title + '</td>';
           trow += '<td class="text-right">' + val.type + '</td>';
           trow += '<td class="text-right">'+val.feature+'</td>';
           trow += '<td class="text-medium nav-item"><span>';
           trow += '<a href="#" class="msgedit" style="float: left;margin-right:10px;">';
        //    trow += '<i data-feather="edit" style="font-size: 9px;"></i></a></span>';
           trow += '<img src="'+ url+'/assets/images/icon/edit.svg" alt="Image"/></a></span>';
           trow += '<span>  <a href="#" class="msgdelete" style="float: left; margin-right:10px;">';
           trow += '<img src="'+ url+'/assets/images/icon/trash.svg" alt="Image"/></a></span></td>';
          // trow += '<i data-feather="trash" style="font-size: 9px;"></i></a></span></td>';
           trow += '</tr>';
             $('#template-list').append(trow);
        })
      });

    $("#btn-save").show();
        $("#btn-update").hide();

        $("#email_editor").summernote({
        height: 150
    });
        $("#btnNewTemplate").click(function(){
            $('#email-title').val("")
            $('#email_editor'). summernote('code', '')
            $("#btn-save").show();
            $("#btn-update").hide();
            $("#messageModal").modal('show');
        })
    $('i.note-recent-color').each(function(){
        $(this).attr('style','background-color: transparent;');
    });

    $('.btn-placeholder').click(function(){
        var toInsert = '{'+$(this).data('val')+'}';
        if(editor_disabled==true){
            insertTextArea('email_editor',toInsert)
        }else if(editor_disabled==false){
        var selection = document.getSelection();
        var cursorPos = selection.anchorOffset;
        var oldContent = selection.anchorNode.nodeValue;
        var newContent = oldContent.substring(0, cursorPos) + toInsert + oldContent.substring(cursorPos);
        selection.anchorNode.nodeValue = newContent;
        }

    });

    $('#btn-save').click(function(){
        updateMessageTemplate('save');
    });

     $('#btn-update').click(function(){
        updateMessageTemplate('update');
    });

    $('#rd-email').click(function(){
        editor_disabled = false;
        checked_value = 'Email';
       $('#email_editor').summernote({height: 150});
    });

    $('#rd-sms').click(function(){
       editor_disabled = true;
       checked_value = 'SMS';
       $('#email_editor').summernote('destroy');
    });


    $.get( url+"/api/template/features", function( data ) {
        $.each(data, function(key, val){
             $('<option>').val(val).text(val).appendTo('#feature');
        })
      });

    $(document).on('click', '.msgedit', function(e){
        e.preventDefault();
        var uuid = $(this).parents('tr').data('id');
        $.get( url+"/api/template/"+uuid, function( data ) {
            data = data.data
            var selected = data.feature;
            $("#feature").filter(function() {
            return $(this).text() == selected;
            }).prop('selected', true);
            $("#email-title").val(data.title);
            $('#email_editor').summernote('code', data.content);

            if(data.type=='SMS'){
                $('#rd-sms').click()
            }else{
                $('#rd-email').click()
            }

            $("#btn-save").hide();

            $("#btn-update").show();
            $("#messageModal").modal('show');
      });
    })
    $('#btnSendTestEmail').click(function(){
        sendTestEmail();
    });
    });
function sendTestEmail()
{
     $.ajax({
            url: url+"/api/message/send",
            type: 'POST',
            data:{
                feature:'CUSTOMER_REGISTRATION',
                subject:'Test Registration Email',
                id:'1',
                recipient:'john.doe-af83d6@inbox.mailtrap.io',
                mail_data: {'firstname':'Adam', 'lastname':'John', 'url':'<a href="https://google.com">Here</a>'}
            },
            success: function(result) {
                console.log(result)
            }
        });
}
function updateMessageTemplate(endpoint){
    var title = $('#email-title').val();
        var content = $('#email_editor').val();
        var feature = $('#feature').val();
        var type = checked_value;
        var jqxhr = $.post(url+"/api/template/"+endpoint,
            {
                title: title,
                content: content,
                feature: feature,
                message_type: type,
            },
            function(data, status){
                console.log(data)
                displayMessage(data.message, 'success');
            })
            .fail(function(data, status) {
                displayMessage(data.responseJSON.message, 'error');
            })
</script>
@endpush