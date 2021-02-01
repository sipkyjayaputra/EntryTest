<form class="form" method="post" action="/author/create">
    @csrf
    <div class="form-group">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
    </div>
    <div class="form-group">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" placeholder="Phone" id="phone" />
    </div>
    <div class="form-group">
        <label class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control" cols="30" rows="4" placeholder="Address"></textarea>
    </div>
</form>
