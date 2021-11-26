<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-default {{ request()->get('status') === (string)$option ? 'active' : '' }}">
            <input type="radio" class="order-status"
                   {{request()->get('status') === (string)$option ? 'checked' : ''}} value="{{ $option }}"> {{$label}}
        </label>
    @endforeach
</div>
