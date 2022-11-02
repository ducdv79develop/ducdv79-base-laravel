<div class="form-group hide-on-desktop col-12">
    <label>{{ __('Sort') }}</label>
    @php
        $sortOptions = $sort ?? [];
        $directionOptions = [
            'asc' => __('ASC'),
            'desc' => __('DESC')
        ];
    @endphp
    <div class="row">
        <div class="col-6">
            <select class="form-control" name="sort">
                <option value="">{{ __('Default') }}</option>
                @foreach($sortOptions as $key => $val)
                    <option value="{{ $key }}" {{ request('sort') == $key ? 'selected' : '' }}>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <select class="form-control" name="direction">
                <option value="">{{ __('Default') }}</option>
                @foreach($directionOptions as $key => $val)
                    <option value="{{ $key }}" {{ request('direction') == $key ? 'selected' : '' }}>{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
