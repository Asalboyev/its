@extends('layouts.app')

@section('links')

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

    <script>
    window.onload = function() {
        var add_post = new Dropzone("div#dropzone", {
            url: "{{ url('/admin/upload_from_dropzone') }}",
            paramName: "file",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            addRemoveLinks: true,
            maxFiles: 10,
            maxFilesize: 2, // MB
            success: (file, response) => {
                let input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', response.file_name);
                input.setAttribute('name', 'dropzone_images[]');

                let form = document.getElementById('add');
                form.append(input);
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
            error: function(file, message) {
                alert(message);
                this.removeFile(file);
            },

            // change default texts
            dictDefaultMessage: "Перетащите сюда файлы для загрузки",
            dictRemoveFile: "Удалить файл",
            dictCancelUpload: "Отменить загрузку",
            dictMaxFilesExceeded: "Не можете загружать больше",

            @if(old('dropzone_images') || isset($post->postImages[0]))
            init: function() {
                var thisDropzone = this;

                // document.querySelector('.dropzone').classList.add('dz-max-files-reached');

                @foreach((old('dropzone_images') ?? $post->postImages()->pluck('img')->toArray()) as $img)

                var input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', '{{ $img }}');
                input.setAttribute('name', 'dropzone_images[]');

                var form = document.getElementById('add');
                form.append(input);

                var mockFile = {
                    name: '{{ $img }}',
                    size: 1024 * 512,
                    accepted: true
                };

                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, '/upload/images/{{ $img }}');
                thisDropzone.files.push(mockFile)

                @endforeach
            }
            @endif
        });
    };
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
</div> <!-- / .header -->

<!-- CARDS -->
<div class="container-fluid">
    <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $post]) }}" enctype="multipart/form-data" id="add">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-8">
                <div class="card mw-50">
                    <div class="card-body">
                        <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
                            @csrf
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
                                                <label for="title" class="form-label {{ $lang->code == $main_lang->code ? 'required' : '' }}">Заголовок</label>
                                                <input type="text" {{ $lang->code == $main_lang->code ? 'required' : '' }} class="form-control @error('title.'.$lang->code) is-invalid @enderror" name="title[{{ $lang->code }}]" value="{{ old('title.'.$lang->code) ?? $post->title[$lang->code] ?? null }}" id="title" placeholder="Заголовок...">
                                                @error('title.'.$lang->code)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="subtitle" class="form-label">Подзаголовок</label>
                                                <input type="text" class="form-control @error('subtitle.'.$lang->code) is-invalid @enderror" name="subtitle[{{ $lang->code }}]" value="{{ old('subtitle.'.$lang->code) ?? $post->subtitle[$lang->code] ?? null }}" id="subtitle" placeholder="Подзаголовок...">
                                                @error('subtitle.'.$lang->code)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group editor">
                                                <label for="desc" class="form-label ckeditor">Description</label>
                                                <textarea name="desc[{{ $lang->code }}]"  cols="30" rows="10" class="form-control ckeditor @error('desc.'.$lang->code) is-invalid @enderror" placeholder="Описание..."> {{ old('desc.'.$lang->code) ?? $post->desc[$lang->code] ?? '' }} </textarea>   @error('desc.'.$lang->code)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="model-btns d-flex justify-content-end">
                                <a href="{{ route('posts_categories.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                                <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mw-50">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date" class="form-label">Дата</label>
                                    <input type="text" id="date" name="date" class="form-control" value="{{ old('date') ?? date('d-m-Y', strtotime($post->date)) }}" placeholder="{{ date('d-m-Y') }}" data-flatpickr='{"dateFormat": "d-m-Y"}' />
                                </div>
                                <div class="form-group">
                                    <label for="categories" class="form-label">Категории</label>
                                    <select class="form-control mb-4 @error('categories') is-invalid @enderror" data-choices='{"removeItemButton": true}' multiple name="categories[]">
                                        @foreach ($all_categories as $key => $item)
                                        <option value="{{ $item->id }}" {{ (old('categories') || $post->postsCategories ? in_array($item->id, (old('categories') ?? $post->postsCategories()->pluck('posts_category_id')->toArray())) : '') ? 'selected' : '' }}>{{ $item->title[$main_lang->code] }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <!-- Dropzone -->
                                    <label for="dropzone" class="form-label">Пост</label>
                                    <div class="dropzone dropzone-multiple" id="dropzone"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
