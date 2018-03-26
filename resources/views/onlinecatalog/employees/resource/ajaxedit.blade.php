<div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">{{$employee->first_name}} {{$employee->last_name}} {{$employee->middle_name}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <form class="employee-form-edit row" data-employee-id="{{$employee->id}}" method="POST">
                <div class="col-6">
                    <div class="form-group">
                        <label for="input-first-name">Имя</label>
                        <input id="input-first-name" name="input-first-name" class="form-control" placeholder="Имя"
                               value="{{$employee->first_name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-last-name">Фамилия</label>
                        <input id="input-last-name" name="last_name" class="form-control" placeholder="Фамилия"
                               value="{{$employee->last_name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-middle-name">Отчество</label>
                        <input id="input-middle-name" name="middle_name" class="form-control" placeholder="Отчество"
                               value="{{$employee->middle_name}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="input-employment-date">Дата приема на работу</label>
                        <input id="input-employment-date" type="date" name="employment_date" class="form-control"
                               placeholder="Дата приема на работу" value="{{$employee->employment_date}}">
                    </div>
                    <div class="form-group">
                        <label for="input-position">Должность</label>
                        <select id="input-position" class="form-control" name="position">
                            <option value="{{$employee->position->id}}">{{$employee->position->name}}</option>
                            @foreach($positions as $position)
                                <option value="{{$position->id}}">{{$position->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-wage">Зарплата</label>
                        <input id="input-wage" type="number" class="form-control" name="wage" placeholder="Зарплата"
                               value="{{$employee->wage}}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="input-director">Начальник</label>
                        <select id="input-director" class="form-control" name="director">
                            @if($employee->director_id)
                                <option value="{{$employee->director_id}}">{{$employee->director->first_name}}</option>
                                <option value="0">-</option>
                            @else
                                <option value="0">-</option>
                            @endif
                            {{--@foreach($directors as $director)--}}
                                {{--<option value="{{$director->id}}">{{$director->first_name}} {{$director->last_name}}</option>--}}
                            {{--@endforeach--}}
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success"  id="employee-btn-update" data-dismiss="modal">Save</button>
        </div>


    </div>
</div>