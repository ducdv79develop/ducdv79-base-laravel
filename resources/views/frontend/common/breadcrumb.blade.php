<section class="bread-crumb">
    <span class="crumb-border"></span>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 a-left">
                <ul class="breadcrumb">
                    @if (!empty($breadcrumbs) && is_array($breadcrumbs))
                        <li class="home">
                            <a itemprop="url" href="{{ route('frontend.home') }}">
                                <span title="{{ __('Home') }}">{{ __('Home') }}</span>
                            </a>
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        @for ($i = 0; $i < count($breadcrumbs); $i++)
                            @if ($breadcrumbs[$i]['url'])
                                <li class="home">
                                    <a itemprop="url" href="{{ $breadcrumbs[$i]['url'] }}">
                                        <span title="{{ $breadcrumbs[$i]['title'] }}">{{ $breadcrumbs[$i]['title'] }}</span>
                                    </a>
                                    <span class="mr_lr">&nbsp;/&nbsp;</span>
                                </li>
                            @else
                                <li><strong><span> {{ $breadcrumbs[$i]['title'] }}</span></strong></li>
                            @endif
                        @endfor
                    @else
                        <li><strong><span> {{ __('Home') }}</span></strong></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
