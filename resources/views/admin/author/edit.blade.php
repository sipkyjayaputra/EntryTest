<form class="form" method="post" action="{{ route('author.edit', $author->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $author->name ?? '' }}" />
    </div>
    <div class="form-group">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" placeholder="Phone" id="phone" value="{{ $author->phone ?? '' }}" />
    </div>
    <div class="form-group">
        <label class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control" cols="30" rows="4" placeholder="Address">{{ $author->address ?? '' }}</textarea>
    </div>
</form>
