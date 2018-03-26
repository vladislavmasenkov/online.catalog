@extends('onlinecatalog.layout-frontend')


@section('employees-tree')
    <div class="col-md-12">
        <div class="employees-list">
            <div class="panel-group" id="accordion">
                @foreach($employees as $employee)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#acordion"
                                   href="#employee-{{$employee->id}}-workers" data-employee-id="{{$employee->id}}">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <strong>{{$employee->first_name}} {{$employee->last_name}}</strong>
                                    {{$employee->position->name}}
                                </a>
                            </h4>
                        </div>
                        <div id="employee-{{$employee->id}}-workers" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="panel">
                                    <div class="row employee-cart">
                                        <div class="col-md-2 col-xs-4">
                                            <img src="@if($employee->avatar){{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}
                                            @else {{asset('images/onlinecatalog/employees/avatar.default.png')}} @endif">
                                        </div>
                                        <div class="col-md-10 col-xs-8">
                                            <div class="employee-name">{{$employee->first_name}} {{$employee->last_name}}</div>
                                            <div class="employee-position">{{$employee->position->name}} </div>
                                            <div class="employment-date">Дата приема на работу:
                                                <span>{{$employee->employment_date}}</span></div>
                                        </div>
                                    </div>
                                </div>
                                @if($employee->workers)
                                    @foreach($employee->workers as $worker)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#acordion"
                                                       href="#employee-{{$worker->id}}-workers"
                                                       data-employee-id="{{$worker->id}}">
                                                        <span class="glyphicon glyphicon-user"></span>
                                                        <strong>{{$worker->first_name}} {{$worker->last_name}}</strong>
                                                        {{$worker->position->name}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="employee-{{$worker->id}}-workers"
                                                 class="panel-collapse collapse">
                                                <div class="panel-body">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.panel-title a', function () {
            var employee_item = $(this);
            var employee_workers = employee_item.parents('.panel-heading').siblings('.panel-collapse').children('.panel-body');
            if (employee_workers.children('.panel-default').length === 0) {
                var action = '/employees/' + employee_item.data('employee-id') + '/workers';
                $.ajax({
                    method: 'GET',
                    url: action
                }).done(function (result) {
                    employee_workers.html(result);
                });
            }
        });
    </script>
@endsection

