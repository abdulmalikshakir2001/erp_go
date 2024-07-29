
{{ Form::open(['url' => 'employee-self-assessment', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('appraisal_date', __('Select Month*'), ['class' => 'col-form-label']) }}
                {{ Form::month('appraisal_date', '', ['class' => 'form-control', 'autocomplete'=>'off', 'required' => 'required']) }}
            </div>
        </div>
    </div>
    <div class="row" id="stares">
        <!-- Appraisal and indicator will be loaded here -->
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        loadAppraisalAndIndicator();
    });

    $('#employee').change(function(){
        loadAppraisalAndIndicator();
    });

    function loadAppraisalAndIndicator() {
        $.ajax({
            url: "{{ route('empByStarSelf') }}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            cache: false,
            success: function(data) {
                $('#stares').html(data.html);
            }
        });
    }
</script>
