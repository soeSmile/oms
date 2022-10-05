<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class IndexController
 */
class IndexController
{
    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('web.login');
        }

        return redirect('/oms');
    }

    /**
     * @return Application|Factory|View
     */
    public function oms(): View|Factory|Application
    {
        return view('oms.index');
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function login(): View|Factory|RedirectResponse|Application
    {
        if (auth()->check()) {
            return redirect()->route('web.oms');
        }

        return view('auth.login');
    }
}
