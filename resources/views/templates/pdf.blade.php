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
        }

        h1,
        h2,
        h3 {
            margin: 0 0 10px 0;
        }

        h1 {
            font-size: 24px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        thead th {
            background-color: #f2f2f2;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
        }

        .subsection-title {
            font-weight: bold;
        }

        .pl-6 {
            padding-left: 24px;
        }

        .pl-12 {
            padding-left: 48px;
        }

        .rating-cell {
            text-align: center;
        }

        .rating-box {
            display: inline-block;
            border: 1px solid #ccc;
            width: 24px;
            height: 24px;
            margin-right: 4px;
        }
    </style>
</head>

<body>
    <h1>{{ $template->name }}</h1>
    @if ($template->description)
        <p>{{ $template->description }}</p>
    @endif

    @foreach ($template->sections as $section)
        <table class="w-full">
            <thead>
                <tr>
                    <th class="section-title" style="width: 50%;">{{ $section->title }}</th>
                    @if ($section->has_ratings)
                        @foreach ($section->ratingColumns as $column)
                            <th class="rating-cell">{{ $column->name }}</th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($section->has_ratings)
                    <tr>
                        <td class="pl-6">{{ $section->title }} (Overall)</td>
                        @foreach ($section->ratingColumns as $column)
                            <td class="rating-cell">
                                @for ($i = 1; $i <= $column->max_rating; $i++)
                                    <span>{{ $i }}</span>
                                @endfor
                                <span>N/A</span>
                            </td>
                        @endforeach
                    </tr>
                @endif

                @foreach ($section->subsections as $subsection)
                    <tr>
                        <td class="pl-6 subsection-title">{{ $subsection->title }}</td>
                        @if ($section->has_ratings && $subsection->has_ratings)
                            @foreach ($section->ratingColumns as $column)
                                <td class="rating-cell">
                                    @for ($i = 1; $i <= $column->max_rating; $i++)
                                        <span>{{ $i }}</span>
                                    @endfor
                                    <span>N/A</span>
                                </td>
                            @endforeach
                        @elseif ($section->has_ratings)
                            <td class="rating-cell" colspan="{{ count($section->ratingColumns) }}">-</td>
                        @endif
                    </tr>

                    @foreach ($subsection->items as $item)
                        <tr>
                            <td class="pl-12">{{ $item->name }}</td>
                            @if ($section->has_ratings && $subsection->has_ratings && $item->has_ratings)
                                @foreach ($section->ratingColumns as $column)
                                    <td class="rating-cell">
                                        @for ($i = 1; $i <= $column->max_rating; $i++)
                                            <span>{{ $i }}</span>
                                        @endfor
                                        <span>N/A</span>
                                    </td>
                                @endforeach
                            @elseif($section->has_ratings && $subsection->has_ratings)
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
