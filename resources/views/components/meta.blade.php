@if(! empty($meta))
    <div class="grid grid-cols-2 gap-2 text-gray-400 mt-2">
        @foreach($meta as $name => $value)
            <div class="flex justify-between">
                <div class="font-semibold">{{ $name }}</div>
                <div>{{ ucwords($value) }}</div>
            </div>
        @endforeach
    </div>
@endif
