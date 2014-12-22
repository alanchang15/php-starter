<?php

class HomeController extends ControllerBase
{
    public function indexAction()
    {
        // $users = User::with('role')->get();
        // $users = Role::with('user')->get();

        // $data['users'] = $users;
        $data = array();

        View::display('home/index.twig', $data);
    }

    public function addAction()
    {
        echo 'add';
    }
}
