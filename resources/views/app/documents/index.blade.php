@extends('layouts.app')

@section('content')
<!-- HEADER -->
<div class="header">
    <div class="container-fluid">

        <!-- Body -->
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">

                    <!-- Title -->
                    <h1 class="header-title">
                        {{ $title }}
                    </h1>

                </div>
                <div class="col-auto">

                    <!-- Button -->

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
        @include('app.components.breadcrumb', [
        'datas' => [
        [
        'active' => true,
        'url' => '',
        'name' => $title,
        'disabled' => false
        ]
        ]
        ])
    </div>
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-body">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Зарплата</th>
                            <th scope="col">Файл</th>
                            <th scope="col">?</th>
                            <th scope="col">Вакансии</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $key => $item)
                        <tr>
                            <th scope="row" style="width: 100px">{{ $documents->firstItem() + $key }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->decs }}</td>
                            <td>
                                @if ($item->file)
                                    <a href="{{ asset('/upload/documents/' . $item->file) }}" target="_blank">
                                        {{ $item->file }}
                                    </a>
                                @else
                                    <span>No file</span>
                                @endif
                            </td>

                            <td> {{ $item->document_category->title['ru'] ?? '' }}</td>
                            <td> {{ $item->vacancy->title['ru'] ?? '' }}</td>


                            <td style="width: 200px">
                                <div class="d-flex justify-content-end">
{{--                                    <a href="{{ route('documents.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>--}}
                                    <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                    <form action="{{ route($route_name.'.destroy', [$route_parameter => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
