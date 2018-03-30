@extends('onlinecatalog.layout-frontend')


@section('employees-tree')
    <div class="col-md-12">
        <div class="employees-list" id="accordion">
            @foreach($employees as $employee)
                <div class="card">
                    <div class="card-header">
                        <a data-toggle="collapse" data-parent="#acordion"
                           href="#employee-{{$employee->id}}-workers" data-employee-id="{{$employee->id}}">
                            <span class="glyphicon glyphicon-user"></span>
                            <strong>{{$employee->first_name}} {{$employee->last_name}}</strong>
                            {{$employee->position->name}}
                        </a>
                    </div>
                    <div id="employee-{{$employee->id}}-workers" class="employee-workers card-collapse collapse">
                        <div class="card-body">
                            <div class="card">
                                <div class="row employee-cart">
                                    <div class="col-md-2 col-xs-4">
                                        <img src="@if($employee->avatar){{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}@else {{asset('images/onlinecatalog/employees/avatar.default.png')}}@endif">
                                    </div>
                                    <div class="col-md-10 col-xs-8">
                                        <div class="employee-name">{{$employee->last_name}} {{$employee->first_name}} {{$employee->middle_name}}</div>
                                        <div class="employee-position">{{$employee->position->name}} </div>
                                        <div class="employment-date">Дата приема на работу: <span>{{$employee->employment_date}}</span></div>
                                        <div class="employee-wage">Заработная плата: <span>${{$employee->wage}}</span></div>
                                    </div>
                                </div>
                            </div>
                            @if($employee->workers)
                                @foreach($employee->workers as $worker)
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <a data-toggle="collapse" data-parent="#acordion"
                                               href="#employee-{{$worker->id}}-workers"
                                               data-employee-id="{{$worker->id}}">
                                                <span class="glyphicon glyphicon-user"></span>
                                                <strong>{{$worker->first_name}} {{$worker->last_name}}</strong>
                                                {{$worker->position->name}}
                                            </a>
                                        </div>
                                        <div id="employee-{{$worker->id}}-workers"
                                             class="employee-workers card-collapse collapse">
                                            <div class="card-body">
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

    <script>
        $(document).on('click', '.card-header a', function () {
            var employee_item = $(this);
            var employee_workers = employee_item.parents('.card-header').siblings('.card-collapse').children('.card-body');
            if (employee_workers.children('.card-default').length === 0) {
                var action = '/employees/' + employee_item.data('employee-id') + '/workers';
                $.ajax({
                    method: 'GET',
                    url: action
                }).done(function (result) {
                    employee_workers.html(result);
                    $('.employees-list .card').draggable({
                        axis: "y",
                        refreshPositions:true,
                        revert: true,
                        opacity: 0.5,
                        cursor: "pointer",
                        zIndex:100
                    });
                    $('.employee-workers .card-body').droppable({
                        accept:'.employees-list .card',
                        greedy:true,
                        deactivate: function(event,ui) {
                            $(this).removeClass('droppable');
                        },
                        over: function (event,ui) {
                            $(this).addClass('droppable');
                        },
                        out: function (event,ui) {
                            $(this).removeClass('droppable');
                        },
                        drop:function(event,ui){
                            var droppable = $(this);
                            var employee_id = $(ui.draggable).find('.card-header a').data('employee-id');
                            var director_id = $(this).parents('.employee-workers').parents('.card').find('.card-header a').data('employee-id');

                            var formdata = new FormData();
                            formdata.append('director_id',director_id);
                            formdata.append('_token', '{{csrf_token()}}');
                            formdata.append('_method', 'PUT');

                            $.ajax({
                                method:'POST',
                                url:'/employees/'+employee_id+'/director',
                                processData: false,
                                contentType: false,
                                data: formdata
                            }).done(function(result){
                                droppable.append(ui.draggable);
                                Notify.generate(result.message,'Готово',0);
                            }).fail(function(result) {
                                showErrorMessages(result);
                            });
                        }
                    });
                }).fail(function(result) {
                    showErrorMessages(result);
                });
            }
        });


        $('.employees-list .card').draggable({
            axis: "y",
            refreshPositions:true,
            revert: true,
            opacity: 0.5,
            cursor: "pointer",
            zIndex:100
        });
        $('.employee-workers .card-body').droppable({
            accept:'.employees-list .card',
            greedy:true,
            deactivate: function(event,ui) {
                $(this).removeClass('droppable');
            },
            over: function (event,ui) {
                $(this).addClass('droppable');
            },
            out: function (event,ui) {
                $(this).removeClass('droppable');
            },
            drop:function(event,ui){
                var droppable = $(this);
                var employee_id = $(ui.draggable).find('.card-header a').data('employee-id');
                var director_id = $(this).parents('.employee-workers').parents('.card').find('.card-header a').data('employee-id');

                var formdata = new FormData();
                formdata.append('director_id',director_id);
                formdata.append('_token', '{{csrf_token()}}');
                formdata.append('_method', 'PUT');

                $.ajax({
                    method:'POST',
                    url:'/employees/'+employee_id+'/director',
                    processData: false,
                    contentType: false,
                    data: formdata
                }).done(function(result){
                    droppable.append(ui.draggable);
                    Notify.generate(result.message,'Готово',0);
                }).fail(function(result) {
                    showErrorMessages(result);
                });
            }
        });
    </script>
@endsection

