<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\CoreRepository;

class UsersRepository extends CoreRepository
{

    /**
     * Get users with filter.
     *
     * @param  $name - name user
     * @param  $email - email user
     * @param  $date - start_date in table post_user
     * @param  $post_id - post id in table posts
     * @param  $post_name - name post in table posts
     * @param  $sort - sort by table users
     * @return array
     */

    public function getUsers($name, $email, $date, $post_id, $post_name, $sort)
    {
        $users = $this->startConditions()
            ->with(['posts' => function ($query) use ($date, $post_id, $post_name) {

                // if need filtered inside posts (depending on the task)

                //     // search by promotion date (filetred posts)
                //     if ($date) {
                //         $query->where('start_date', '<=', $date);
                //     }
                //     // search by post_id (filetred posts)
                //     if ($post_id) {
                //         $query->where('id', $post_id);
                //     }
                //     // search by post_name (filetred posts)
                //     if ($post_name) {
                //         $query->where('name', 'like', "%$post_name%");
                //     }

            }])
            // search by promotion date (filetred users)
            ->when($date, function ($query) use ($date) {
                $query->whereHas('posts', function ($query) use ($date) {
                    $query->where('start_date', '<=', $date);
                });
            })
            // search by post_id (filetred users)
            ->when($post_id, function ($query) use ($post_id) {
                $query->whereHas('posts', function ($query) use ($post_id) {
                    $query->where('id', $post_id);
                });
            })
            // search by post_name (filetred users)
            ->when($post_name, function ($query) use ($post_name) {
                $query->whereHas('posts', function ($query) use ($post_name) {
                    $query->where('name', 'like', "%$post_name%");
                });
            })
            // search by user name
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%$name%");
            })
            // search by user email
            ->when($email, function ($query) use ($email) {
                $query->where('email', 'like', "%$email%");
            })
            // sort
            ->when($sort, function ($query) use ($sort) {
                $query->orderBy($sort);
            }, function ($query) {
                $query->orderBy('id');
            })
            ->get();

        return $users;
    }

    /**
     * Get user by id.
     *
     * @param  Integer $id - id in table users
     * @param  Boolean $withPosts - is need to add posts
     * @return  object
     */

    public function getUser($id, $withPosts = false)
    {
        return $this->startConditions()
            ->when($withPosts, function ($query) {
                $query->with('posts');
            })
            ->findOrFail($id);
    }

    protected function getModelClass(): string
    {
        return User::class;
    }
}
