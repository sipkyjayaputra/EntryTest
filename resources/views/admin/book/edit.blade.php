<form class="form" method="post" action="{{ route('book.update', $book->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $book->title ?? '' }}" />
    </div>
    <div class="form-group">
        <label class="form-label">Publisher</label>
        <input type="text" class="form-control" name="publisher" placeholder="Publisher" id="publisher" value="{{ $book->publisher ?? '' }}" />
    </div>
    <div class="form-group">
        <label class="form-label">Year</label>
        <input type="text" name="year" id="year" class="form-control" placeholder="Year" value="{{ $book->year }}" />
    </div>
    <div class="form-group" id="form-author">
        <label class="form-label">Author</label>
        @foreach ($authors_list as $author)
            <select name="author_id[]" class="form-control author_id" id="{{ $author->author_id }}" >
                @foreach ($authors_option as $author_op)
                <option value="{{ $author_op->id }}" {{ ($author_op->id == $author->author_id ? 'selected' : '') }}>{{$author_op->name}}</option>
                @endforeach
            </select>
        @endforeach
    </div>
    <button id="add-author" class="btn btn-secondary btn-sm"><span class="fa fa-plus fa-sm"></span> Add Author</button>
</form>


<script type="text/javascript">
    $(".author_id").select2();
    document.getElementById('add-author').addEventListener('click', function(event) {
        event.preventDefault();
        const child = document.createElement('select');
        child.setAttribute('name', 'author_id[]');
        child.setAttribute('class', 'form-control author_id');
        const form = document.getElementById('form-author').appendChild(child);


        $('.author_id').select2({
        placeholder: 'Select an item',
        ajax: {
            url: '/book/list-author',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
            },
            cache: true
        }
        });
    });


    $('.author_id').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '/book/list-author',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
</script>
