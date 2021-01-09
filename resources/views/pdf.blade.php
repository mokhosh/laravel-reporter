<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <title>{{ $title }}</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <style>html{-webkit-print-color-adjust:exact}</style>
    </head>
	<body>
        <div class="font-bold text-2xl text-gray-700 text-center font-serif">{{ $title }}</div>
        <x-laravel-reporter::meta :meta="$meta"/>

        <div class="mt-4 rounded-lg overflow-hidden border border-gray-100">
            <table class="w-full text-xs">
                <x-laravel-reporter::table-header :header="$header" :columns="$columns"/>
                @foreach($query->cursor() as $row)
                    <x-laravel-reporter-row :row="$row" :columns="$columns" :is-even="$loop->index % 2 === 0"/>
                @endforeach
            </table>
        </div>

        <div class="flex justify-between p-12 text-lg">
            <div class="date"></div>
            <div>
                <div class="pageNumber"></div>
                <div>of</div>
                <div class="totalPages"></div>
            </div>
        </div>
	</body>
</html>
