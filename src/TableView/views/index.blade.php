@extends('layouts.admin')

@section('content')
    <div class="tableView-wrapper">
        @if(count($tableView->searchableFields()))
            <form class="table-filter">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="hidden" name="start" id="start">
                        <input type="hidden" name="end" id="end">
                        <div class="show-entries">
                            <span>Mostrar</span>
                            <select name="perPage" class="form-control">

                            </select>
                            <span>registros de ( 24 )</span>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <div class="filter-group">
                            <input type="text" name="search" value="" class="form-control">
                        </div>
                        <div class="filter-group">
                            <select name="status" class="form-control">

                            </select>
                        </div>
                        <div class="filter-group">
                            <div class="input-group">
                                <input type="text" id="demo" value="" class="form-control" readonly aria-describedby="demo">
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i> </span></div>
                            </div>
                        </div>
                        <span class="filter-icon"><i class="fa fa-filter"></i></span>
                    </div>
                </div>
            </form>
        @endif

        <table class="{{$tableView->getTableClass()}}" id="{{$tableView->id()}}" style="width: 100%">
            <thead>
            <tr>
                @if($tableView->hasChildDetails())
                    <th></th>
                @endif
                @foreach($tableView->columns() as $column)
                        @if(!$column->get('hidden_list'))
                            <th @if($column->get('width')) style="width: {{ $column->get('width') }}" @endif>
                                @if($column->get('sorter'))
                                   <a href=""> {{ $column->get('title') }}</a>
                                @else
                                    {{ $column->get('title') }}
                                @endif
                            </th>
                        @endif
                @endforeach
            @if($tableView->hasActions())
                <th>
                   #
                </th>
            @endif
            </tr>
            </thead>
            <tbody class="{{ $tableView->geTableBodyClass() }}">
            @forelse($tableView->data() as $dataModel)
                <tr
                    @if($tableView->hasChildDetails())
                    data-child-content="{{ $tableView->getChildDetails($dataModel) }}"
                @endif
                @foreach($tableView->getTableRowAttributes($dataModel) as $attribute => $value)
                    {{$attribute}}='{{$value}}'
                @endforeach
                >
                @if($tableView->hasChildDetails())
                    <td class="details-control">
                        <svg style="cursor: pointer" width=14 height=14 aria-hidden="true" data-prefix="fas"
                             data-icon="angle-down"
                             class="svg-inline--fa fa-angle-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 320 512">
                            <path fill="currentColor"
                                  d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
                        </svg>
                        <svg style="display: none; cursor: pointer" width=14 height=14 aria-hidden="true" data-prefix="fas"
                             data-icon="angle-up"
                             class="svg-inline--fa fa-angle-up fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 320 512">
                            <path fill="currentColor"
                                  d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z"></path>
                        </svg>
                    </td>
                @endif
                    @foreach($tableView->columns() as $column)
                        @if(!$column->get('hidden_list'))
                            <td class="{{ $column->get('classe') }}">
                                {!!  $column->rowValue($dataModel)  !!}
                            </td>
                        @endif


                    @endforeach
                    @if($tableView->hasActions())
                    <td class="{{ $column->get('classe') }}">
                        {!!  $tableView->actions($dataModel)  !!}
                    </td>
                    @endif
                    </tr>
                    @if($tableView->hasChildDetails())
                        <tr style="display: none">
                            <td colspan="{{ count($tableView->columns()) + 1 }}">
                                {!! $tableView->getChildDetails($dataModel) !!}
                            </td>
                        </tr>
                    @endif
                    @empty
                        <tr>
                            <td colspan="{{ count($tableView->columns()) + ($tableView->hasChildDetails() ? 1 : 0) }}">
                                <div>
                                    <p>
                                        <b>{{  __('No data matched the given criteria.')  }}</b>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
    <div class="tableView-pagination">
        @if($tableView->hasPagination())
            {{ $tableView->data()->links() }}
        @endif
    </div>
    @if($tableView->hasChildDetails())
        @push(config('tableView.dataTable.js.stack_name'))
            <script>
                $(function () {
                    $(document).on('click', '.details-control', function (e) {
                        e.preventDefault()
                        var tr = $(this).closest('tr');
                        tr.next().toggle();
                        if (tr.next().is(':visible')) {
                            $(this).find('[data-icon="angle-down"]').hide()
                            $(this).find('[data-icon="angle-up"]').show()
                        } else {
                            $(this).find('[data-icon="angle-down"]').show()
                            $(this).find('[data-icon="angle-up"]').hide()
                        }
                    });
                })
            </script>

        @endpush
    @endif

@endsection
