<?php echo e(Form::model($travel, ['route' => ['travel.update', $travel->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <?php
        $settings = \App\Models\Utility::settings();
    ?>
    <?php if($settings['ai_chatgpt_enable'] == 'on'): ?>
        <div class="text-end">
            <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['travel'])); ?>"
               data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
                <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
            </a>
        </div>
    <?php endif; ?>
    
    <!-- Hidden input for trip_type -->
    <?php echo e(Form::hidden('trip_type', $travel->country ? 'international' : 'local')); ?>


    <!-- Other fields -->
    <div class="form-group col-md-12">
        <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select', 'required' => 'required'])); ?>

    </div>
    
    <div class="row" id="intTrips" style="<?php echo e($travel->country ? '' : 'display: none;'); ?>">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('country', __('Country'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country')])); ?>

        </div>
    </div>
    
    <div class="" id="localTrips" style="<?php echo e($travel->country ? 'display: none;' : ''); ?>">
        <div class="row">
            <div class="form-group col-md-6">
                <?php echo e(Form::label('state', __('State'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter State')])); ?>

            </div>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('origin', __('Origin'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('origin', null, ['class' => 'form-control', 'placeholder' => __('Enter Origin')])); ?>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <?php echo e(Form::label('destination', __('Destination'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('destination', null, ['class' => 'form-control', 'placeholder' => __('Enter Destination')])); ?>

            </div>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('purpose_of_visit', __('Purpose of Trip'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('purpose_of_visit', null, ['class' => 'form-control','placeholder' => __('Enter Purpose of Visit')])); ?>

            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
    </div>
    
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')])); ?>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\Users\Hassnain's PC\erp_go\resources\views/travel/edit.blade.php ENDPATH**/ ?>