<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Get users with filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function index(Request $request)
    {
        $name = $request->input('name') ? $request->string('name')->trim() : null;
        $email = $request->input('email') ? $request->string('email')->trim() : null;
        $date = $request->date('date');
        $post_id =  $request->input('post_id') ? +$request->input('post_id') : null;
        $post_name = $request->input('post_name') ? $request->string('post_name')->trim() : null;
        $sort = $request->input('sort') ? $request->string('sort')->trim() : null;

        // sort only by fields in users table
        if ($sort && !in_array($sort, DB::getSchemaBuilder()->getColumnListing('users'))) $sort = null;

        try {
            $users = $this->usersRepository->getUsers($name, $email, $date, $post_id, $post_name, $sort);
            return response()->json($users);
        } catch (Exception $e) {
            // create log or something else
            throw ($e);
        }
    }

    public function store(Request $request)
    {
        // $user = new User([
        //     'name' => $request->input('name'),
        // ]);
        // $user->save();
        // return response()->json('User created!');
    }

    /**
     * Get user by id.
     *
     * @param  Integer $id
     * @param  \Illuminate\Http\Request  $request
     * @return  object
     */

    public function show($id, Request $request)
    {
        if (!is_numeric($id)) abort(404);
        $withPosts = $request->boolean('withPosts');

        try {
            $user = $this->usersRepository->getUser($id, $withPosts);
            return response()->json($user);
        } catch (Exception $e) {
            // create log or something else
            throw ($e);
        }
    }

    public function update($id, Request $request)
    {
        // $user = User::find($id);
        // $user->update($request->all());
        // return response()->json('User updated!');
    }

    public function destroy($id)
    {
        // $user = User::find($id);
        // $user->delete();
        // return response()->json('User deleted!');
    }
}
