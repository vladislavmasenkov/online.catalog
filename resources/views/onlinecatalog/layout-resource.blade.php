<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="container col-md-11">
    @yield('employees-navbar')
    @yield('employees-list')
</div>
@section('employees-card')
    <div id="employee-card-modal" class="modal fade" role="dialog">
    </div>
@show
<div id="notifies"></div>
<script>
    $(document).ready(function () {

        $(document).on('click', '.employees-navbar .item-order', function () {
            $(this).data('order', ($(this).data('order') === 'desc') ? 'asc' : 'desc');

            $('#orderby').val($(this).data('name'));
            $('#order').val($(this).data('order'));
            reloadList();

            $(this).removeClass(($(this).data('order') === 'desc') ? 'asc' : 'desc');
            $(this).addClass($(this).data('order'));
            $('.employees-navbar .item-order.active').removeClass('active');
            $(this).addClass('active');

        });

        $(document).on('click', '.pagination .page-item a', function (event) {
            event.preventDefault();
            $('input#page').val($(this).attr('href').split('page=')[1]);
            history.pushState(null, null, '?page=' + $('input#page').val());
            reloadList();
        });



        $(document).on('click', '.employees-list .employees-list-item', function () {
            var employee_id = $(this).data('employee-id');
            $.ajax({
                method: 'GET',
                url: '/employees/' + employee_id + '/edit',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).done(function (result) {
                $('#employee-card-modal').html(result);
                $('#employee-card-modal').modal('show');
            }).fail(function (error) {

            });
        });

        $(document).on('click', '#employee-btn-update', function (event) {
            event.preventDefault();
            var form = $(this).parents('.modal-content').find('form.employee-form-edit');
            var employee_id = $(form).data('employee-id');
            var formdata = {
                'first_name': $(form).find('input#input-first-name').val(),
                'last_name': $(form).find('input#input-last-name').val(),
                'middle_name': $(form).find('input#input-middle-name').val(),
                'employment_date': $(form).find('input#input-employment-date').val(),
                'position_id': $(form).find('select#input-position').val(),
                'wage': $(form).find('input#input-wage').val(),
                'director_id': $(form).find('select#input-director').val(),
                '_token': '{{csrf_token()}}',
                '_method': 'PUT'
            };
            $.ajax({
                method: 'POST',
                url: '/employees/' + employee_id,
                data: formdata
            }).done(function (result) {
                Notify.generate(result.message,'Готово',1);
                reloadList();
            }).fail(function (result) {
                var json = JSON.parse(result.responseText);
                for(var key in json.errors) {
                    if(json.errors.hasOwnProperty(key)){
                        json.errors[key].forEach(function(val){
                            Notify.generate(val,'Ошибка',3);
                        });
                    }
                }
            });
        });

        $(document).on('click', '#add-employee-btn', function (event) {
            $.ajax({
                method: 'GET',
                url: '{{route('employees.create')}}',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).done(function (result) {
                $('#employee-card-modal').html(result);
                $('#employee-card-modal').modal('show');
            }).fail(function (error) {

            });
        });

        $(document).on('click', '#employee-btn-create', function (event) {
            event.preventDefault();
            var form = $(this).parents('.modal-content').find('form.employee-form-create');
            var formdata = {
                'first_name': $(form).find('input#input-first-name').val(),
                'last_name': $(form).find('input#input-last-name').val(),
                'middle_name': $(form).find('input#input-middle-name').val(),
                'employment_date': $(form).find('input#input-employment-date').val(),
                'position_id': $(form).find('select#input-position').val(),
                'wage': $(form).find('input#input-wage').val(),
                'director_id': $(form).find('select#input-director').val(),
                '_token': '{{csrf_token()}}'
            };

            $.ajax({
                method: 'POST',
                url: '{{route('employees.store')}}',
                data: formdata
            }).done(function (result) {
                console.log(result);
                reloadList();
            }).fail(function (result) {
                var json = JSON.parse(result.responseText);
                for(var key in json.errors) {
                    if(json.errors.hasOwnProperty(key)){
                        json.errors[key].forEach(function(val){
                            Notify.generate(val,'Ошибка',3);
                        });
                    }
                }
            });
        });



        $(document).on('click','#reload-list-btn',function() {
            reloadList();
        });

        $(document).on('click','.employees-navbar input.employee-item-chekbox',function(){
            $('.employees-list .employees-list-item input.employee-item-chekbox').attr('checked',(this.checked)?true:false);
        });

        window.onpopstate = function (event) {
            var params = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < params.length; i++) {
                var param = params[i].split('=');
                if (param[0] = 'page') {
                    $('input#page').val(param[1]);
                    break;
                }
            }
            reloadList();
        };

        function reloadList() {
            var params = {
                orderby: $('input#orderby').val(),
                order: $('input#order').val(),
                filter: $('input#filter').val(),
                page: $('input#page').val()
            };
            $.ajax({
                method: 'GET',
                url: '{{route('employees.index')}}',
                data: params,
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).done(function (result) {
                $('.employees-list-block').html(result);
            }).fail(function (error) {

            });
        }

        Notify = {
            TYPE_INFO: 0,
            TYPE_SUCCESS: 1,
            TYPE_WARNING: 2,
            TYPE_DANGER: 3,

            generate: function (aText, aOptHeader, aOptType_int) {
                var lTypeIndexes = [this.TYPE_INFO, this.TYPE_SUCCESS, this.TYPE_WARNING, this.TYPE_DANGER];
                var ltypes = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
                var ltype = ltypes[this.TYPE_INFO];

                if (aOptType_int !== undefined && lTypeIndexes.indexOf(aOptType_int) !== -1) {
                    ltype = ltypes[aOptType_int];
                }

                var lText = '';
                if (aOptHeader) {
                    lText += '<strong>'+aOptHeader+'</strong> ' ;
                }
                lText += aText;
                var lNotify_e = $("<div class='alert " + ltype + "'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>" + lText + "</div>");

                setTimeout(function () {
                    lNotify_e.alert('close');
                }, 10000);
                lNotify_e.appendTo($("#notifies"));
            }
        };
    });
</script>
</body>
</html>