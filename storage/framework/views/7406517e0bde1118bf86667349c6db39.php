<?php echo e(Form::open(array('url' => 'travel', 'method' => 'post'))); ?>

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
    
    
    <div class="form-group col-md-12">
        <?php echo e(Form::label('trip_type', __('Trip Type'), ['class' => 'form-label'])); ?>

      <div class="row">
        <div class="col-md-2">
            <div class="form-check">
                <?php echo e(Form::radio('trip_type', 'international', false, ['class' => 'form-check-input', 'id' => 'international','required'=>'required', 'onchange' => 'toggleTripFields("international")'])); ?>

                <?php echo e(Form::label('international', __('International'), ['class' => 'form-check-label'])); ?>

            </div>
           </div>
           <div class="col-md-2">
            <div class="form-check">
                <?php echo e(Form::radio('trip_type', 'local', false, ['class' => 'form-check-input', 'id' => 'local','required'=>'required', 'onchange' => 'toggleTripFields("local")'])); ?>

                <?php echo e(Form::label('local', __('Local'), ['class' => 'form-check-label'])); ?>

            </div>
           </div>
      </div>
    </div>

    <div class="row">
         <div class="form-group col-md-12">
             <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'form-label'])); ?>

             <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select', 'required' => 'required'])); ?>

         </div>
     </div>
    <div class="row" id="intTrips">
        <!-- International trip fields -->
        <div class="row">
            <div class="form-group col-md-6">
                <?php echo e(Form::label('place_of_visit', __('Country'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country')])); ?>

            </div>
        </div>
    </div>
    <div class="row" id="localTrips" style="display: none;">
       <div class="row">
        <div class="form-group col-md-6" id="state">
            <?php echo e(Form::label('state', __('State'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter State')])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('origin', __('Origin'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('origin', null, ['class' => 'form-control', 'placeholder' => __('Origin')])); ?>

        </div>
       </div>
       
        
        <div class="form-group col-md-6" id="state">
            <?php echo e(Form::label('destination', __('Destination'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('destination', null, ['class' => 'form-control', 'placeholder' => __('Destination')])); ?>

        </div>
       
       
    </div>


    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('purpose_of_visit', __('Purpose of Trip'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('purpose_of_visit', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Purpose of Visit')])); ?>

        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
         <div class="form-group col-lg-6 col-md-6">
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
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>


<script>
function toggleTripFields(tripType) {
    const intTrips = document.getElementById('intTrips');
    const localTrips = document.getElementById('localTrips');

    if (tripType === 'international') {
        intTrips.style.display = 'block';
        localTrips.style.display = 'none';

        // Add 'required' to international fields
        document.getElementsByName('country')[0].required = true;

        // Remove 'required' from local fields
        document.getElementsByName('state')[0].required = false;
        document.getElementsByName('origin')[0].required = false;
        document.getElementsByName('destination')[0].required = false;

    } else if (tripType === 'local') {
        intTrips.style.display = 'none';
        localTrips.style.display = 'block';

        // Remove 'required' from international fields
        document.getElementsByName('country')[0].required = false;

        // Add 'required' to local fields
        document.getElementsByName('state')[0].required = true;
        document.getElementsByName('origin')[0].required = true;
        document.getElementsByName('destination')[0].required = true;
    }
}

</script>
<?php /**PATH C:\xampp\htdocs\erp_go\main-file\resources\views/travel/create.blade.php ENDPATH**/ ?>