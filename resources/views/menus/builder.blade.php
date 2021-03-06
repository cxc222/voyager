@extends('voyager::master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/css/nestable.css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>@lang('voyager::menus.menu_builder') ({{ $menu->name }})
        <div class="btn btn-success add_item"><i class="voyager-plus"></i> @lang('voyager::menus.new_menu_item')</div>
    </h1>

@stop

@section('page_header_actions')

@stop

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <p class="panel-title" style="color:#777">@lang('voyager::menus.drop_tip')</p>
                    </div>

                    <div class="panel-body" style="padding:30px;">

                        <div class="dd">
                            <?= Menu::display($menu->name, 'admin'); ?>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> @lang('voyager::menus.delete_tip')</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.menus.item.destroy', ['menu' => $menu->id, 'id' => '__id']) }}" id="delete_form"
                          method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Delete This Menu Item">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('voyager::common.cancel')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal modal-success fade" tabindex="-1" id="add_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-plus"></i> @lang('voyager::menus.create_menu_item')</h4>
                </div>
                <form action="{{ route('voyager.menus.item.add', ['menu' => $menu->id]) }}" id="delete_form" method="POST">
                    <div class="modal-body">
                        <label for="name">@lang('voyager::menus.title')</label>
                        <input type="text" class="form-control" name="title" placeholder="@lang('voyager::menus.title_placeholder')"><br>
                        <label for="url">@lang('voyager::menus.url')</label>
                        <input type="text" class="form-control" name="url" placeholder="@lang('voyager::menus.url_placeholder')"><br>
                        <label for="icon_class">@lang('voyager::menus.icon', ['url' => '<a href="{{ config(\'voyager.assets_path\') . \'/fonts/voyager/icons-reference.html\' }}" target="_blank">Voyager Font Class</a>'])</label>
                        <input type="text" class="form-control" name="icon_class"
                               placeholder="@lang('voyager::menus.icon_placeholder')"><br>
                        <label for="color">@lang('voyager::menus.color')</label>
                        <input type="color" class="form-control" name="color"
                               placeholder="@lang('voyager::menus.color_placeholder')"><br>
                        <label for="target">@lang('voyager::menus.open')</label>
                        <select id="edit_target" class="form-control" name="target">
                            <option value="_self">@lang('voyager::menus.same_open')</option>
                            <option value="_blank">@lang('voyager::menus.new_open')</option>
                        </select>
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    </div>
                    {{ csrf_field() }}

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm" value="@lang('voyager::menus.add_new_item')">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('voyager::common.cancel')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal modal-info fade" tabindex="-1" id="edit_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-edit"></i> @lang('voyager::menus.edit_menu_item')</h4>
                </div>
                <form action="{{ route('voyager.menus.item.update', ['menu' => $menu->id]) }}" id="edit_form" method="POST">
                    {{ method_field("PUT") }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <label for="name">@lang('voyager::menus.title')</label>
                        <input type="text" class="form-control" id="edit_title" name="title" placeholder="@lang('voyager::menus.title_placeholder')"><br>
                        <label for="url">@lang('voyager::menus.url')</label>
                        <input type="text" class="form-control" id="edit_url" name="url" placeholder="@lang('voyager::menus.url_placeholder')"><br>
                        <label for="icon_class">@lang('voyager::menus.icon', ['url' => '<a href="{{ config(\'voyager.assets_path\') . \'/fonts/voyager/icons-reference.html\' }}" target="_blank">Voyager Font Class</a>'])</label>
                        <input type="text" class="form-control" id="edit_icon_class" name="icon_class"
                               placeholder="@lang('voyager::menus.icon_placeholder')"><br>
                        <label for="color">@lang('voyager::menus.color')</label>
                        <input type="color" class="form-control" id="edit_color" name="color"
                               placeholder="@lang('voyager::menus.color_placeholder')"><br>
                        <label for="target">@lang('voyager::menus.open')</label>
                        <select id="edit_target" class="form-control" name="target">
                            <option value="_self" selected="selected">@lang('voyager::menus.same_open')</option>
                            <option value="_blank">@lang('voyager::menus.new_open')</option>
                        </select>
                        <input type="hidden" name="id" id="edit_id" value="">
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm" value="Update">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('voyager::common.cancel')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('javascript')

    <script type="text/javascript" src="{{ config('voyager.assets_path') }}/js/jquery.nestable.js"></script>
    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.target).data('id');
                $('#delete_form')[0].action = $('#delete_form')[0].action.replace("__id",id);
                $('#delete_modal').modal('show');
            });

            $('.item_actions').on('click', '.edit', function (e) {
                id = $(e.target).data('id');
                $('#edit_title').val($(e.target).data('title'));
                $('#edit_url').val($(e.target).data('url'));
                $('#edit_icon_class').val($(e.target).data('icon_class'));
                $('#edit_color').val($(e.target).data('color'));
                $('#edit_id').val(id);

                if ($(e.target).data('target') == '_self') {
                    $("#edit_target").val('_self').change();
                } else if ($(e.target).data('target') == '_blank') {
                    $("#edit_target option[value='_self']").removeAttr('selected');
                    $("#edit_target option[value='_blank']").attr('selected', 'selected');
                    $("#edit_target").val('_blank');
                }
                $('#edit_modal').modal('show');
            });

            $('.add_item').click(function () {
                $('#add_modal').modal('show');
            });

            $('.dd').on('change', function (e) {
                $.post('{{ route('voyager.menus.order',['menu' => $menu->id]) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("@lang('voyager::menus.update_order_success')");
                });

            });

        });
    </script>
@stop
