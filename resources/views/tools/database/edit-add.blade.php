@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-data"></i> @if(isset($table)){{ trans('voyager::database.editing', ['table' => $table]) }}@else{{ trans('voyager::database.new') }}@endif
    </h1>
@stop

@section('content')

    <!-- table row template -->
    <table class="table table-bordered" style="width:100%; display:none;">
        <thead>
        <tr>
            <th></th>
            <th>@lang('voyager::database.name')</th>
            <th>@lang('voyager::database.type')</th>
            <th>@lang('voyager::database.allow')</th>
            <th>@lang('voyager::database.key')</th>
            <th>@lang('voyager::database.value')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr class="tablerow" style="display:none;">
            <td class="drag">
                <i class="voyager-handle"></i>
                <input type="hidden" name="row[]">
            </td>
            <td>
                <input type="text" class="form-control fieldName" name="field[]">
                @if(isset($table))
                    <input type="hidden" class="form-control originalfieldName" name="original_field[]">
                    <input type="hidden" class="form-control deleteField" name="delete_field[]" value="0">
                @endif
            </td>
            <td>
                <select name="type[]" class="form-control fieldType" tabindex="-1">
                    <optgroup label="Type">
                        <option value="tinyInteger">@lang('voyager::database.tinyInteger')</option>
                        <option value="smallInteger">@lang('voyager::database.smallInteger')</option>
                        <option value="mediumInteger">@lang('voyager::database.mediumInteger')</option>
                        <option value="integer">@lang('voyager::database.integer')</option>
                        <option value="bigInteger">@lang('voyager::database.bigInteger')</option>
                        <option value="string" selected="selected">@lang('voyager::database.string')</option>
                        <option value="text">@lang('voyager::database.text')</option>
                        <option value="mediumText">@lang('voyager::database.mediumText')</option>
                        <option value="longText">@lang('voyager::database.longText')</option>
                        <option value="float">@lang('voyager::database.float')</option>
                        <option value="double">@lang('voyager::database.double')</option>
                        <option value="decimal">@lang('voyager::database.decimal')</option>
                        <option value="boolean">@lang('voyager::database.boolean')</option>
                        <option value="enum">@lang('voyager::database.enum')</option>
                        <option value="date">@lang('voyager::database.date')</option>
                        <option value="dateTime">@lang('voyager::database.dateTime')</option>
                        <option value="time">@lang('voyager::database.time')</option>
                        <option value="timestamp">@lang('voyager::database.timestamp')</option>
                        <option value="binary">@lang('voyager::database.binary')</option>
                    </optgroup>
                </select>
                <div class="enum_val">
                    <small>@lang('voyager::database.enum')</small>
                    <input type="text" class="form-control enum" name="enum[]">
                </div>
            </td>
            <td>
                <input type="checkbox" class="toggleswitch fieldNull" name="nullable_switch[]">
                <input class="toggleswitchHidden" type="hidden" value="0" name='nullable[]'>
            </td>
            <td>
                <select name="key[]" class="form-control fieldKey" tabindex="-1">
                    <optgroup label="Type">
                        <option value=""></option>
                        <option value="PRI">@lang('voyager::database.primary')</option>
                        <option value="UNI">@lang('voyager::database.unique')</option>
                    </optgroup>
                </select>
            </td>
            <td>
                <input type="text" class="form-control fieldDefault" name="default[]">
            </td>
            <td>
                <div class="btn btn-danger delete-row"><i class="voyager-trash"></i></div>
            </td>

        </tr>
        </tbody>
    </table>
    <!-- END Table Row Template -->

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($table)){{ route('voyager.database.update', $table) }}@else{{ route('voyager.database.store') }}@endif"
                      method="POST">
                    @if(isset($table)){{ method_field('PUT') }}@endif
                    <div class="panel panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title">@if(isset($table)){{ trans('voyager::database.edit', ['table' => $table]) }}@else{{ trans('voyager::database.create_table') }}@endif</h3>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                @if(!isset($table))
                                    <div class="col-md-6">
                                        @else
                                            <div class="col-md-12">
                                                @endif
                                                <label for="name">@lang('voyager::database.tabale_name')</label><br>
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="@lang('voyager::database.tabale_name_placeholder')"
                                                       value="@if(isset($table)){{ $table }}@endif">
                                                @if(isset($table))
                                                    <input type="hidden" name="original_name" class="form-control"
                                                           value="{{ $table }}">
                                                @endif
                                            </div>

                                            @if(!isset($table))
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <label for="create_model">@lang('voyager::database.create_model')</label><br>
                                                    <input type="checkbox" name="create_model" data-toggle="toggle"
                                                           data-on="Yes, Please" data-off="No Thanks">

                                                </div>
                                            @endif

                                            @if(!isset($table))
                                                <div class="col-md-3 col-sm-4 col-xs-6">
                                                    <label for="create_migration">@lang('voyager::database.create_migration')</label><br>
                                                    <input type="checkbox" name="create_migration" data-toggle="toggle"
                                                           data-on="Yes, Please" data-off="No Thanks">

                                                </div>
                                            @endif
                                    </div>
                                    <p>@lang('voyager::database.table_fields')</p>

                                    <table class="table table-bordered" style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>@lang('voyager::database.name')</th>
                                            <th>@lang('voyager::database.type')</th>
                                            <th>@lang('voyager::database.allow')</th>
                                            <th>@lang('voyager::database.key')</th>
                                            <th>@lang('voyager::database.value')</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tablebody">

                                        </tbody>
                                    </table>

                                    <div style="text-align:center">
                                        <div class="btn btn-success" id="newField">+ @lang('voyager::database.add_new_field')</div>
                                        <div class="btn btn-success" id="newFieldPrimary">+ @lang('voyager::database.add_primary_field')</div>
                                        @if(!isset($table))
                                            <div class="btn btn-success" id="newFieldTimestamps">+ @lang('voyager::database.add_timestamp_fields')</div>
                                            <div class="btn btn-success" id="newFieldSoftDelete">+ @lang('voyager::database.add_soft_delete_field')</div>
                                        @endif
                                    </div>
                            </div>
                            <div class="panel-footer">
                                <input type="submit" class="btn btn-primary pull-right"
                                       value="@if(isset($table)){{ 'Update Table' }}@else{{ 'Create New Table' }}@endif">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div style="clear:both"></div>
                            </div>
                        </div><!-- .panel -->
                </form>
            </div>
        </div>
    </div>

@stop

@section('javascript')

    <script>

        $('document').ready(function () {

            @if(!isset($table))
                newRow('primary');
                newRow();
            @else
                @foreach($rows as $row)
                    newRow('', '{{ $row->field }}', '{{ $row->type }}', '{{ $row->null }}', '{{ $row->key }}', '{{ $row->default }}');
                @endforeach
            @endif

            $('#newField').click(function () {
                newRow();
            });

            $('#newFieldTimestamps').click(function () {
                newRow('timestamps');
            });

            $('#newFieldSoftDelete').click(function () {
                newRow('softdelete');
            });

            $('#newFieldPrimary').click(function () {
                newRow('primary');
            });
            $("#tablebody").sortable({
                handle: '.voyager-handle'
            });

            $('#tablebody').on('click', '.delete-row', function () {
                var clickedRow = $(this).parents('.newTableRow');
                if (clickedRow.find('.fieldName').val() == "created_at & updated_at") {
                    $('#newFieldTimestamps').removeAttr('disabled').click(function () {
                        newRow('timestamps');
                    });
                } else if (clickedRow.find('.fieldName').val() == "deleted_at") {
                    $('#newFieldSoftDelete').removeAttr('disabled').click(function () {
                        newRow('softdelete');
                    });
                }
                if (clickedRow.hasClass('existing_row')) {
                    $(this).parents('.newTableRow').hide();
                    $(this).parents('.newTableRow').find('.deleteField').val(1);
                } else {
                    $(this).parents('.newTableRow').remove();
                }
            });

            $('#tablebody').on('change', '.fieldType', function (e) {
                if ($(this).val() == 'text' || $(this).val() == 'mediumText' || $(this).val() == 'longText') {
                    $(this).parents('.newTableRow').find('.fieldDefault').val('');
                    $(this).parents('.newTableRow').find('.fieldDefault').attr('readonly', 'readonly');
                } else {
                    $(this).parents('.newTableRow').find('.fieldDefault').removeAttr('readonly');
                }

                if ($(this).val() == 'enum') {
                    $(this).parents('.newTableRow').find('.enum_val').show();
                } else {
                    $(this).parents('.newTableRow').find('.enum_val').hide();
                }
            });

            $('.toggleswitch').change(function () {
                if ($(this).prop('checked')) {
                    $(this).parents('.newTableRow').find('.toggleswitchHidden').val(1);
                } else {
                    $(this).parents('.newTableRow').find('.toggleswitchHidden').val(0);
                }
            });
            $('form').submit(function () {
                $.each($('.fieldType'), function () {
                    $(this).removeAttr('disabled');
                });

                return true;
            });
        });

        function newRow(kind, name, type, nullable, key, defaultValue) {

            unique_id = ("0000" + (Math.random() * Math.pow(36, 4) << 0).toString(36)).slice(-4);
            if (kind == 'primary') {
                $('#tablebody').prepend('<tr id="' + unique_id + '" class="newTableRow">' + $('.tablerow').html() + '</tr>');
            } else {
                $('#tablebody').append('<tr id="' + unique_id + '" class="newTableRow">' + $('.tablerow').html() + '</tr>');
            }

            $('.toggleswitch').not('.tablerow .toggleswitch').bootstrapToggle({
                on: 'Yes',
                off: 'No'
            });

            if (kind == 'primary') {
                $('#' + unique_id).find('.fieldName').val('id');
                $('#' + unique_id).find('.fieldType').val('integer');
                $('#' + unique_id).find('.fieldKey').val('PRI');
            } else if (kind == 'timestamps') {
                $('#' + unique_id).find('.fieldName').val('created_at & updated_at').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldDefault').val('CURRENT_TIMESTAMP').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldType').val('timestamp').attr('readonly', 'readonly').prop('disabled', 'true');
                $('#' + unique_id).find('.fieldNull').bootstrapToggle('off').bootstrapToggle('disable');
                $('#' + unique_id).find('.fieldKey').hide();
                $('#newFieldTimestamps').attr('disabled', 'disabled').off('click');
            } else if (kind == 'softdelete') {
                $('#' + unique_id).find('.fieldName').val('deleted_at').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldDefault').val('NULL').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldType').val('timestamp').attr('readonly', 'readonly').prop('disabled', 'true');
                $('#' + unique_id).find('.fieldNull').bootstrapToggle('on').bootstrapToggle('disable');
                $('#' + unique_id).find('.toggleswitchHidden').val(1);
                $('#' + unique_id).find('.fieldKey').hide();
                $('#newFieldSoftDelete').attr('disabled', 'disabled').off('click');
            } else {
                if (typeof(name) != 'undefined') {
                    $('#' + unique_id).addClass('existing_row');
                    $('#' + unique_id).find('.fieldName').val(name);
                    $('#' + unique_id).find('.originalfieldName').val(name);
                    type = getCorrectType(type);
                    $('#' + unique_id).find('.fieldType').val(type);
                    $('#' + unique_id).find('.fieldKey').val(key);
                    if (nullable == "YES") {
                        $('#' + unique_id).find('.toggleswitch').prop('checked', true).change();
                        $('#' + unique_id).find('.toggleswitchHidden').val(1);
                    }
                    $('#' + unique_id).find('.fieldDefault').val(defaultValue);
                }
            }


        }

        function getCorrectType(type) {
            if (type.substring(0, 3) == 'int') {
                return 'integer';
            }
            if (type.substring(0, 7) == 'varchar') {
                return 'string';
            }
            if (type == 'tinyint(1)') {
                return 'boolean';
            }
            if (type.substring(0, 7) == 'tinyint') {
                return 'tinyInteger';
            }
            if (type.substring(0, 8) == 'smallint') {
                return 'smallInteger';
            }
            if (type.substring(0, 9) == 'mediumint') {
                return 'mediumInteger';
            }
            if (type.substring(0, 6) == 'bigint') {
                return 'bigInteger';
            }
            if (type == 'mediumtext') {
                return 'mediumText';
            }
            if (type == 'longtext') {
                return 'longText';
            }
            if (type == 'double(8,2)') {
                return 'float'
            }
            if (type.substring(0, 7) == 'decimal') {
                return 'decimal';
            }
            if (type == 'datetime') {
                return 'dateTime'
            }
            if (type == 'blob') {
                return 'binary'
            }

            return type;
        }

    </script>

@stop
