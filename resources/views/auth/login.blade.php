<form action="/login" method="post">
    @csrf
    <div>
        <label for="email">Email</label>
        <input type="text" name="email">
    </div>
    <br>
    <button>Login</button>
</form>
