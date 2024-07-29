{{ Form::open(array('url' => 'training', 'method' => 'post')) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if($settings['ai_chatgpt_enable'] == 'on')
        <div class="text-end">
            <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['training']) }}" data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
                <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
            </a>
        </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                <select name="branch" class="form-control select" required>
                    <option value="" disabled>{{ __('Select Branch') }}</option>
                    @foreach($branches as $branchId => $branchName)
                        <option value="{{ $branchId }}">{{ $branchName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('trainer_option', __('Trainer Option'), ['class' => 'form-label']) }}
                <select name="trainer_option" class="form-control select" required>
                    <option value="" disabled>{{ __('Select Trainer Option') }}</option>
                    @foreach($options as $optionId => $optionName)
                        <option value="{{ $optionId }}">{{ $optionName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('training_type', __('Training Type'), ['class' => 'form-label']) }}
                <select name="training_type" class="form-control select" required>
                    <option value="" disabled>{{ __('Select Training Type') }}</option>
                    @foreach($trainingTypes as $typeId => $typeName)
                        <option value="{{ $typeId }}">{{ $typeName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('trainer', __('Trainer'), ['class' => 'form-label']) }}
                <select name="trainer" class="form-control select" required>
                    <option value="" disabled>{{ __('Select Trainer') }}</option>
                    @foreach($trainers as $trainerId => $trainerName)
                        <option value="{{ $trainerId }}">{{ $trainerName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('training_cost', __('Training Cost'), ['class' => 'form-label']) }}
                {{ Form::number('training_cost', null, ['class' => 'form-control', 'step' => '0.01', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('employee', __('Employee'), ['class' => 'form-label']) }}
                <select name="employee[]" class="form-control select multiple-select" multiple required>
                    <option value="" disabled>{{ __('Select Employees') }}</option>
                    @foreach($employees as $employeeId => $employeeName)
                        <option value="{{ $employeeId }}">{{ $employeeName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                {{ Form::date('start_date', null, ['class' => 'form-control ', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                {{ Form::date('end_date', null, ['class' => 'form-control ', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
