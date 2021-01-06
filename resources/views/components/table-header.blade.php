@if ($header)
<thead>
    <tr>
        @foreach ($columns as $title => $modifier)
            @if (is_array($modifier) && array_key_exists('class', $modifier))
                <th class="{{ $modifier['class'] }}">{{ $title }}</th>
            @else
                <th class="left">{{ $title }}</th>
            @endif
        @endforeach
    </tr>
</thead>
@endif
