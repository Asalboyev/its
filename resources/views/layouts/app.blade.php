<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico" type="image/x-icon" />

    <!-- Map CSS -->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css" />


{{--    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.css" crossorigin>--}}

    <link rel="stylesheet" href="/assets/css/editor.css">







        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        // CKEDITOR.config.toolbar = [
        // 	{ name: 'document', items : [ 'Undo','Redo'] },
        // ];
        // 	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','Format' ] },
        // CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        // CKEDITOR.config.extraPlugins = 'uploadimage';
        CKEDITOR.config.filebrowserUploadUrl = "{{ route('upload-image', ['_token' => csrf_token()]) }}";
        CKEDITOR.config.filebrowserUploadMethod = 'form';
    </script>

    <!-- Title -->
    <title>Dashboard | NDC.uz</title>

    @yield('links')

    <style>
        .required:after {
            content: '*';
            color: red;
        }

        .active {
            color: #12263f;
        }

        .dz-success-mark,
        .dz-error-mark,
        .dz-details {
            display: none;
        }

        .imb-block {
            width: 80px;
            height: 80px;
        }

        .imb-block>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropzone {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .dz-default.dz-message {
            width: 100%;
            margin-bottom: 12px;
        }

        .dz-preview {
            width: fit-content;
            margin-right: 12px;
            margin-bottom: 32px;
            max-width: 120px;
            height: 120px;
        }

        .dz-preview .dz-image {
            width: 100%;
            height: 100%;
        }

        .dz-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div id="preloader" style="
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(255,255,255,0.9);
        width: 100%;
        height: 100%;
        z-index: 9999;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <img src="/assets/img/preloader.gif" style="width: 100px;">
    </div>
    @if(!isset($no_sidebar))
    <!-- NAVIGATION -->
    <nav class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light" id="sidebar">
        <div class="container-fluid">

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand">
                <img src="/assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="...">
            </a>

            <!-- User (xs) -->
            <div class="navbar-user d-md-none">

                <!-- Dropdown -->
                <div class="dropdown">

                    <!-- Toggle -->
                    <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-sm avatar-online">
                            <img src="/assets/img/avatars/profiles/avatar-6.jpg" class="avatar-img rounded-circle" alt="...">
                        </div>
                    </a>

                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
                        <a href="/sign-in.html" class="dropdown-item">Logout</a>
                    </div>

                </div>

            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">

                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                            <i class="fe fe-home"></i> Дашбоард
                        </a>
                    </li>
                    <hr class="navbar-divider my-3">
                    @if($menu_items->where('route', 'applications')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/applications') || request()->is('admin/applications/*') ? 'active' : '' }}" href="{{ route('applications.index') }}">
                            <i class="fe fe-archive"></i> Запросы
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/banners') || request()->is('admin/banners/*') ? 'active' : '' }}" href="{{ route('banners.index') }}">
                            <i class="fe fe-grid"></i> Баннеры
                        </a>
                    </li>
                    @if($menu_items_groups->where('title', 'Продукты')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link" href="#products" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/products') || request()->is('admin/products/*') || request()->is('admin/products_categories') || request()->is('admin/products_categories/*') ||  request()->is('admin/developments') || request()->is('admin/developments/*') ? 'true' : 'false' }}" aria-controls="products">
                            <i class="fe fe-layers"></i> Продукты
                        </a>
                        <div class="collapse {{ request()->is('admin/products') || request()->is('admin/products/*') || request()->is('admin/products_categories') || request()->is('admin/products_categories/*')  || request()->is('admin/developments') || request()->is('admin/developments/*') ? 'show' : '' }}" id="products">
                            <ul class="nav nav-sm flex-column">
                                @if($menu_items->where('route', 'products')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                        Продукты
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'products_categories')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/products_categories') || request()->is('admin/products_categories/*') ? 'active' : '' }}" href="{{ route('products_categories.index') }}">
                                        Категории продуктов
                                    </a>
                                </li>
                                @endif
{{--                                @if($menu_items->where('route', 'brands')->where('is_active', 1)->first())--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link {{ request()->is('admin/banners') || request()->is('admin/banners/*') ? 'active' : '' }}" href="{{ route('banners.index') }}">--}}
{{--                                        Баннеры--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                @endif--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link {{ request()->is('admin/developments') || request()->is('admin/developments/*') ? 'active' : '' }}" href="{{ route('developments.index') }}">--}}
{{--                                        Разработки--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if($menu_items_groups->where('title', 'Посты')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link" href="#posts" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('posts') || request()->is('posts/*') || request()->is('posts_categories') || request()->is('posts_categories/*') ? 'true' : 'false' }}" aria-controls="posts">
                            <i class="fe fe-cast"></i> Посты
                        </a>
                        <div class="collapse {{ request()->is('admin/posts') || request()->is('admin/posts/*') || request()->is('admin/posts_categories') || request()->is('admin/posts_categories/*') ? 'show' : '' }}" id="posts">
                            <ul class="nav nav-sm flex-column">
                                @if($menu_items->where('route', 'posts')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/posts') || request()->is('admin/posts/*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                                        Посты
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'posts_categories')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/posts_categories') || request()->is('admin/posts_categories/*') ? 'active' : '' }}" href="{{ route('posts_categories.index') }}">
                                        Категории постов
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if($menu_items_groups->where('title', 'Документы')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link" href="#documents" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/documents') || request()->is('admin/documents/*') || request()->is('admin/document_categories') || request()->is('admin/document_categories/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-file"></i> Документы
                        </a>
                        <div class="collapse {{ request()->is('admin/documents') || request()->is('admin/documents/*') || request()->is('admin/document_categories') || request()->is('admin/document_categories/*') ? 'show' : '' }}" id="documents">
                            <ul class="nav nav-sm flex-column">
                                @if($menu_items->where('route', 'documents')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/documents') || request()->is('admin/documents/*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                                        Документы
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'document_categories')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/document_categories') || request()->is('admin/document_categories/*') ? 'active' : '' }}" href="{{ route('document_categories.index') }}">
                                        Категории документов
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if($menu_items_groups->where('title', 'Компания')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link" href="#company" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/feedbacks') || request()->is('admin/feedbacks/*') || request()->is('admin/members') || request()->is('admin/members/*') || request()->is('admin/partners') || request()->is('admin/partners/*') || request()->is('admin/questions') || request()->is('admin/questions/*') || request()->is('admin/works') || request()->is('admin/works/*') || request()->is('admin/vacancies') || request()->is('admin/vacancies/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-star"></i> Компания
                        </a>
                        <div class="collapse {{ request()->is('admin/feedbacks') || request()->is('admin/feedbacks/*') || request()->is('admin/members') || request()->is('admin/members/*') || request()->is('admin/partners') || request()->is('admin/partners/*') || request()->is('admin/questions') || request()->is('admin/questions/*') || request()->is('admin/works') || request()->is('admin/works/*') || request()->is('admin/vacancies') || request()->is('admin/vacancies/*') ? 'show' : '' }}" id="company">
                            <ul class="nav nav-sm flex-column">
                                @if($menu_items->where('route', 'feedbacks')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/feedbacks') || request()->is('admin/feedbacks/*') ? 'active' : '' }}" href="{{ route('feedbacks.index') }}">
                                        Отзыви
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'members')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}" href="{{ route('members.index') }}">
                                        Команда
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'partners')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/partners') || request()->is('admin/partners/*') ? 'active' : '' }}" href="{{ route('partners.index') }}">
                                        Партнеры
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'works')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/works') || request()->is('admin/works/*') ? 'active' : '' }}" href="{{ route('works.index') }}">
                                        Наши работы
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'vacancies')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/vacancies') || request()->is('admin/vacancies/*') ? 'active' : '' }}" href="{{ route('vacancies.index') }}">
                                        Вакансии
                                    </a>
                                </li>
                                @endif
                                @if($menu_items->where('route', 'questions')->where('is_active', 1)->first())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/questions') || request()->is('admin/questions/*') ? 'active' : '' }}" href="{{ route('questions.index') }}">
                                        FAQ
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    @if($menu_items->where('route', 'services')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/services') || request()->is('admin/services/*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                            <i class="fe fe-grid"></i> Услуги
                        </a>
                    </li>
                    @endif
                    @if($menu_items->where('route', 'certificates')->where('is_active', 1)->first())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/certificates') || request()->is('admin/certificates/*') ? 'active' : '' }}" href="{{ route('certificates.index') }}">
                            <i class="fe fe-award"></i> Сертификаты
                        </a>
                    </li>
                    @endif
                    <hr class="navbar-divider my-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#static_info" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') || request()->is('admin/additional_functions') || request()->is('admin/additional_functions/*') || request()->is('admin/config/settings') || request()->is('admin/config/settings') || request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/translations') || request()->is('admin/translations/*') || request()->is('admin/langs') || request()->is('admin/langs/*') || request()->is('admin/logs') || request()->is('admin/logs/*') ? 'true' : 'false' }}" aria-controls="documents">
                            <i class="fe fe-settings"></i> Настройки сайта
                        </a>
                        @if(auth()->user()->role == 'admin')
                        <div class="collapse {{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') || request()->is('admin/additional_functions') || request()->is('admin/additional_functions/*') || request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/translations') || request()->is('admin/translations/*')|| request()->is('admin/config/settings') || request()->is('admin/config/settings') || request()->is('admin/langs') || request()->is('admin/langs/*') || request()->is('admin/logs') || request()->is('admin/logs/*') ? 'show' : '' }}" id="static_info">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/site_infos') || request()->is('admin/site_infos/*') ? 'active' : '' }}" href="{{ route('site_infos.index') }}">
                                        Общие данные
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/additional_functions') || request()->is('admin/additional_functions/*') ? 'active' : '' }}" href="{{ route('additional_functions.index') }}">
                                        Дополнительные сервисы
                                    </a>
                                </li>
                                @if(request()->is('admin/config/settings'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('admin/config/Mmzf9N7QuCXDSk32') ? 'active' : '' }}" href="{{ route('config') }}">
                                            Config
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                        <i class="fe fe-users"></i> Админы
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/translations') || request()->is('admin/translations/*') ? 'active' : '' }}" href="{{ route('translations.index') }}">
                                        <i class="fe fe-book-open"></i> Переводы
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/langs') || request()->is('admin/langs/*') ? 'active' : '' }}" href="{{ route('langs.index') }}">
                                        <i class="fe fe-globe"></i> Языки
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                </ul>

                <!-- Push content down -->
                <div class="mt-auto"></div>


                <!-- User (md) -->
                <div class="navbar-user d-none d-md-flex" id="sidebarUser">

                    <!-- Dropup -->
                    <div class="dropup">

                        <!-- Toggle -->
                        <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-sm avatar-online">
                                <img src="/assets/img/avatars/profiles/default_user.png" class="avatar-img rounded-circle" alt="...">
                            </div>
                        </a>

                        <!-- Menu -->
                        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">Выйти</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>

                    </div>

                </div>

            </div> <!-- / .navbar-collapse -->

        </div>
    </nav>
    @endif
    <!-- MAIN CONTENT -->
    <div class="main-content">


        @yield('content')


    </div><!-- / .main-content -->

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>



{{--    <script src="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.umd.js" crossorigin></script>--}}
{{--    <script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>--}}
{{--    <script src="/assets/js/editeditor.js"></script>--}}


    <!-- Vendor JS -->
    <script src="/assets/js/vendor.bundle.js"></script>
{{--    <script>--}}
{{--        window.replainSettings = { id: '1e33f07c-e55e-408d-8119-b9ffb1e61369' };--}}
{{--        (function(u){var s=document.createElement('script');s.async=true;s.src=u;--}}
{{--            var x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);--}}
{{--        })('https://widget.replain.cc/dist/client.js');--}}
{{--    </script>--}}

    <!-- Theme JS -->
    <script src="/assets/js/theme.bundle.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @yield('scripts')

    @if (session()->has('success') && session('success') == false)
    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#b82c46',
                icon: {
                    className: 'fe fe-x',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'error',
            message: <?= json_encode(session('message')) ?>
        });
    </script>
    @endif

    @if (session()->has('success') && session('success') == true)
    <script type="text/javascript">
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'success',
                background: '#00ae65',
                icon: {
                    className: 'fe fe-check-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'success',
            message: <?= json_encode(session('message')) ?>
        });
    </script>
    @endif

    <script>
        var preloader = document.getElementById('preloader');

        preloader.classList.add('d-none');
    </script>

</body>

</html>
