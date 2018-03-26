@if($employee)
    <div class="panel">
        <div class="row employee-cart">
            <div class="col-md-2 col-xs-4">
                <img src="@if($employee->avatar){{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}
                @else {{asset('images/onlinecatalog/employees/avatar.default.png')}} @endif">
            </div>
            <div class="col-md-10 col-xs-8">
                <div class="employee-name">{{$employee->first_name}} {{$employee->last_name}}</div>
                <div class="employee-position">{{$employee->position->name}} </div>
                <div class="employment-date">Дата приема на работу: <span>{{$employee->employment_date}}</span></div>
            </div>
        </div>
    </div>
@endif

@if($workers)
    @foreach($workers as $worker)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#acordion"
                       href="#employee-{{$worker->id}}-workers" data-employee-id="{{$worker->id}}">
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
