@section('employees-list')
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body directors-list">
                <ul class="list-group">
                    @foreach($employees as $employee)
                        <li class="list-group-item list-group-item-action director-list-item"
                            data-employee-id="{{$employee->id}}">
                            <div class="employee-item-id d-inline-block">{{$employee->id}}</div>
                            <div class="employee-item-name d-inline-block">{{$employee->first_name}} {{$employee->last_name}} {{$employee->middle_name}}</div>
                            <div class="employee-item-position d-inline-block">{{$employee->position->name}}</div>
                        </li>
                    @endforeach
                </ul>
                <div class="row">
                    <div class="pagination-center">
                        {{$employees->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@show