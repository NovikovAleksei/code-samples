<?php

class DashboardController
{
    private string $layout = 'practitioner.layouts.dashboard';

    public function index()
    {
        $practitionerId = auth()->guard(GuardHelper::check())->user()->id;

        Log::channel('practitioner_general')->info('Dashboard is successfully loaded');
        return view($this->layout)->nest('page', 'practitioner.pages.dashboard', ['practitionerId' => $practitionerId]);
    }

    public function settings()
    {
        Log::channel('practitioner_general')->info('Settings is successfully loaded');
        return view($this->layout)->nest('page', 'practitioner.pages.settings.index');
    }
}