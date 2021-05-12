<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;

        $qb = User::query();
        if ($request->has('q')){
            $qb->where('name','like','%'. $request->query('q'). '%');
        }

        if ($request->has('sortBy')){
            $qb->orderBy($request->query('sortBy'),$request->query('sort', 'DESC'));
        }
        $data = $qb->offset($offset)->limit($limit)->get();
        $data->each->setAppends(['full_name']);

        return response($data, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User;
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);
        $user->save();

        return response([
            "data"      => $user,
            "message"   => "Kullanıcı Eklendi !"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return response([
            "data"      => $user,
            "message"   => "Kullanıcı Güncellendi !"
        ], 20);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            "message"   => "Kullanıcı Silindi"
        ], 200);
    }

    public function custom1()
    {
        //$user2 = User::find(2);
        //UserResource::withoutWrapping();
        //return new UserResource($user2);
        $users = User::all();
        //return UserResource::collection($users);

        //return new UserCollection($users);
        return UserResource::collection($users)->additional([
            'meta' => [
                'total_users' => $users->count(),
                'custom' => 'value'
            ]
        ]);

    }
}
