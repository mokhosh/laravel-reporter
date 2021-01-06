@if(! empty($meta))
<div class="head-content">
    <table>
        @foreach($meta as $name => $value)
            <tr>
                <td>{{ $name }}</td>
                <td>{{ ucwords($value) }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endif
