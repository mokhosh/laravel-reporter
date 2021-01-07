@if ($header)
<thead>
    <tr>
        @foreach ($columns as $title => $modifier)
            <th class="p-2 bg-gray-300 text-gray-600 text-left">{{ is_array($modifier) ? $modifier['title'] : $modifier }}</th>
        @endforeach
    </tr>
</thead>
@endif
