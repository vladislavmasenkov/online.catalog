<div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">{{$employee->first_name}} {{$employee->last_name}} {{$employee->middle_name}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <form class="employee-form-edit employee-form row" data-employee-id="{{$employee->id}}" method="POST">
                <div class="col-6">
                    <div class="form-group">
                        <label for="input-avatar">
                            <div class="employee-avatar" for="input-avatar">
                                <img src="@if($employee->avatar)
                                {{ asset('images/onlinecatalog/employees/'.$employee->avatar)}}
                                @else {{asset('images/onlinecatalog/employees/avatar.default.png')}}
                                @endif">
                            </div>
                        </label>
                        <input type="file" id="input-avatar" name="input-avatar" class="form-control"
                               placeholder="Аватар" accept="image/jpeg,image/png" hidden>
                    </div>
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
                        <select id="input-position" class="form-control" name="position" size="5">
                            <option value="{{$employee->position->id}}" selected>{{$employee->position->name}}</option>
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
                    <div class="form-group">
                        <label for="input-director">Начальник</label>
                        <div id="input-director">
                            <input class="d-inline-block form-control form-inline"
                                   value="@if($employee->director_id){{$employee->director->first_name}} {{$employee->director->last_name}}@endif"
                                   name="director" data-directorid="{{$employee->director_id or 0}}">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="employee-btn-delete" data-dismiss="modal">Удалить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-success" id="employee-btn-update">Сохранить
            </button>
        </div>


    </div>
</div>
<script>
    $(document).on('click', '.employee-form #input-director', function () {
        var employeeid = $(this).parents('.employee-form').data('employee-id');
        $.ajax({
            method: 'GET',
            url: 'employees/directors/' + ((employeeid)?employeeid:0),
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        }).done(function (result) {
            $('#employee-director-modal').html(result);
            $('#employee-director-modal').modal('show');
        }).fail(function (result) {
            showErrorMessages(result);
        });
    });

    $(document).on('click', '#employee-director-modal li.director-list-item', function (event) {
        $('#input-director input').data('directorid', $(this).data('employee-id'));
        $('#input-director input').val($(this).find('.employee-item-name').text());
        $('#employee-director-modal').modal('hide');
    });

    $(document).on('click','#employee-director-modal .pagination a',function(event){
        event.preventDefault();
        $.ajax({
            method: 'GET',
            url: $(this).prop('href'),
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        }).done(function (result) {
            $('#employee-director-modal').html(result);
        }).fail(function (result) {
            showErrorMessages(result);
        });
    });
</script>