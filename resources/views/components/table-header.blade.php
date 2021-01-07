@if ($header)
<thead>
    <tr>
        @foreach ($columns as $title => $modifier)
            @if (is_array($modifier))
                <th class="{{ $modifier['class'] }}">{{ $modifier['title'] }}</th>
            @else
                <th class="p-2 bg-gray-300 text-gray-600 text-left">{{ $modifier }}</th>
            @endif
        @endforeach
    </tr>
</thead>
@endif
