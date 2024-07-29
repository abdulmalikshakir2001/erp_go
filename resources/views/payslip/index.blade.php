@extends('layouts.admin')

@section('page-title')
{{ __('Payslip') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Payslip') }}</li>
@endsection

@section('content')
<div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 mt-4">
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['payslip.store'], 'method' => 'POST', 'id' => 'payslip_form']) }}
            <div class="d-flex align-items-center justify-content-end">
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                    <div class="btn-box">
                        {{ Form::label('month', __('Select Month'), ['class' => 'form-label']) }}
                        {{ Form::select('month', $month, date('m'), ['class' => 'form-control select', 'id' => 'month']) }}
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                    <div class="btn-box">
                        {{ Form::label('year', __('Select Year'), ['class' => 'form-label']) }}
                        {{ Form::select('year', $year, date('Y'), ['class' => 'form-control select', 'id' => 'year']) }}
                    </div>
                </div>
                <div class="col-auto float-end ms-2 mt-4">
                    <a href="#" class="btn btn-primary" onclick="document.getElementById('payslip_form').submit(); return false;" data-bs-toggle="tooltip" title="{{ __('Payslip') }}" data-original-title="{{ __('Payslip') }}">{{ __('Generate Payslip') }}</a>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-start mt-2">
                        <h5>{{ __('Find Employee Payslip') }}</h5>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                <select class="form-control month_date" id="month_date" name="month" tabindex="-1" aria-hidden="true">
                                    <option value="--">--</option>
                                    @foreach($month as $k=>$mon)
                                    @php
                                    $selected = ((date('m')) == $k) ? 'selected' :'';
                                    @endphp
                                    <option value="{{$k}}" {{ $selected }}>{{$mon}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 me-2">
                            <div class="btn-box">
                                {{ Form::select('year', $year, date('Y'), ['class' => 'form-control year_date', 'id' => 'year_date']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end me-2">
                            {{ Form::open(['route' => ['payslip.export'], 'method' => 'POST', 'id' => 'payslip_form']) }}
                            <input type="hidden" name="filter_month" class="filter_month">
                            <input type="hidden" name="filter_year" class="filter_year">
                            <input type="submit" value="{{ __('Export') }}" class="btn btn-primary">
                            {{ Form::close() }}
                        </div>
                        <div class="col-auto float-end me-0">
                            @can('create pay slip')
                            <input type="button" value="{{ __('Bulk Payment') }}" class="btn btn-primary" id="bulk_payment">
                            <input type="button" value="{{ __('Click To Paid') }}" class="btn btn-primary" id="bulk_paid">
                            <input type="button" value="{{ __('Delete') }}" class="btn btn-danger" id="bulk_delete"> <!-- Add this line -->
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="pc-dt-render-column-cells">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"></th>
                            <th>{{ __('Employee Id') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Payroll Type') }}</th>
                            <th>{{ __('Salary') }}</th>
                            <th>{{ __('Net Salary') }}</th>
                            <th>{{ __('Deduction') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    class SelectAllCheckbox {
        constructor(selectAllSelector, recordSelector, datatableInstance) {
            this.selectAllSelector = selectAllSelector;
            this.recordSelector = recordSelector;
            this.datatable = datatableInstance;
            this.pageSelectedRows = {};
            this.selectAllState = {};

            this.init();
        }

        init() {
            $(document).on('change', this.selectAllSelector, (e) => this.toggleSelectAll(e));
            $(document).on('change', this.recordSelector, (e) => this.toggleRecord(e));

            // Handle page change event
            this.datatable.on('datatable.page', (page) => {
                $(this.selectAllSelector).prop('checked', this.selectAllState[page.index] || false);
                this.restoreCheckboxState(page.index);
            });
        }

        toggleSelectAll(e) {
            const isChecked = $(e.target).is(':checked');
            $(this.recordSelector).prop('checked', isChecked);

            // Update selectedRows state
            this.updateSelectedRows(isChecked);

            // Store the select all state for the current page
            this.selectAllState[this.datatable.page] = isChecked;
        }

        toggleRecord(e) {
            const isChecked = $(e.target).is(':checked');
            const id = $(e.target).data('id');
            const currentPage = this.datatable.page;

            if (!isChecked) {
                $(this.selectAllSelector).prop('checked', false);
                this.selectAllState[currentPage] = false;
            }

            // Update selectedRows state
            if (!this.pageSelectedRows[currentPage]) {
                this.pageSelectedRows[currentPage] = {};
            }
            this.pageSelectedRows[currentPage][id] = isChecked;

            // Check if all checkboxes are selected on the current page
            if ($(this.recordSelector + ':checked').length === $(this.recordSelector).length) {
                $(this.selectAllSelector).prop('checked', true);
                this.selectAllState[currentPage] = true;
            }
        }

        updateSelectedRows(isChecked) {
            const currentPage = this.datatable.page;

            $(this.recordSelector).each((_, element) => {
                const id = $(element).data('id');

                if (!this.pageSelectedRows[currentPage]) {
                    this.pageSelectedRows[currentPage] = {};
                }

                this.pageSelectedRows[currentPage][id] = isChecked;
            });
        }

        restoreCheckboxState(pageIndex) {
            const currentPage = pageIndex || this.datatable.page;

            if (this.pageSelectedRows[currentPage]) {
                $(this.recordSelector).each((_, element) => {
                    const id = $(element).data('id');
                    if (this.pageSelectedRows[currentPage][id]) {
                        $(element).prop('checked', true);
                    }
                });

                // Update "select all" checkbox based on individual checkbox states
                if ($(this.recordSelector + ':checked').length === $(this.recordSelector).length) {
                    $(this.selectAllSelector).prop('checked', true);
                } else {
                    $(this.selectAllSelector).prop('checked', false);
                }
            }
        }
        resetActiveLinkSelections() {
            // Reset select all state
            $(this.selectAllSelector).prop('checked', false);

            // Reset individual checkbox states
            $(this.recordSelector).prop('checked', false);

            // Clear selection states
            this.pageSelectedRows = {};
            this.selectAllState = {};
        }

    }

    $(document).ready(function () {
        var datatable;

        // Load saved month and year from local storage
        var savedMonth = localStorage.getItem('selectedMonth') || '{{ date("m") }}';
        var savedYear = localStorage.getItem('selectedYear') || '{{ date("Y") }}';

        $('#month_date').val(savedMonth);
        $('#year_date').val(savedYear);

        callback();

        function callback() {
            var month = $("#month_date").val();
            var year = $("#year_date").val();

            $('.filter_month').val(month);
            $('.filter_year').val(year);

            var datePicker = year + '-' + month;

            $.ajax({
                url: '{{route('payslip.search_json')}}',
                type: 'POST',
                data: {
                    "datePicker": datePicker,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    var tr = '';
                    if (data.length > 0) {
                        $.each(data, function (indexInArray, valueOfElement) {
                            var status = '<div class="badge bg-danger p-2 px-3 rounded"><a href="#" class="text-white">' + valueOfElement[7] + '</a></div>';
                            if (valueOfElement[7] == 'Paid') {
                                status = '<div class="badge bg-success p-2 px-3 rounded"><a href="#" class="text-white">' + valueOfElement[7] + '</a></div>';
                            }

                            var id = valueOfElement[0];
                            var employee_id = valueOfElement[1];
                            var payslip_id = valueOfElement[8];
                            var deduction = valueOfElement[6]; // Deduction value from server

                            var payslip = '';
                            if (valueOfElement[8] != 0) {
                                payslip = '<a href="#" data-url="{{url('payslip/pdf/')}}/'+id+'/'+datePicker+'" data-size="lg"  data-ajax-popup="true" class="btn-sm btn btn-warning" data-title="{{ __('Employee Payslip') }}">' + '{{ __('Payslip') }}' + '</a> ';
                            }
                            var clickToPaid = '';
                            if (valueOfElement[7] == "UnPaid" && valueOfElement[8] != 0) {
                                clickToPaid = '<a href="{{url('payslip/paysalary/')}}/' + id + '/' + datePicker + '"  class="btn-sm btn btn-primary">' + '{{ __('Click To Paid') }}' + '</a>  ';
                            }

                            var edit = '';
                            if (valueOfElement[8] != 0 && valueOfElement[7] == "UnPaid") {
                                edit = '<a href="#" data-url="{{url('payslip/editemployee/')}}/' + payslip_id + '"  data-ajax-popup="true" class="btn-sm btn btn-info" data-title="{{ __('Edit Employee salary') }}">' + '{{ __('Edit') }}' + '</a>';
                            }

                            var url = '{{route('payslip.delete', ':id')}}';
                        url = url.replace(':id', payslip_id);
                        var deleted = '';
                        @if (\Auth:: user() -> type != 'Employee')
            if (valueOfElement[8] != 0) {
                deleted = '<a href="#"  data-url="' + url + '" class="payslip_delete view-btn btn btn-danger ms-1 btn-sm"  >' + '{{ __('Delete') }}' + '</a>';
            }
            @endif
            var url_employee = valueOfElement['url'];

            tr += '<tr> ' +
                '<td><input type="checkbox" class="select_record" data-id="' + id + '" data-payslip_id="' + payslip_id + '"></td> ' +
                '<td> <a class="btn btn-outline-primary" href="' + url_employee + '">' + valueOfElement[1] + '</a></td> ' +
                '<td>' + valueOfElement[2] + '</td> ' +
                '<td>' + valueOfElement[3] + '</td>' +
                '<td>' + valueOfElement[4] + '</td>' +
                '<td>' + valueOfElement[5] + '</td>' +
                '<td>' + deduction + '</td>' + // Add Deduction value
                '<td>' + status + '</td>' +
                '<td>' + payslip + clickToPaid + edit + deleted + '</td>' +
                '</tr>';
        });
                    } else {
        var colspan = $('#pc-dt-render-column-cells thead tr th').length;
        tr = '<tr><td class="dataTables-empty" colspan="' + colspan + '">{{ __('No entries found') }}</td></tr>';
    }

    // Destroy existing datatable before creating a new one
    if (datatable) {
        datatable.destroy();
        $('#pc-dt-render-column-cells tbody').empty();
    }

    $('#pc-dt-render-column-cells tbody').html(tr);

    datatable = new simpleDatatables.DataTable("#pc-dt-render-column-cells", {
        sortable: true,
        fixedHeight: true,
        columns: [{
            select: 0,
            sortable: false
        }]
    });

    // Initialize the SelectAllCheckbox class after the datatable is created
    const selectAllCheckbox = new SelectAllCheckbox('#select_all', '.select_record', datatable);

    // Restore selected checkboxes state
    selectAllCheckbox.restoreCheckboxState();

    // Set initial state for select all checkbox based on selectAllState
    $(selectAllCheckbox.selectAllSelector).prop('checked', selectAllCheckbox.selectAllState[datatable.page] || false);
                    
                },
    error: function (data) {
        // Handle error
    }
            });
        }

    $(document).on("change", ".month_date,.year_date", function () {
        // Save selected month and year to local storage
        localStorage.setItem('selectedMonth', $('#month_date').val());
        localStorage.setItem('selectedYear', $('#year_date').val());
        callback();
    });


    // Bulk payment click
    $(document).on("click", "#bulk_payment", function () {
        var month = $(".month_date").val();
        var year = $(".year_date").val();
        var datePicker = year + '_' + month;
    });

    $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
        var month = $(".month_date").val();
        var year = $(".year_date").val();
        var datePicker = year + '-' + month;

        var title = 'Bulk Payment';
        var size = 'md';
        var url = 'payslip/bulk_pay_create/' + datePicker;

        $("#commonModal .modal-title").html(title);
        $("#commonModal .modal-dialog").addClass('modal-' + size);
        $.ajax({
            url: url,
            success: function (data) {
                if (data.length) {
                    $('#commonModal .body').html(data);
                    $("#commonModal").modal('show');
                } else {
                    show_toastr('error', 'Permission denied.');
                    $("#commonModal").modal('hide');
                }
            },
            error: function (data) {
                data = data.responseJSON;
                show_toastr('error', data.error);
            }
        });
    });

    $(document).on("click", "#bulk_paid", function () {
        var selectedIds = [];
        $('.select_record:checked').each(function () {
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            var datePicker = $("#year_date").val() + '-' + $("#month_date").val();
            $.ajax({
                url: '{{route('payslip.bulkpay')}}',
                type: 'POST',
                data: {
                    "ids": selectedIds,
                    "datePicker": datePicker,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        show_toastr('success', response.message);
                        callback();  // Refresh datatable content
                    } else {
                        show_toastr('error', response.message);
                    }
                },
                error: function (xhr) {
                    show_toastr('error', '{{ __('An error occurred while processing your request.') }}');
        }
    });
            } else {
        show_toastr('error', '{{ __('Please select at least one record.') }}');
    }
        });

    $(document).on("click", ".payslip_delete", function (event) {
        event.preventDefault();

        var confirmation = confirm("Are you sure you want to delete this payslip?");
        var url = $(this).data('url');

        if (confirmation) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function (data) {
                    show_toastr('success', 'Payslip Deleted Successfully', 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 800)
                },
            });
        }
    });

    
    $(document).on("click", "#bulk_delete", function () {
    var selectedIds = [];
    $('.select_record:checked').each(function () {
        selectedIds.push($(this).data('payslip_id'));
    });

    if (selectedIds.length > 0) {
        var confirmation = confirm("Are you sure you want to delete the selected payslips?");
        if (confirmation) {
            $.ajax({
                url: '{{route('payslip.bulk_delete')}}',
                type: 'POST',
                data: {
                    "ids": selectedIds,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        show_toastr('success', response.message);
                        callback();  // Refresh datatable content
                    } else {
                        show_toastr('error', response.message);
                    }
                },
                error: function (xhr) {
                    show_toastr('error', '{{ __('An error occurred while processing your request.') }}');
                }
            });
        }
    } else {
        show_toastr('error', '{{ __('Please select at least one record.') }}');
    }
});

        
    });
</script>
@endpush
