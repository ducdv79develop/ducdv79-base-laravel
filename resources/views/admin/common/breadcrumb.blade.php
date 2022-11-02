<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title ?? __('Home') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (!empty($breadcrumbs) && is_array($breadcrumbs))
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('Home') }}</a></li>
                        @for ($i = 0; $i < count($breadcrumbs); $i++)
                            @if ($breadcrumbs[$i]['url'])
                                <li class="breadcrumb-item"><a href="{{ $breadcrumbs[$i]['url'] }}">{{ $breadcrumbs[$i]['title'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbs[$i]['title'] }}</li>
                            @endif
                        @endfor
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Home') }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
