@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
@endsection

@section('content')
    <div class="container col-md-11">
        @yield('employees-navbar')
        @yield('employees-list')
    </div>
@section('employees-card')
    <div id="employee-card-modal" class="modal fade" role="form"></div>
    <div id="employee-director-modal" class="modal fade modal-md" role="dialog"></div>
@show
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

        $(document).on('click', '.employees-list-block .pagination .page-item a', function (event) {
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
            }).fail(function (result) {
                showErrorMessages(result);
            });
        }).on('click', '.employees-list .employees-list-item input.employee-item-chekbox', function (e) {
            $(this).prop('checked', (this.checked) ? true : false);
            e.stopPropagation();
        });

        $(document).on('click', '#employee-btn-update', function (event) {
            event.preventDefault();
            var form = $(this).parents('.modal-content').find('form.employee-form-edit');
            var employee_id = $(form).data('employee-id');
            var formdata = new FormData();
            formdata.append('first_name', $(form).find('input#input-first-name').val());
            formdata.append('last_name', $(form).find('input#input-last-name').val());
            formdata.append('middle_name', $(form).find('input#input-middle-name').val());
            formdata.append('employment_date', $(form).find('input#input-employment-date').val());
            formdata.append('position_id', $(form).find('select#input-position').val());
            formdata.append('wage', $(form).find('input#input-wage').val());
            formdata.append('avatar', $(form).find('input#input-avatar').prop('files')[0]);
            formdata.append('director_id', $(form).find('#input-director input').data('directorid'));
            formdata.append('_token', '{{csrf_token()}}');
            formdata.append('_method', 'PUT');

            $.ajax({
                method: 'POST',
                url: '/employees/' + employee_id,
                processData: false,
                contentType: false,
                data: formdata
            }).done(function (result) {
                Notify.generate(result.message, 'Готово', 1);
                reloadList();
                $('#employee-card-modal').modal('hide');
            }).fail(function (result) {
                showErrorMessages(result);
            });
        });

        $(document).on('click', '#employee-btn-create', function (event) {
            event.preventDefault();
            var form = $(this).parents('.modal-content').find('form.employee-form-create');
            var formdata = new FormData();
            formdata.append('first_name', $(form).find('input#input-first-name').val());
            formdata.append('last_name', $(form).find('input#input-last-name').val());
            formdata.append('middle_name', $(form).find('input#input-middle-name').val());
            formdata.append('employment_date', $(form).find('input#input-employment-date').val());
            formdata.append('position_id', $(form).find('select#input-position').val());
            formdata.append('wage', $(form).find('input#input-wage').val());
            formdata.append('avatar', $(form).find('input#input-avatar').prop('files')[0]);
            formdata.append('director_id', $(form).find('#input-director input').data('directorid'));
            formdata.append('_token', '{{csrf_token()}}');

            $.ajax({
                method: 'POST',
                url: '{{route('employees.store')}}',
                processData: false,
                contentType: false,
                data: formdata
            }).done(function (result) {
                Notify.generate(result.message, 'Готово', 1);
                reloadList();
                $('#employee-card-modal').modal('hide');
            }).fail(function (result) {
                showErrorMessages(result);
            });
        });

        $(document).on('click', '#employee-btn-delete', function () {
            var form = $(this).parents('.modal-content').find('form.employee-form-edit');
            var employee_id = $(form).data('employee-id');
            $.ajax({
                method: 'POST',
                url: '/employees/' + employee_id,
                data: {
                    '_token': '{{csrf_token()}}',
                    '_method': 'DELETE'
                }
            }).done(function (result) {
                Notify.generate(result.message, 'Готово', 1);
                reloadList();
            }).fail(function (result) {
                showErrorMessages(result);
            });
        });

        $(document).on('change', 'form input#input-avatar', function () {
            if (this.files && this.files[0]) {
                var input = this;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).siblings('label').find('img').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });


        $(document).on('click', '#employees-btn-add', function () {
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
                showErrorMessages(result);
            });
        });

        $(document).on('click', '#employees-btn-reload-list', function () {
            reloadList();
        });

        $(document).on('click', '#employees-btn-delete-many', function () {
            var checkeditems = $('.employees-list .employees-list-item input.employee-item-chekbox:checked');
            var deleteManyIds = [];
            $.each(checkeditems, function (index, item) {
                var id = $(item).parent('.employees-list-item').data('employee-id');
                deleteManyIds.push(id);
            });
            var ids = deleteManyIds.join(',');
            if (!ids) {
                Notify.generate('Не выбрана ни одна запись', 'Оповещение', 2);
            } else {
                $.ajax({
                    method: 'POST',
                    url: '{{route('employees.destroymany')}}',
                    data: {
                        'ids': ids,
                        '_token': '{{csrf_token()}}',
                        '_method': 'DELETE'
                    }
                }).done(function (result) {
                    Notify.generate(result.message, 'Готово', 1);
                    reloadList();
                }).fail(function (result) {
                    showErrorMessages(result);
                });
            }
        });

        $(document).on('click', '.employees-navbar input.employee-item-chekbox', function () {
            $('.employees-list .employees-list-item input.employee-item-chekbox').prop('checked', (this.checked) ? true : false);
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
                filters: Search.getSelectedJSON(),
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
            }).fail(function (result) {
                showErrorMessages(result);
            });
        }


        Search = {
            input: null,
            tagsblock: null,
            fieldsblock: null,
            fields: {
                id: {
                    name: 'ID',
                    type: ['number']
                },
                first_name: {
                    name: 'Имя',
                    type: ['string']
                },
                last_name: {
                    name: 'Фамилия',
                    type: ['string']
                },
                middle_name: {
                    name: 'Отчество',
                    type: ['string']
                },
                position: {
                    name: 'Должность',
                    field: 'name',
                    type: ['string', 'number']
                },
                director: {
                    name: 'Начальник',
                    field: 'first_name',
                    type: ['string', 'number']
                },
                wage: {
                    name: 'Зарплата',
                    type: ['number']
                },
                employment_date: {
                    name: 'Дата',
                    type: ['string']
                }
            },
            selected: {},
            init: function (input, tagsblock, fieldsblock) {
                this.input = input;
                this.tagsblock = tagsblock;
                this.fieldsblock = fieldsblock;
                $(this.input).on('input', function () {
                    if ($(this).val()) {
                        var selectItems = {};
                        for (field in Search.fields) {
                            if (isFinite($(this).val()) && $.inArray('number', Search.fields[field].type) !== -1) {
                                selectItems[field] = Search.fields[field].name;
                            }
                            if (!isFinite($(this).val()) && $.inArray('string', Search.fields[field].type) !== -1) {
                                selectItems[field] = Search.fields[field].name;
                            }
                        }
                        Search.fieldsblock.html('');
                        for (field in selectItems) {
                            Search.fieldsblock.append('<div name="' + field + '" class = "fields-item">' + selectItems[field] + '</div>');
                        }
                        Search.fieldsblock.prop('hidden', false);
                    } else {
                        Search.fieldsblock.prop('hidden', true);
                    }
                });
                $(this.fieldsblock).on('click', '.fields-item', function () {
                    if (Search.selected[$(this).attr('name')]) {
                        Search.selected[$(this).attr('name')].queries.push(Search.input.val());
                    } else {
                        Search.selected[$(this).attr('name')] = Search.fields[$(this).attr('name')];
                        Search.selected[$(this).attr('name')].queries = [];
                        Search.selected[$(this).attr('name')].queries.push(Search.input.val());
                    }
                    Search.addTag($(this).attr('name'), Search.input.val());
                    Search.fieldsblock.prop('hidden', true);
                    Search.input.val('');
                });

                $(this.tagsblock).on('click', '.item-tags span', function () {
                    Search.selected[$(this).parent('.item-tags').data('name')].queries.splice(
                        Search.selected[$(this).parent('.item-tags').data('name')].queries.indexOf(
                            $(this).parent('item-tags').data('query')), 1);
                    if (Search.selected[$(this).parent('.item-tags').data('name')].queries.length === 0) {
                        delete Search.selected[$(this).parent('.item-tags').data('name')];
                    }
                    $(this).parent('.item-tags').remove();
                    reloadList();
                });
            },
            addTag: function (field_name, query) {
                this.tagsblock.append('<div  class="item-tags d-inline-block" data-name="' + field_name + '" data-query="' + query + '">' + query + '<span class="fa fa-close"></span></div>');
                $('input#page').val(1);
                history.pushState(null, null, '?page=' + $('input#page').val());
                reloadList();
            },
            getSelected: function () {
                return this.selected;
            },
            getSelectedJSON: function () {
                return JSON.stringify(this.selected);
            }
        };
        Search.init($('input#filter-input'), $('div#filter-tags'), $('div#filter-fields'));


        $(document).on('click', '.employee-form #input-director input,i.search-btn', function () {
            var employeeid = $(this).parents('.employee-form').data('employee-id');
            $.ajax({
                method: 'GET',
                url: 'employees/' + employeeid + '/directors',
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

        $(document).on('click', '.employee-form #input-director i.delete-btn', function () {
            $('#input-director input').data('directorid', 0);
            $('#input-director input').val('');
        });

        $(document).on('click', '#employee-director-modal li.director-list-item', function (event) {
            $('#input-director input').data('directorid', $(this).data('employee-id'));
            $('#input-director input').val($(this).find('.employee-item-name').text());
            $('#employee-director-modal').modal('hide');
        });

        $(document).on('click', '#employee-director-modal .pagination a', function (event) {
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

    });


</script>
@endsection
