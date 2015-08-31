<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_Users extends Controller_Admin_Common {
 
    /**
     * Users List Action
     */
    public function action_index()
    {
        // Load users list query
        $users = ORM::factory('User')
            ->reset(FALSE);
 
        // Create pagination object
        $pagination = Pagination::factory(array(
            'group' => 'default',
            'total_items' => $users->count_all(),
        ));
				//echo'<pre style="text-align:left;">';print_r($pagination);echo"</pre>";
        // Modify users list query
        $users = $users
            ->order_by('username', 'ASC')
            ->order_by('email', 'ASC')
            ->offset($pagination->offset)
            ->limit($pagination->items_per_page)
            ->find_all();
 
        // Set content template
        $this->template->set('content', View::factory('admin/users/list', array(
            'items' => $users,
            'pagination' => $pagination,
        )));
    }
 
    /**
     * Delete user action
     */
    public function action_delete()
    {
        // Get user id
        $user_id = $this->request->param('id');
        if (!$user_id)
        {
            throw new HTTP_Exception_404('User not found.');
        }
 
        // Get user
        $user = ORM::factory('User', $user_id);
        if (!$user->loaded())
        {
            throw new HTTP_Exception_404('User not found.');
        }
 
        // Set message
        Session::instance()
            ->set('message', __('User :user deleted successfully.', array(':user' => $user->username)))
            ->set('message_type', 'success');
 
        // Delete user
        $user->delete();
 
        // Redirect to base page
        HTTP::redirect($this->request->referrer());
    }
 
    /**
     * Create user action
     */
    public function action_new()
    {
        // New user
        $user = ORM::factory('User');
 
        // Roles list
        $roles = ORM::factory('Role')->order_by('name', 'ASC')->find_all();
 
        // Set content template
        $this->template->set('content', View::factory('admin/users/new', array(
            'item' => array_merge($user->as_array(), array('roles' => array())),
            'roles' => $roles,
        )));
    }
 
    /**
     * Edit user action
     *
     * @throws HTTP_Exception_404
     */
    public function action_edit()
    {

        // Get user id
        $user_id = $this->request->param('id');
        if (!$user_id)
        {
            throw new HTTP_Exception_404('User not found.');
        }
 
        // Get user
        $user = ORM::factory('User', $user_id);
        if (!$user->loaded())
        {
            throw new HTTP_Exception_404('User not found.');
        }
 
        // User roles
        $item['roles'] = array();
        foreach ($user->roles->find_all() as $role)
        {
            $item['roles'][] = $role->id;
        }
 
        // Roles list
        $roles = ORM::factory('Role')->order_by('name', 'ASC')->find_all();
 
        // Set content template
        $this->template->set('content', View::factory('admin/users/edit', array(
            'item' => array_merge($user->as_array(), $item),
            'roles' => $roles,
        )));
    }
 
    /**
     * Save user action
     *
     * @throws HTTP_Exception_404
     */
    public function action_save()
    {
        // Protect page
        if ($this->request->method() !== Request::POST)
        {
            throw new HTTP_Exception_404('Page not found.');
        }
 
        // Back
        if ($this->request->post('back'))
        {
            HTTP::redirect('/admin/users');
        }
 
        // create and configure form validation
        $post = Validation::factory($this->request->post())
            ->labels(array(
                'username' => __('User name'),
                'email' => __('Email'),
            ))
            ->rule('username', 'not_empty')
            ->rule('email', 'not_empty')
            ->rule('email', 'email');
 
        if (!empty($post['password']))
        {
            $post
                ->labels(array(
                    'password' => __('Password'),
                    'password_confirm' => __('Password confirm'),
                ))
                ->rule('password', 'not_empty')
                ->rule('password_confirm', 'not_empty')
                ->rule('password_confirm', 'matches', array(':validation', 'password', 'password_confirm'));
        }
 
        // check validation
        if ($post->check())
        {
            // store
            $data = $post->data();
 
            /** @var Model_User $user **/
            $user = ORM::factory('User', Arr::get($data, 'id'));
 
            // remove password if empty
            if (empty($data['password']))
            {
                unset($data['password']);
            }
 
            // update user
            $user->values($data, array('username', 'email', 'password'))->save();
 
            // remove all roles
            $user->remove('roles');
 
            // add new roles
            foreach (Arr::get($post, 'roles', array()) as $role)
            {
                $user->add('roles', $role);
            }
 
            // message
            Session::instance()
                ->set('message', __(Arr::get($post->data(), 'id') ? 'User updated successfully.' : 'User created successfully.'))
                ->set('message_type', 'success');
 
            // redirect to list page
            HTTP::redirect('admin/users');
        }
 
        // Roles list
        $roles = ORM::factory('Role')->order_by('name', 'ASC')->find_all();
 
        // Errors list
        View::set_global('errors', $post->errors('validation'));
 
        // Set content template
        $this->template->set('content', View::factory('admin/users/' . (Arr::get($post->data(), 'id') ? 'edit' : 'new'),
            array(
                'item' => $post->data(),
                'roles' => $roles,
            )
        ));
    }
} // End Admin Users
