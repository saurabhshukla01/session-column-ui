<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    @if (session('success'))
        <div class="alert alert-success">
            <b> {{ session('success') }} </b>
        </div>
        <br><br>
    @endif
    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="image">Profile Image:</label>
        <input type="file" name="image" id="image" accept="image/*"><br><br>

        <label for="mobile">Mobile Number:</label>
        <input type="tel" name="mobile" id="mobile" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" required><br><br>

        <label for="role">Select Role:</label>
        <select name="role" id="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>

    @if(session('userData'))
            <h2>Stored Data:</h2>
            <form action="{{ route('user.final') }}" method="post" enctype="multipart/form-data">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Image</th>
                        <th>DOB</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @csrf
                        @foreach(session('userData') as $key => $data)
                            <tr>
                                <td>{{ $data['name'] }}</td>
                                <td>{{ $data['mobile'] }}</td>
                                <td>{{ $data['role'] }}</td>
                                <td>{{ $data['image'] }}</td>
                                <td>{{ $data['dob'] }}</td>
                                <td>{{ $data['password'] }}</td>
                                <td>{{ $data['email'] }}</td>
                                <td>
                                    <a href="{{ route('editUser', ['id' => $key]) }}">Edit</a>
                                    <a href="{{ route('deleteUser', ['id' => $key]) }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
            <br>
            <input type="submit" value="Final Submit">
            </form>
        @endif

</body>
</html>
