<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActionRequest;
use App\Models\Action;

class ActionController extends Controller
{
    public function store(StoreActionRequest $request)
    {
        $validated = $request->validated();

        Action::create($validated);
    }

    public function destroy(Action $action)
    {
        $action->delete();
    }
}
