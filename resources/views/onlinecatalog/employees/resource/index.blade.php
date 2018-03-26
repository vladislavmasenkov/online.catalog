@extends('onlinecatalog.layout-resource')

@section('employees-navbar')
    <div class="row">
        <div class="col-md-12 col-xs-12 navbar-action-list-btn">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="d-inline-block action-btn" id="reload-list-btn"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                    <div class="d-inline-block action-btn" id="add-employee-btn"><i class="fa fa-plus" aria-hidden="true"></i></div>
                    <div class="d-inline-block action-btn hidden" id="delete-employee-btn"><i class="fa fa-trash" aria-hidden="true"></i></div>
                </li>
            </ul>
            <input id="orderby" type="hidden" name="orderby">
            <input id="order" type="hidden" name="order">
            <input id="filter" type="hidden" name="filter">
            <input id="page" type="hidden" name="page" value="{{$employees->currentPage()}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 employees-columns">
            <ul class="list-group">
                <li class="list-group-item employees-list-item employees-navbar">
                    <input type="checkbox" class="employee-item-chekbox d-inline-block">
                    <div data-name="id" class="employee-item-id d-inline-block item-order">ID</div>
                    <div data-name="avatar" class="employee-item-avatar d-inline-block item-order">Фото</div>
                    <div data-name="first_name" class="employee-item-name d-inline-block item-order">Имя</div>
                    <div data-name="position_id" class="employee-item-position d-inline-block item-order">Должность</div>
                    <div data-name="wage" class="employee-item-wage d-inline-block item-order">Зарплата</div>
                    <div data-name="employment_date" class="employee-item-employment-date d-inline-block item-order">Дата</div>
                    <div data-name="director_id" class="employee-item-director d-inline-block item-order">Начальник</div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('employees-list')
    <div class="employees-list-block">
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
    </div>
@endsection
