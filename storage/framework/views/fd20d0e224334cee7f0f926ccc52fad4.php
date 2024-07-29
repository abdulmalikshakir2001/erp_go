
<?php echo e(Form::open(['url' => 'employee-self-assessment', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('appraisal_date', __('Select Month*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::month('appraisal_date', '', ['class' => 'form-control', 'autocomplete'=>'off', 'required' => 'required'])); ?>

            </div>
        </div>
    </div>
    <div class="row" id="stares">
        <!-- Appraisal and indicator will be loaded here -->
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>


<script>
    $(document).ready(function() {
        loadAppraisalAndIndicator();
    });

    $('#employee').change(function(){
        loadAppraisalAndIndicator();
    });

    function loadAppraisalAndIndicator() {
        $.ajax({
            url: "<?php echo e(route('empByStarSelf')); ?>",
            type: "post",
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            cache: false,
            success: function(data) {
                $('#stares').html(data.html);
            }
        });
    }
</script>
<?php /**PATH C:\xampp\htdocs\erp_go\main-file\resources\views/employee-self-assessment/create.blade.php ENDPATH**/ ?>