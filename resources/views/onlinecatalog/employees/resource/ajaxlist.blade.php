
@section('employees-list')
    <div class="row">
        <div class="col-md-12 col-xs-12 employees-list">
            <ul class="list-group">
                @foreach($employees as $employee)
                    <li class="list-group-item list-group-item-action employees-list-item" data-employee-id="{{$employee->id}}">
                        <input type="checkbox" class="employee-item-chekbox d-inline-block">
                        <div class="employee-item-id d-inline-block">{{$employee->id}}</div>
                        <div class="employee-item-avatar d-inline-block">{{$employee->avatar}}</div>
                        <div class="employee-item-name d-inline-block">{{$employee->first_name}} {{$employee->last_name}} {{$employee->middle_name}}</div>
                        <div class="employee-item-position d-inline-block">{{$employee->position->name}}</div>
                        <div class="employee-item-wage d-inline-block">{{$employee->wage}}</div>
                        <div class="employee-item-employment-date d-inline-block">{{$employee->employment_date}}</div>
                        <div class="employee-item-director d-inline-block">{{$employee->director->first_name or '-'}}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="pagination-center">
            {{$employees->render()}}
        </div>
    </div>
@show