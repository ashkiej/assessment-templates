<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.5;
            color: #333;
            font-size: 12px;
        }

        h1,
        h2,
        h3 {
            margin: 0 0 10px 0;
        }

        h1 {
            font-size: 16px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 14px;
        }

        h3 {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            font-size: 12px;
        }

        thead th {
            background-color: #f2f2f2;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
        }

        .subsection-title {
            font-weight: bold;
            font-size: 12px;
        }

        .pl-6 {
            padding-left: 12px;
        }

        .pl-12 {
            padding-left: 48px;
        }

        .rating-cell {
            text-align: center;
            font-size: 10px;
        }

        .rating-box {
            display: inline-block;
            border: 1px solid #ccc;
            width: 20px;
            height: 20px;
            margin-right: 4px;
            font-size: 10px !important;
        }
    </style>
</head>

<body>
    <h1>{{ $template->name }}</h1>
    @if ($template->description)
        <p style="font-size:12px;">{{ $template->description }}</p>
    @endif

    @foreach ($template->sections as $section)
        <table class="w-full">
            <thead>
                <tr>
                    <th class="section-title" style="width: 50%;">{{ $section->title }}</th>
                    @foreach ($section->ratingColumns as $column)
                        <th class="rating-cell">{{ $column->name }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pl-6">{{ $section->title }} (Overall)</td>
                    @if ($section->has_ratings)
                        @foreach ($section->ratingColumns as $column)
                            <td class="rating-cell">
                                @for ($i = 1; $i <= $column->max_rating; $i++)
                                    <span class="rating-box">{{ $i }}</span>
                                @endfor
                                <span class="rating-box">N/A</span>
                            </td>
                        @endforeach
                    @else
                        <td class="rating-cell" colspan="{{ count($section->ratingColumns) }}">-</td>
                    @endif
                </tr>

                @foreach ($section->subsections as $subsection)
                    <tr>
                        <td class="pl-6 subsection-title">{{ $subsection->title }}</td>
                        @if ($subsection->has_ratings)
                            @foreach ($section->ratingColumns as $column)
                                <td class="rating-cell">
                                    @for ($i = 1; $i <= $column->max_rating; $i++)
                                        <span class="rating-box">{{ $i }}</span>
                                    @endfor
                                    <span class="rating-box">N/A</span>
                                </td>
                            @endforeach
                        @else
                            <td class="rating-cell" colspan="{{ count($section->ratingColumns) }}">-</td>
                        @endif
                    </tr>

                    @foreach ($subsection->items as $item)
                        <tr>
                            <td class="pl-12">{{ $item->name }}</td>
                            @if ($item->has_ratings)
                                @foreach ($section->ratingColumns as $column)
                                    <td class="rating-cell">
                                        @for ($i = 1; $i <= $column->max_rating; $i++)
                                            <span class="rating-box">{{ $i }}</span>
                                        @endfor
                                        <span class="rating-box">N/A</span>
                                    </td>
                                @endforeach
                            @else
                                <td class="rating-cell" colspan="{{ count($section->ratingColumns) }}">-</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
