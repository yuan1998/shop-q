<div class="filter-input col-sm-{{ $width }}" style="{!! $style !!}">
    <div class="form-group">
        <div class="input-group input-group-sm">

            <div class="input-group-prepend">
                <span class="input-group-text bg-white text-capitalize"><b>{!! $label !!}</b>&nbsp;<i
                            class="feather icon-calendar"></i></span>
            </div>

            <input autocomplete="off" type="text" class="form-control" id="{{$id['start']}}" placeholder="{{$label}}"
                   name="{{$name['start']}}"
                   value="{{ request($name['start'], \Illuminate\Support\Arr::get($value, 'start')) }}">
            <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
            <input autocomplete="off" type="text" class="form-control" id="{{$id['end']}}" placeholder="{{$label}}"
                   name="{{$name['end']}}"
                   value="{{ request($name['end'], \Illuminate\Support\Arr::get($value, 'end')) }}">
        </div>
    </div>
</div>

<script require="@moment,@bootstrap-datetimepicker">
    var options      = {!! admin_javascript_json($dateOptions) !!};
    var startOptions = options ? (options.startOptions || {}) : {};
    var endOptions   = options ? (options.endOptions || {}) : {};
    delete options.startOptions;
    delete options.endOptions;


    $('#{{ $id['start'] }}').datetimepicker($.extend({}, options, { useCurrent: false }));
    $('#{{ $id['end'] }}').datetimepicker($.extend({}, options, { useCurrent: false }));
    $("#{{ $id['start'] }}").on("dp.change", function (e) {
        $('#{{ $id['end'] }}').data("DateTimePicker").minDate(e.date);
    }).on('dp.show', function () {
        if (startOptions.defaultCurrent) {
            $(this).data('DateTimePicker').date(startOptions.defaultCurrent);
            startOptions.defaultCurrent = null;
        }
    });

    $("#{{ $id['end'] }}").on("dp.change", function (e) {
        $('#{{ $id['start'] }}').data("DateTimePicker").maxDate(e.date);
    }).on('dp.show', function () {
        if (endOptions.defaultCurrent) {
            $(this).data('DateTimePicker').date(endOptions.defaultCurrent);
            endOptions.defaultCurrent = null;
        }
    });
</script>
