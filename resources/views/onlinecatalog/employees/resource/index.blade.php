@extends('onlinecatalog.layout-resource')

@section('employees-navbar')
    <div class="row">
        <div class="col-md-12 col-xs-12 navbar-action-list-btn">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="d-inline-block action-btn" id="employees-btn-reload-list"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                    <div class="d-inline-block action-btn" id="employees-btn-add"><i class="fa fa-plus" aria-hidden="true"></i></div>
                    <div class="d-inline-block action-btn hidden" id="employees-btn-delete-many"><i class="fa fa-trash" aria-hidden="true"></i></div>
                </li>
                <li class="list-group-item">
                    <div id="filter-tags" class="d-inline-block">
                    </div>
                    <div class="d-inline-block">
                        <input id="filter-input" placeholder="Поиск">
                        <div id="filter-fields"  hidden></div>
                    </div>
                </li>
            </ul>
            <input id="orderby" type="hidden" name="orderby">
            <input id="order" type="hidden" name="order">
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
    @if($employees->items())
    <div class="employees-list-block">
        <div class="row">
            <div class="col-md-12 col-xs-12 employees-list">
                <ul class="list-group">
                    @foreach($employees as $employee)
                        <li class="list-group-item list-group-item-action employees-list-item" data-employee-id="{{$employee->id}}">
                            <input type="checkbox" class="employee-item-chekbox d-inline-block">
                            <div class="employee-item-id d-inline-block">{{$employee->id}}</div>
                            <div class="employee-item-avatar d-inline-block">
                                <img src="@if($employee->avatar){{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}@else {{asset('images/onlinecatalog/employees/avatar.default.png')}}@endif">
                            </div>
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
    @else
        <div class="row">
            <div class="col-md-12 col-xs-12 not-found-result">
                <div class="content d-inline-flex">
                    <div class="not-found-img">
                        <img src="{{asset('images/onlinecatalog/other/notfoundresult.png')}}">
                    </div>
                    <div class="not-found-message">
                        <div class="message">{{Lang::get('messages.notFoundResult')}}</div>
                        <div class="link"><a
                                    href="{{route('employees.index')}}">{{Lang::get('messages.backToMainPage')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
