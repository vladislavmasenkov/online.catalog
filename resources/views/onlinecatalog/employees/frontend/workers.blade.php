@if($employee)
    <div class="card">
        <div class="row employee-cart">
            <div class="col-md-2 col-xs-4">
                <img src="@if($employee->avatar){{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}
                @else {{asset('images/onlinecatalog/employees/avatar.default.png')}} @endif">
            </div>
            <div class="col-md-10 col-xs-8">
                <div class="employee-name">{{$employee->first_name}} {{$employee->last_name}}</div>
                <div class="employee-position">{{$employee->position->name}} </div>
                <div class="employment-date">Дата приема на работу: <span>{{$employee->employment_date}}</span></div>
                <div class="employee-wage">Заработная плата: <span>${{$employee->wage}}</span></div>
            </div>
        </div>
    </div>
@endif

@if($workers)
    @foreach($workers as $worker)
        <div class="card card-default">
            <div class="card-header">
                <a data-toggle="collapse" data-parent="#acordion"
                   href="#employee-{{$worker->id}}-workers" data-employee-id="{{$worker->id}}">
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
