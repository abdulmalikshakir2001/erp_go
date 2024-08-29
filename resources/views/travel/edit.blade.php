{{ Form::model($travel, ['route' => ['travel.update', $travel->id], 'method' => 'PUT']) }}
<div class="modal-body">
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if($settings['ai_chatgpt_enable'] == 'on')
        <div class="text-end">
            <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate', ['travel']) }}"
               data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
                <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
            </a>
        </div>
    @endif
    
    <!-- Hidden input for trip_type -->
    {{ Form::hidden('trip_type', $travel->country ? 'international' : 'local') }}

    <!-- Other fields -->
    <div class="form-group col-md-12">
        {{ Form::label('employee_id', __('Employee'), ['class' => 'form-label']) }}
        {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select', 'required' => 'required']) }}
    </div>
    
    <div class="row" id="intTrips" style="{{ $travel->country ? '' : 'display: none;' }}">
        <div class="form-group col-md-6">
            {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
            {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country')]) }}
        </div>
    </div>
    
    <div class="" id="localTrips" style="{{ $travel->country ? 'display: none;' : '' }}">
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter State')]) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('origin', __('Origin'), ['class' => 'form-label']) }}
                {{ Form::text('origin', null, ['class' => 'form-control', 'placeholder' => __('Enter Origin')]) }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('destination', __('Destination'), ['class' => 'form-label']) }}
                {{ Form::text('destination', null, ['class' => 'form-control', 'placeholder' => __('Enter Destination')]) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('purpose_of_visit', __('Purpose of Trip'), ['class' => 'form-label']) }}
                {{ Form::text('purpose_of_visit', null, ['class' => 'form-control','placeholder' => __('Enter Purpose of Visit')]) }}
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
            {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
            {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
    
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description')]) }}
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{ Form::close() }}
