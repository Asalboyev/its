@extends('layouts.app')

@section('links')

<script>
    window.onload = function() {
        var add_post = new Dropzone("div#dropzone", {
            url: "{{ url('/admin/upload_from_dropzone') }}",
            paramName: "file",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            addRemoveLinks: true,
            maxFiles: 1,
            maxFilesize: 10, // MB
            success: (file, response) => {
                let input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', response.file_name);
                input.setAttribute('name', 'dropzone_images');

                let form = document.getElementById('add');
                form.append(input);
                console.log(response);
            },
            removedfile: function(file) {
                file.previewElement.remove();
                if (file.xhr) {
                    let data = JSON.parse(file.xhr.response);
                    let removing_img = document.querySelector('[value="' + data.file_name + '"]');
                    removing_img.remove();
                } else {
                    let data = file.name.split('/')[file.name.split('/').length - 1]
                    let removing_img = document.querySelector('[value="' + data + '"]');
                    removing_img.remove();
                }
            },

            init: function() {
                @if(isset($productsCategory -> img))

                var thisDropzone = this;

                document.querySelector('.dropzone').classList.add('dz-max-files-reached');

                var input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', '{{ $productsCategory->img }}');
                input.setAttribute('name', 'dropzone_images');

                let form = document.getElementById('add');
                form.append(input);

                var mockFile = {
                    name: '{{ $productsCategory->img }}',
                    size: 1024 * 512,
                    accepted: true
                };

                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, '{{ $productsCategory->sm_img }}');
                thisDropzone.files.push(mockFile)

                @endif
            },

            error: function(file, message) {
                alert(message);
                this.removeFile(file);
            },

            // change default texts
            dictDefaultMessage: "Перетащите сюда файлы для загрузки",
            dictRemoveFile: "Удалить файл",
            dictCancelUpload: "Отменить загрузку",
            dictMaxFilesExceeded: "Не можете загружать больше"
        });
    };
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // 'ckeditor' klassiga ega barcha textarea'larni tanlash
        const textareas = document.querySelectorAll('textarea.ckeditor');

        textareas.forEach(textarea => {
            ClassicEditor
                .create(textarea, {
                    ckfinder: {
                        uploadUrl: '{{ route('upload-image', ['_token' => csrf_token()]) }}'
                    },
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList',
                        'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo',
                        'imageUpload'
                    ],
                    image: {
                        toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor 5:', error);
                });
        });
    });
</script>

@endsection

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
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
        @include('app.components.breadcrumb', [
        'datas' => [
        [
        'active' => false,
        'url' => route($route_name.'.index'),
        'name' => $title,
        'disabled' => false
        ],
        [
        'active' => true,
        'url' => '',
        'name' => 'Добавление',
        'disabled' => true
        ],
        ]
        ])
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mw-50">
                <div class="card-body">
                    <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $productsCategory]) }}" enctype="multipart/form-data" id="add">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach($langs as $lang)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $lang->code }}" type="button" role="tab" aria-controls="{{ $lang->code }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $lang->title }}</button>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @foreach($langs as $lang)
                                    <div class="tab-pane mt-3 fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang->code }}" role="tabpanel" aria-labelledby="{{ $lang->code }}-tab">
                                        <div class="form-group">
                                            <label for="title" class="form-label {{ $lang->code == $main_lang->code ? 'required' : '' }}">Название</label>
                                            <input type="text" {{ $lang->code == $main_lang->code ? 'required' : '' }} class="form-control @error('title.'.$lang->code) is-invalid @enderror" name="title[{{ $lang->code }}]" value="{{ old('title.'.$lang->code) ?? $productsCategory->title[$lang->code] ?? null }}" id="title" placeholder="Название...">
                                            @error('title.'.$lang->code)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="desc" class="form-label">Описание</label>
                                            <textarea name="desc[{{ $lang->code }}]"  cols="30" rows="10" class="form-control ckeditor @error('desc.'.$lang->code) is-invalid @enderror" placeholder="Описание..."> {{ old('desc.'.$lang->code) ?? $productsCategory->desc[$lang->code] ?? '' }} </textarea>   @error('desc.'.$lang->code)
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="parent_id" class="form-label">Родительская категория</label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror " data-choices='{"": true}'  id="parent_id" name="parent_id">
                                        <option value="">Главная категория</option>
                                        @foreach ($all_categories as $key => $item)
                                        <option value="{{ $item->id }}" {{ old('parent_id') ?? $productsCategory->parent_id == $item->id ? 'selected' : '' }}>{{ $item->title[$main_lang->code] }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="in_main" class="form-label">Показать на первом экране</label>
                                    <select class="form-select @error('in_main') is-invalid @enderror" id="in_main" name="in_main">
                                        <option value="0" {{ $productsCategory->in_main == 0 ? 'selected' : '' }}>Нет</option>
                                        <option value="1" {{ $productsCategory->in_main == 1 ? 'selected' : '' }}>Да</option>
                                    </select>
                                    @error('in_main')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="dropzone" class="form-label">Картина</label>
                                    <div class="dropzone dropzone-multiple" id="dropzone"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">

        </div>
    </div>
</div>
@endsection
