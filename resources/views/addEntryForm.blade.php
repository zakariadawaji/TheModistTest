<form action="/add" method="post">
    @csrf
    <label for="fname" class="col-md-2 col-form-label">Amount</label>
    <input id="amount" type="number" class="form-control " name="amount" value="" required >
    <input type="submit" class="btn btn-primary" value="Submit">
    <input type="hidden" name="timestamp" value = '{{ $now }}' >
</form>
