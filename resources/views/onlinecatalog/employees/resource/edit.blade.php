<form class="employee-form-edit">
    <div class="form-group">
        <input name="first_name" placeholder="Имя" value="{{$employee->first_name}}">
    </div>
    <div class="form-group">
        <input name="last_name" placeholder="Имя" value="{{$employee->last_name}}">
    </div>
    <div class="form-group">
        <input name="middle_name" placeholder="Имя" value="{{$employee->middle_name}}">
    </div>
    <div class="form-group">
        <input type="date" name="employment_date" placeholder="Имя" value="{{$employee->employment_date}}">
    </div>
    <div class="form-group">
        <select class="form-control" name="position">
            <option value="{{$employee->position->id}}">{{$employee->position->name}}</option>
            @foreach($positions as $position)
                <option value="{{$position->id}}">{{$position->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <input type="number" name="wage" placeholder="Имя" value="{{$employee->wage}}">
    </div>
    <div class="form-group">
        <select class="form-control" name="director">
            {{--@if($employee->position)--}}
                {{--<option value="{{$employee->director}}">{{$employee->director}}</option>--}}
                {{--<option value="0">-</option>--}}
            {{--@else--}}
                <option value="0">-</option>
            {{--@endif--}}
            {{--@foreach($directors as $director)--}}
                {{--<option value="{{$director->id}}">{{$director->first_name}} {{$director->last_name}}</option>--}}
            {{--@endforeach--}}
        </select>
    </div>
</form>