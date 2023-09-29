@extends('admin.layout')
@section('content')
<!-- Page content -->
<style>
    .dataTables_paginate,.dataTables_length,.dataTables_info {
        display:none;
    }
    #prompt_table_filter{
        margin-top: -42px;
    }
</style>
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('Prompt Import') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> <span class="text-grey">{{ __('Ai Prompts') }}</span><i class="fa fa-angle-right fa-fw"></i> {{ __('import prompt') }}</p>
            </div>
            <div class="col-md-6 col-12">
                <div class="pull-right-btn">
                    <a href="{{ url('admin/settings/prompts') }}" class="btn btn-primary btn-md mt-1 float-end">
                        <span class="ion-plus">{{ 'Back' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title d-inline-block" id="exampleModalLabel">{{ __('Add CSV File') }}</h5>
<a id="downloadLink" class="btn btn-outline-info btn-sm border-0 d-inline-block" href="{{ asset('assets/csv-file/prompt_bulk.csv') }}">
    <i class="fa fa-download"></i> {{ __('Download Format') }}
</a>

                    </div>
                    <form action="{{ route('prompt.bulk.add') }}" method="post" class="js-create-prompt">
                        @csrf
                        <div class="card-body text-center">
                            <div class="small">
                                <input type="file" accept=".csv" id="excel_file" name="excel_file" class="form-control form-control-sm">
                                <label class="btn btn-outline-primary border-0" for="excel_file">
                                    SELECT FILE <i class="fa fa-file"></i>
                                </label>
                                <p id="file-name"></p>
                            </div>
                            <div id="file-validation-error" class="alert alert-danger ms-4 me-4 mt-3 mb-0 small" role="alert" style="display: none;">
                                <i class="fa fa-exclamation-triangle"></i> Invalid file format. Please upload an Excel file.
                            </div>
                            <div id="file-status" class="alert alert-success ms-4 me-4 mt-3 mb-0 small" role="alert" style="display: none;">
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="btn" id="saveBtn" class="btn btn-primary">{{ __('Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
 $(document).ready(function() {
     
    document.getElementById('downloadLink').addEventListener('click', function(event) {
        event.preventDefault();
        var fileUrl = this.getAttribute('href');
        downloadFile(fileUrl);
    });

    function downloadFile(fileUrl) {
        var link = document.createElement('a');
        link.href = fileUrl;
        link.download = 'prompt_bulk.csv';
        link.click();
    }

    
    $('input[name="excel_file"]').change(function(e) {
        var fileInput = $(this);
        if (fileInput.get(0).files.length === 0 || !fileInput.get(0).files[0].name.match(/.(csv)$/i)) {
            $('#file-name').text(''); // Clear the file name if no valid file is selected
            $('#file-validation-error').show();
        } else {
            var fileName = fileInput.get(0).files[0].name;
            $('#file-name').text(fileName);
        }
    });

    $('#saveBtn').click(function(e) {
        var fileInput = $('input[name="excel_file"]');
        if (fileInput.get(0).files.length === 0 || !fileInput.get(0).files[0].name.match(/.(csv)$/i)) {
            e.preventDefault();
            $('#file-validation-error').show();
            setTimeout(function(){
                $('#file-validation-error').hide();
            },3000);
        }else{
            saveData(e);
        }
    });


    function saveData(e) {
    e.preventDefault();
    
    var form = $('form.js-create-prompt')[0];
    var formData = new FormData(form);
    
    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend:function(){
            $('#file-status').removeClass('alert-success').addClass('alert-warning').html('Processing..').show();
        },
        success: function(res) {
            if(res.status.success==false){
                $('#file-status').removeClass('alert-success').addClass('alert-danger');
            }
            $('#file-status').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').html(res.status.message).show();
            
            setTimeout(function(){
                $('#file-status').removeClass('alert-warning').removeClass('alert-danger').addClass('alert-success').hide();
                if(res.status.success==true){
                    window.location="{{ route('show_prompt') }}";
                }
            },3000);
            // Handle the response
        }
    });
}

});
</script>

@endsection
