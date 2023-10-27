<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function showForm(Request $request){
        return view('users');
    }

    public function storeData(Request $request)
    {
        // Validate and store data in the session
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $data = session('userData', []); // Retrieve the existing session data or initialize an empty array
        // Handle the uploaded image
        $imageName = "";
        if ($request->hasFile('image')) {
            $path = public_path('images/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($path, $imageName);
        }
        $newData = [
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'image' => $imageName,
            'role' => $request->input('role'),
            'dob' => $request->input('dob'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
        ];

        $data[] = $newData; // Add the new data to the array

        session()->put('userData', $data); // Store the updated array in the session

        return redirect()->route('user.form')->with('success', 'Data stored in session');
    }

    public function editUser($index)
    {
        $userData = session('userData', []);
        $user = $userData[$index] ?? null;
        return view('edit_user_form', compact('user', 'index'));
    }

    // public function updateUser(Request $request, $index)
    // {
    //     $data = $request->except('_token', '_method');
    //     $image = $request->file('image');
    //     $userData = session('userData', []);
    //     $userData[$index] = $data;
    //     // Check if there's an old image in the session
    //     if (isset($userData['image'])) {
    //         // Remove the old image (optional)
    //         // You can choose to delete the old image file from the server if needed
    //         // Example: Storage::disk('public')->delete($userData['image']);

    //         // Replace the old image with the new one
    //         // Here, we're storing the new image's file name in the session
    //         $userData['image'] = $image->store('images', 'public'); // Adjust the storage path as needed
    //     } else {
    //         // If no old image exists, store the new image in the session
    //         $userData['image'] = $image->store('images', 'public'); // Adjust the storage path as needed
    //     }

    //     session(['userData' => $userData]);
    //     return redirect()->route('user.form')->with('success', 'Data updated in session');
    // }

    public function updateUser(Request $request, $index)
    {
        $data = $request->except('_token', '_method');
        $image = $request->file('image');
        $userData = session('userData', []);

        // Check if there's an old image in the session
        if (isset($userData[$index]['image'])) {
            // Remove the old image (optional)
            $oldImagePath = public_path('images/') . $userData[$index]['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image file
            }

            // Store the new image
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            // Update the image path in the session
            $userData[$index]['image'] = $imageName;
        }

        // Update other data fields
        $userData[$index]['name'] = $data['name'];
        $userData[$index]['mobile'] = $data['mobile'];
        $userData[$index]['role'] = $data['role'];
        $userData[$index]['dob'] = $data['dob'];
        $userData[$index]['password'] = $data['password'];
        $userData[$index]['email'] = $data['email'];

        // Update the session data
        session(['userData' => $userData]);

        return redirect()->route('user.form')->with('success', 'Data updated in session');
    }


    public function deleteUser($index)
    {
        $userData = session('userData', []);
        unset($userData[$index]);
        session(['userData' => $userData]);
        return redirect()->route('user.form')->with('success', 'Data deleted from session');
    }

    public function finalData(Request $request)
    {
        $data = session()->get('userData'); 
        if(!empty($data)){
            foreach ($data as $user) {
                // Access data within the $data array
                $name = $user['name'] ?? "";
                $mobile = $user['mobile'] ?? "";
                $role = $user['role'] ?? "";
                $dob = $user['dob'] ?? "";
                $image = $user['image'] ?? "";
                $password = $user['password'] ?? "";
                $email = $user['email'] ?? ""; 
                $insertData = [];
                if($name != "" || $email != ""){
                    $insertData = [
                        "name" => $name,
                        "phone" => $mobile,
                        "role" => $role,
                        "date" => $dob,
                        "image" => $image,
                        "password" => $password,
                        "email" => $email,
                    ];
                }
                
                if(!empty($insertData)){
                    DB::table('users')->insert($insertData);
                }
            }
            $request->session()->forget('userData');
            return redirect()->route('user.form')->with('success', 'Data final submitted on table via final session data');
        }else{
            return redirect()->route('user.form')->with('success', 'Please fill data first');
        }
        
    }
}
