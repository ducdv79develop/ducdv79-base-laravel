@if (isset($paginator) && $paginator instanceof Illuminate\Pagination\LengthAwarePaginator)
    <div class="text-left w-50 d-flex">
        <div class="pagination-custom-v2">
            <ul class="pagination-custom">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <button class="page-link"><i class="fa fa-angle-left"></i></button>
                    </li>
                @else
                    <li class="page-item">
                        <button class="page-link" value="{{ $paginator->currentPage() - 1 }}"
                                onclick="window.location.href = replaceUrlParam(window.location.href, 'page', this.value)">
                            <i class="fa fa-angle-left"></i></button>
                    </li>
                @endif
                <li class="page-item page-item-input">
                    <input class="pagination-input" value="{{ $paginator->currentPage() }}"
                           min="1" max="{{ $paginator->lastPage() }}"
                           onchange="if (this.value < this.min) this.value = this.min;
                                            if (this.value > this.max) this.value = this.max;
                                            window.location.href = replaceUrlParam(window.location.href, 'page', this.value)">
                </li>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button class="page-link" value="{{ $paginator->currentPage() + 1 }}"
                                onclick="window.location.href = replaceUrlParam(window.location.href, 'page', this.value)">
                            <i class="fa fa-angle-right"></i></button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <button class="page-link"><i class="fa fa-angle-right"></i></button>
                    </li>
                @endif
            </ul>
        </div>
        <div class="total-record">
            / {{ $paginator->lastPage() . ' ' . __('pagination.page') }}
            &nbsp;&nbsp; {{ __('pagination.result') . ': ' . count($paginator) . ' / ' . $paginator->total() }}
        </div>
    </div>
@elseif(isset($paginator) && (is_string($paginator) || is_numeric($paginator)))
    <div class="text-left w-50 d-flex mb-3">
        <div class="total-record no-paginate">
            {{ __('pagination.result') . ': ' . $paginator }}
        </div>
    </div>
@elseif(isset($paginator) && is_array($paginator))
    <div class="text-left w-50 d-flex mb-3">
        <div class="total-record no-paginate">
            {{ __('pagination.result') . ': ' . count($paginator) }}
        </div>
    </div>
@elseif(isset($paginator) && $paginator instanceof Illuminate\Database\Eloquent\Collection)
    <div class="text-left w-50 d-flex mb-3">
        <div class="total-record no-paginate">
            {{ __('pagination.result') . ': ' . $paginator->count() }}
        </div>
    </div>
@endif
