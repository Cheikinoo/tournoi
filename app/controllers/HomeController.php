<?php

class HomeController extends Controller
{
    public function index(): void
    {
        // Si déjà connecté → dashboard
        if (Auth::check()) {
            $this->redirect('dashboard');
        }

        // Sinon → landing page
        $this->view('home/index');
    }
}