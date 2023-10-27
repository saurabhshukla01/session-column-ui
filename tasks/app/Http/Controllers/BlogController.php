<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = [];
        $blogsCount = 0;
        $blogs = DB::table('blogs')->get();
        $blogsCount = DB::table('blogs')->count();
        return view('blog',compact('blogs','blogsCount'));
    }

    public function updateBlogData(Request $request)
    {
        // Receive and process the data sent from the client
        $requestData = $request->json()->all();
        // Divide the array into chunks of 3 keys each
        $chunkedData = array_chunk($requestData[0], 3);
        // Loop through the data chunks
        $rowData = [];
        foreach ($chunkedData as $key => $chunk) {
            $rowData[$key]['number_1'] = isset($chunk[0]) ? $chunk[0] : 0;
            $rowData[$key]['number_2'] = isset($chunk[1]) ? $chunk[1] : 0;
            $rowData[$key]['number_3'] = isset($chunk[2]) ? $chunk[2] : 0;
            $rowData[$key]['created_at'] = now();
            $rowData[$key]['updated_at'] = now();
        }
        if(!empty($rowData)){
            DB::table('blogs')->truncate();
            DB::table('blogs')->insert($rowData);
        }
        // Return a response to the client
        return response()->json(['message' => 'Data updated successfully']);
    }

//     public function updateBlogData(Request $request)
//     {
//         // Receive and process the data sent from the client
//         $requestData = $request->json()->all();
//         $chunkedData = array_chunk($requestData[0], 3);

//         // Iterate through the data chunks
//         foreach ($chunkedData as $chunk) {
//             // Define the keys for the data
//             $keys = ['number_1', 'number_2', 'number_3'];
//             $chValue = [isset($chunk[0]) ? $chunk[0] : 0 , isset($chunk[1]) ? $chunk[1] : 0 , isset($chunk[2]) ? $chunk[2] : 0];
//             // Create an associative array with keys and values
//             $data = array_combine($keys, $chValue);
// print_r($data);die;
//             // Check if the data already exists in the database
//             $existingBlog = DB::table('blogs')->where($data)->first();
// print_r($existingBlog);die;
//             if ($existingBlog) {
//                 // If the data exists, update it
//                 $existingBlog->update($data);
//             } else {
//                 // If the data doesn't exist, insert a new record
//                 DB::table('blogs')->insert($data);
//             }
//         }

//         // Return a response to the client
//         return response()->json(['message' => 'Data updated successfully']);
//     }


}
