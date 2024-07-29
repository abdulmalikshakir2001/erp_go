@extends('layouts.admin')
@section('page-title')
    {{__('Manage Attendance List')}}
@endsection

@push('script-page')
<script>
    let employeeChoices;

    $(document).ready(function () {
        $('input[name="type"]:radio').on('change', function () {
            var type = $(this).val();
            if (type == 'monthly') {
                $('.month').removeClass('d-none').addClass('d-block');
                $('.date input, .range input').val('');
                $('.date').removeClass('d-block').addClass('d-none');
                $('.range').removeClass('d-block').addClass('d-none');
            } else if (type == 'daily') {
                $('.date').removeClass('d-none').addClass('d-block');
                $('.month input, .range input').val('');
                $('.month').removeClass('d-block').addClass('d-none');
                $('.range').removeClass('d-block').addClass('d-none');
            } else {
                $('.range').removeClass('d-none').addClass('d-block');
                $('.date input, .month input').val('');
                $('.date').removeClass('d-block').addClass('d-none');
                $('.month').removeClass('d-block').addClass('d-none');
            }
        });
        $('input[name="type"]:radio:checked').trigger('change');

        $('#branch').on('change', function () {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        $('#department').on('change', function () {
            var department_id = $(this).val();
            getEmployee(department_id);
        });

        // Initialize the select inputs with default values
        getDepartment($('#branch').val());
        getEmployee($('#department').val());

        // Initialize Choices.js for multi-select
        initializeChoices();
    });

    function initializeChoices() {
        if (employeeChoices) {
            employeeChoices.destroy();
        }
        employeeChoices = new Choices('#employee', {
            removeItemButton: true,
        });
    }

    function clearChoices() {
        if (employeeChoices) {
            employeeChoices.clearStore();
            employeeChoices.clearChoices();
        }
    }

    function getDepartment(branch_id) {
        $.ajax({
            url: '{{route('report.attendance.getdepartment')}}',
            type: 'POST',
            data: {
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                $('#department').empty();
                $('#department').append('<option value="">{{__('Select Department')}}</option>');
                $('#department').append('<option value="0"> {{__('All Department')}} </option>');
                $.each(data, function (key, value) {
                    $('#department').append('<option value="' + key + '">' + value + '</option>');
                });
                getEmployee($('#department').val());
            }
        });
    }

    function getEmployee(department_id) {
        var branch_id = $('#branch').val();
        $.ajax({
            url: '{{route('report.attendance.getemployee')}}',
            type: 'POST',
            data: {
                "department_id": department_id,
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                clearChoices(); // Clear existing options
                // Add new options
                employeeChoices.setChoices(function () {
                    let choices = [];
                    choices.push({ value: '', label: '{{__('Select Employee')}}' });
                    choices.push({ value: '0', label: '{{__('All Employee')}}' });
                    $.each(data, function (key, value) {
                        choices.push({ value: key, label: value });
                    });
                    return choices;
                }, 'value', 'label', false);
            }
        });
    }
</script>


@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Attendance')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('status') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mt-2">
                <div class="card-body">
                    {{ Form::open(array('route' => array('attendanceemployee.index'),'method'=>'get','id'=>'attendanceemployee_filter')) }}
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">{{__('Type')}}</label>
                            <div class="form-check">
                                <input type="radio" id="monthly" value="monthly" name="type" class="form-check-input" {{isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'}}>
                                <label class="form-check-label" for="monthly">{{__('Monthly')}}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="daily" value="daily" name="type" class="form-check-input" {{isset($_GET['type']) && $_GET['type']=='daily' ?'checked':''}}>
                                <label class="form-check-label" for="daily">{{__('Daily')}}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="range" value="range" name="type" class="form-check-input" {{isset($_GET['type']) && $_GET['type']=='range' ?'checked':''}}>
                                <label class="form-check-label" for="range">{{__('Date Range')}}</label>
                            </div>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <div class="row w-100">
                                <div class="col-md-3 month d-none">
                                    <div class="form-group">
                                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                        {{ Form::month('month', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3 date d-none">
                                    <div class="form-group">
                                        {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
                                        {{ Form::date('date', isset($_GET['date']) ? $_GET['date'] : '', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 range d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                                {{ Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                                {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(\Auth::user()->type != 'employee')
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                            {{ Form::select('branch', $branch, isset($_GET['branch']) ? $_GET['branch'] : '', ['class' => 'form-control select', 'id' => 'branch']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                            {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control select', 'id' => 'department']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" id="employee_div">
                                            {{ Form::label('employee', __('Employee'), ['class' => 'form-label']) }}
                                            <select class="form-control select" name="employee_id[]" id="employee" multiple>
                                                @foreach ($employees as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-auto mt-4">
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" title="{{__('Apply')}}">
                                        <i class="ti ti-search"></i> {{__('Apply')}}
                                    </button>
                                    <a href="{{route('attendanceemployee.index')}}" class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                        <i class="ti ti-trash-off text-white-off"></i> {{ __('Reset') }}
                                    </a>
                                    <a href="#" data-size="md" data-bs-toggle="tooltip" title="{{__('Import')}}" data-url="{{ route('attendance.file.import') }}" data-ajax-popup="true" data-title="{{__('Import employee CSV file')}}" class="btn btn-primary">
                                        <i class="ti ti-file-import"></i> {{__('Import')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    @if(\Auth::user()->type!='Employee')
                                        <th>{{__('Employee')}}</th>
                                    @endif
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Clock In')}}</th>
                                    <th>{{__('Clock Out')}}</th>
                                    <th>{{__('Late')}}</th>
                                    <th>{{__('Early Leaving')}}</th>
                                    <th>{{__('Overtime')}}</th>
                                    @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                        <th>{{__('Action')}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendanceEmployee as $attendance)
                                    <tr>
                                        @if(\Auth::user()->type!='Employee')
                                            <td>{{!empty($attendance->employee)?$attendance->employee->name:'' }}</td>
                                        @endif
                                        <td>{{ \Auth::user()->dateFormat($attendance->date) }}</td>
                                        <td>{{ $attendance->status }}</td>
                                        <td>{{ ($attendance->clock_in !='00:00:00') ?\Auth::user()->timeFormat( $attendance->clock_in):'00:00' }} </td>
                                        <td>{{ ($attendance->clock_out !='00:00:00') ?\Auth::user()->timeFormat( $attendance->clock_out):'00:00' }}</td>
                                        <td>{{ $attendance->late }}</td>
                                        <td>{{ $attendance->early_leaving }}</td>
                                        <td>{{ $attendance->overtime }}</td>
                                        @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                            <td>
                                                @can('edit attendance')
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-url="{{ URL::to('attendanceemployee/'.$attendance->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Attendance')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                @endcan
                                                @can('delete attendance')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['attendanceemployee.destroy', $attendance->id],'id'=>'delete-form-'.$attendance->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                           data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$attendance->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
