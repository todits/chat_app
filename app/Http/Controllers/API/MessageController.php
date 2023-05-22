<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $fromMessages = Message::query()
            ->with(['from', 'to'])
            ->where('from', $user->id)
            ->where('to', auth()->id())

            // ->where('to')
            // ->where(function ($query) use ($user) {
            //     $query->where('from', $user->id)
            //         ->orWhere('to', auth()->id());
            // })
            // ->orWhere(function ($query) use ($user) {
            //     $query->where('from', auth()->id())
            //         ->orWhere('to',  $user->id);
            // })
            ->get();

        $toMessages = Message::query()
            ->with(['from', 'to'])
            ->where('from', auth()->id())
            ->where('to', $user->id)
            ->get();

        return $fromMessages->merge($toMessages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['from'] = auth()->id();
        $validated['to'] = $user->id;

        Message::create($validated);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
