<div class="" style="text-align:center">
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>Item</th>
            <td>{{ $book->title }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $book->publisher }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $book->year }}</td>
        </tr>
        <tr>
            <th>Author</th>
            <td>
                <ul>
                @foreach ($authors_list as $author)
                    <li>{{$author->authors->name}}</li>
                @endforeach
                </ul>
            </td>
        </tr>
    </table>
</div>
