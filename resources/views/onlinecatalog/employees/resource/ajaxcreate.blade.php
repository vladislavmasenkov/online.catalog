<div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">Создание новой записи</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <form class="employee-form-create employee-form row" method="POST">
                <div class="col-6">
                    <div class="form-group">
                        <label for="input-avatar">
                            <div class="employee-avatar" for="input-avatar">
                                <img src="{{asset('images/onlinecatalog/employees/avatar.default.png')}}">
                            </div>
                        </label>
                        <input type="file" id="input-avatar" name="input-avatar" class="form-control"
                               placeholder="Аватар" accept="image/jpeg,image/png" hidden>
                    </div>
                    <div class="form-group">
                        <label for="input-first-name">Имя</label>
                        <input id="input-first-name" name="input-first-name" class="form-control" placeholder="Имя">
                    </div>
                    <div class="form-group">
                        <label for="input-last-name">Фамилия</label>
                        <input id="input-last-name" name="last_name" class="form-control" placeholder="Фамилия">
                    </div>
                    <div class="form-group">
                        <label for="input-middle-name">Отчество</label>
                        <input id="input-middle-name" name="middle_name" class="form-control" placeholder="Отчество">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="input-employment-date">Дата приема на работу</label>
                        <input id="input-employment-date" type="date" name="employment_date" class="form-control"
                               placeholder="Дата приема на работу">
                    </div>
                    <div class="form-group">
                        <label for="input-position">Должность</label>
                        <select id="input-position" class="form-control" name="position" size="5">
                            @foreach($positions as $position)
                                <option value="{{$position->id}}">{{$position->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-wage">Зарплата</label>
                        <input id="input-wage" type="number" class="form-control" name="wage" placeholder="Зарплата">
                    </div>
                    <div class="form-group">
                        <label for="input-director">Начальник</label>
                        <div id="input-director">
                            <input class="d-inline-block form-control form-inline" value="" name="director" data-directorid="0">
                            <i class="fa fa-close delete-btn" aria-hidden="true"></i>
                            <i class="fa fa-search search-btn" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <button type="button" class="btn btn-success" id="employee-btn-create">Создать</button>
        </div>


    </div>
</div>