<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST" action="{{ route('updateUser', ['index' => $index]) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="text" name="name" value="{{ $user['name'] }}" required><br><br>
        <input type="text" name="mobile" value="{{ $user['mobile'] }}" required><br><br>
        <input type="text" name="role" value="{{ $user['role'] }}" required><br><br>
        <input type="text" name="dob" value="{{ $user['dob'] }}" required><br><br>
        <input type="text" name="password" value="{{ $user['password'] }}" required><br><br>
        <input type="text" name="email" value="{{ $user['email'] }}" required><br><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
