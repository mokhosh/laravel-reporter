<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <title>{{ $title }}</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        {{--<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">--}}
    </head>
	<body>
		<div class="wrapper">
		    <div class="pb-5">
			    <div class="middle pb-10 title">{{ $title }}</div>
    			<x-laravel-reporter::meta :meta="$meta" />
		    </div>
		    <div class="content">
		    	<table class="table">
                    <x-laravel-reporter::table-header :header="$header" :columns="$columns"/>
                    @foreach($query->cursor() as $row)
                        <x-laravel-reporter-row :row="$row" :columns="$columns" :is-even="$loop->index % 2 === 0"/>
		    		@endforeach
		    	</table>
			</div>
		</div>
	    <?php
            // todo delete?
		    if ( isset($pdf) ) {
		        $pdf->page_text(30, ($pdf->get_height() - 26.89), "Date Printed: " . date('d M Y H:i:s'), null, 10);
		    	$pdf->page_text(($pdf->get_width() - 84), ($pdf->get_height() - 26.89), "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10);
		    }
	    ?>
	</body>
</html>
